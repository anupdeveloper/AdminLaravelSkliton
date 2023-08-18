<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{User,UserPurchaseSubscription};
use App\Traits\{OtpTrait,GeneralTrait};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Helper\Helper;
use DB;
use Carbon\Carbon;
use Config;

class AuthController extends Controller
{
    use OtpTrait, GeneralTrait;

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|digits:10',
            'username' => 'required|unique:users,username',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ],[
            'mobile.required'=>__('api.register.mobile.required'),
            'mobile.starts_with'=>__('api.register.mobile.starts_with'),
            'mobile.size'=>__('api.register.mobile.size'),
        ]);

       

        if($request->hasHeader('X-localization')) {
            $localization = $request->header('X-localization');
        } else {
            $localization = 'en';
        }
        
        try{
            $user = User::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'username' => $request->username,
                'email' => $request->email,
                'user_type' => $request->user_type ? $request->user_type : 'user',
                'password' => Hash::make($request->password),
                //'default_language' => $localization
            ]);

            $token = $user->createToken('user_token')->plainTextToken;
            $data = [
                'token' => $token,
            ];
            //dd($data);
            $message = 'You have registered successfully';
            return $this->__sendResponse(200,true,$message,$data);

        } catch(User $e) {
            $message = 'Please contact admin';
            return $this->__sendResponse(500,false,$message);   
        }


        
    }

    public function verifyOtp(Request $request)
    {


        // dd($request);
        $request->validate([
            'mobile' => 'required|exists:users,mobile|size:9',
            'otp' => 'required|size:4'
        ],[
            'mobile.required'=>__('api.verify_otp.mobile.required'),
            'mobile.exists'=>__('api.verify_otp.mobile.exists'),
            'mobile.size'=>__('api.verify_otp.mobile.size'),
            'otp.required'=>__('api.verify_otp.otp.required'),
        ]);

        $verfied_data = $this->_verifyOtp($request->mobile, $request->otp, $request->user_id);

        //dd($verfied_data);
        $user_id = Crypt::decryptString($request->user_id);

        $token_exits = User::where('device_token',$request->device_token)->count();
        if($token_exits>0) {

            // $users = User::where('mobile',$request->mobile)->get();
            // if($users) {
            //     foreach($users as $usr) {
            //         $usr->tokens()->delete();
            //     }
            // }
            

            User::where('device_token',$request->device_token)->update([
                'device_token'=>'',
            ]);
            User::where('id', $user_id)->update([
                'device_type'=>$request->device_type,
                'device_token'=>$request->device_token
            ]);
        } else{
            User::where('id', $user_id)->update([
                'device_type'=>$request->device_type,
                'device_token'=>$request->device_token
            ]);
        }
        // @ all other user logout
        $users = User::where('mobile',$request->mobile)->get();
        if($users) {
            foreach($users as $usr) {
                $usr->tokens()->delete();
            }
        }

        if (!$verfied_data['success']) {
            return $verfied_data;
        }
        // $user = User::where('mobile', $request->mobile)->first();
        $user=$verfied_data['user'];
        //dd($user);
        
        

        if($request->hasHeader('X-localization')) {
            $localization = $request->header('X-localization');
        } else {
            $localization = 'en';
        }
        //update default lag
        User::where('id', $user_id)->update([
            'default_language' => $localization,
            'device_type'=>$request->device_type,
        ]);
        
        $user_accounts_count = User::where('mobile', $request->mobile)->count();
        //dd($user_accounts_count);
        if($user_accounts_count == 1) {

            // check for all required information avaliable or not
            $is_all_required_fields = Helper::check_all_required_fields($user->id);
            $user=$verfied_data['user'];
            $user_id = $user->id;
            $has_active_subscription = UserPurchaseSubscription::where('user_id',$user_id)
                    ->where('payment_type','subscription')
                    ->where('status','active')
                    ->count();
            // Send payment link in sms
            if($has_active_subscription == 0) { // if user has no subscrition // $has_active_subscription == 0
                $encrypted_user_id = Crypt::encryptString($user_id);
                //$short_payment_url = route('get_subscripton',[$encrypted_user_id]);
                
                if(Config::get('app.env') == 'production') {
                    $short_payment_url = Config::get('app.site_url') . '/get-subscription/'. $encrypted_user_id;
                } else {
                    $short_payment_url = Config::get('app.url') . '/get-subscription/'. $encrypted_user_id;
                }
                $to = $user->mobile; //$to = '506208358';
                $id = DB::table('payment_url')->insertGetId(
                    [
                        'payment_url' => $short_payment_url,
                        'user_id' => $user_id,
                        'payment_type' => 'subscription',
                        'expiry_date' => Carbon::now()->addMinutes(30),
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );                
                $rand = $id.'-'.substr(md5(microtime()),rand(0,26),2).'-'.substr(md5(microtime()),rand(0,26),3);
                //$short_payment_url = route('pay',[$rand]);
                //$short_payment_url = 'https://awaser.sa/pay/'.$rand;
                //$short_payment_url = Config::get('app.site_url') . '/pay/' .$rand;
                //dd($short_payment_url);
                if(Config::get('app.env') == 'production') {
                    //dd('gg');
                    $short_payment_url = Config::get('app.site_url') . '/pay/' .$rand;
                } else {
                    //dd('tt');
                    $short_payment_url = Config::get('app.url') . '/pay/' .$rand;
                    //dd($short_payment_url);
                }
                $payment_link = $short_payment_url;
                $prefered_lag = $user->default_language ? $user->default_language : 'en';
                //$prefered_lag = 'ar';
                if($prefered_lag == 'en') {
                    $type = 3;
                    $message_payment = trans('api.common.message_payment' ,['attribute'=>$payment_link],'en');
                } else {
                    $type = 4; // 1 no msg // 4 rubbish / 2 noting // 3 nothing
                    $message_payment = trans('api.common.message_payment' ,['attribute'=>$payment_link],'ar');
                }
                //dd($message_payment);
                if($to) {
                    //$to = '553240008'; //506208358
                    Helper::sendSms($message_payment,$to,$type);
                }
                
            }

            /*
            if(!$is_all_required_fields) {
                $data['success'] = false;
                $data['message'] = __('api.login.mobile_no_is_not_registered_with_us');//__('message.account.your_account_is_in_complete');
                $data['single_account'] = true;
                $logdata = [
                    'request_data' => $request->all(),
                    'response_data' => $data
                ];
                Helper::save_api_logs($logdata);
                return $data;
            }
            */

            $format_data=[
                "is_all_required_fields" => $is_all_required_fields, //false => mendatory field not filled
                "name"=>$user->user_default_info->name??'',
                "family_name"=>$user->family_name,
                "username"=>$user->username??'',
                "gender"=>$user->user_default_info->gender_obj??'',
                "age"=>$user->user_default_info->age_obj??'',
                "status"=>$user->user_default_info->status??'',
                "about_me"=>$user->user_default_info->bio??'',
                "nationality"=>$user->user_default_info->nationality_detail??'',
                "current_count_of_residence"=>$user->user_default_info->nationality_current_detail??'',
                "region"=>$user->live_in_region_detail??'',
                "city"=>$user->user_default_info->live_in_city_detail??'',
                "family_origin_region"=>$user->family_origin_region??'',
                "family_origin_city"=>$user->family_origin_city??'',
                "family_origin"=>$user->family_origin_detail,
                "marital_status"=>$user->user_default_info->currently_married??'',
                "height"=>$user->user_default_info->height_obj??'',
                "skin_color"=>$user->user_default_info->skin_detail??'',
                "education"=>$user->user_default_info->education_detail??'',
                "work"=>$user->user_default_info->work_detail??'',
                "headwear_preference"=>$user->user_default_info->hijab_detail??'',
                "tribal"=>$user->is_tribal_obj??'',
                "tribe"=>$user->tribe_detail??'',
                "sect_detail"=>$user->sect_detail??'',
                "care_about_tribalism"=>"",
                "marriage_flexibility"=>$user->user_default_info->does_she_or_he_has_flexibility_to_marry_a_married_man??'',
                "connection_setting"=>Helper::get_connection_limits($user->id,$user->account_type_id),
                "has_subscription"=>$has_active_subscription ? true : false
                //"profile_images" => Helper::get_profile_images($user),
            ];
            if(!empty($user)) {
                if($user->account_type_id == 1) {
                    $user->family_members_male_count = $user->members()->where('gender', 'male')->count();
                    $user->family_members_female_count = $user->members()->where('gender', 'female')->count();
                }
                $user->connection_setting = Helper::get_connection_limits($user->id,$user->account_type_id);
                $user->profile_images = Helper::get_profile_images($user);
                $user->can_add_member_maximum = Helper::can_add_member_maximum($user->id,$user->account_type_id);
            }
            //$verfied_data['yellow_connections'] = 15;
            //$verfied_data['red_connections'] = 8;
            $verfied_data['format_data']=$format_data;
            $verfied_data['single_account'] = true;
            $verfied_data['has_subscription'] = $has_active_subscription ? true : false;
            $verfied_data['user_id'] = $request->user_id;
            $verfied_data['token'] = $user->createToken('user_token')->plainTextToken;
            $logdata = [
                'request_data' => $request->all(),
                'response_data' => $verfied_data
            ];
            Helper::save_api_logs($logdata);
            return $verfied_data;
        } else {
            $data = [];
            $accounts = User::with('account_type','profile_images_list','members','members.profile_images_list','user_default_info','members.sect_detail')->where('mobile', $request->mobile)->where('account_type_id', '!=', NULL)->get();
            if(count($accounts)) {
                foreach($accounts as $account) {

                    // check for all required information avaliable or not
                    $is_all_required_fields = Helper::check_all_required_fields($account->id); //false => mendatory field not filled
                    $account->is_all_required_fields = $is_all_required_fields;
                    $has_active_subscription = UserPurchaseSubscription::where('user_id',$account->id)
                    ->where('payment_type','subscription')
                    ->where('status','active')
                    ->count();
                    $account->has_subscription = $has_active_subscription ? true : false;
                    $account->family_members_male_count = $user->members()->where('gender', 'male')->count();
                    $account->family_members_female_count = $user->members()->where('gender', 'female')->count();
                    $account->profile_images = Helper::get_profile_images($account); //$user->profile_images()->get();
                    $account->connection_setting = Helper::get_connection_limits($user->id,$user->account_type_id);
                    $account->can_add_member_maximum = Helper::can_add_member_maximum($user->id,$user->account_type_id);
                }

                $user=$verfied_data['user'];
                $data['success'] = $verfied_data['success'];
                $data['message'] = $verfied_data['message'];
                $data['single_account'] = false;
                $data['accounts'] = $accounts;
                $data['token'] = $user->createToken('user_token')->plainTextToken;
                $data['user_id'] = $request->user_id;
                $logdata = [
                    'request_data' => $request->all(),
                    'response_data' => $data
                ];
                Helper::save_api_logs($logdata);
                return $data;
            } else {
                /*
                $data['success'] = false;
                $data['message'] = __('api.login.mobile_no_is_not_registered_with_us');//__('message.account.your_account_is_in_complete');
                $data['single_account'] = false;
                $logdata = [
                    'request_data' => $request->all(),
                    'response_data' => $data
                ];
                Helper::save_api_logs($logdata);
                return $data;
                */
            }

            
        }
        
        
    }


    public function resendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|starts_with:5|size:9',
        ],[
            'mobile.required'=>__('api.resend_otp.mobile.required'),
            'mobile.starts_with'=>__('api.resend_otp.mobile.starts_with'),
            'mobile.size'=>__('api.resend_otp.mobile.size'),
            
        ]);

        $user = User::where('mobile', $request->mobile)->first();
        $otp_ob = $this->_sendOtp($user);

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => $otp_ob
        ];
        Helper::save_api_logs($logdata);

        return ($otp_ob);
    }

    public function login(Request $request)
    {
        $request->validate([
            //'username'=>'required|exists:users,username',
            'username'=>'required',
            'password'=>'required',
        ],
        [
            //'mobile.required' => __('api.login.enter_your_phone_number'),
            //'mobile.starts_with' => __('api.login.mobile_number_must_start_with_05'),
            //'mobile.digits' => __('api.login.mobile_number_consists_of_10_digits'),
            //'password.required' => 'Password field is required',
        ]);

        $user = User::where('username', $request->username)->first();
        // @ check if user exists
        $user_count = User::where('username', $request->username)
                            ->whereNotNull('username')
                            //->whereNotNull('email')
                            ->count();
        //dd($user_count);                    
        if($user_count == 0) {
            $message = __('api.login.mobile_no_is_not_registered_with_us');
            return $this->__sendResponse(500,false,$message);
        }
        

        if (!$user) {
            $message = __('api.login.mobile_no_is_not_registered_with_us');
            return $this->__sendResponse(500,false,$message);
        }

        if($user) {
            if($user->user_type == 'admin') {
                $message = __('api.login.mobile_no_is_not_registered_with_us');
                return $this->__sendResponse(200,true,$message);
            }

            $credentials = array('username' => $request->username , 'password' => $request->password);
            $attempt = Auth::attempt($credentials);
            if ($attempt) {
            
                User::where('id', $user->id)->update([
                    'device_type' => $request->device_type
                ]);
                $token = $user->createToken('user_token')->plainTextToken;
                $data = [
                    'name' => $user->name,
                    'username' => $user->username,
                    'phone' => $user->mobile,
                    'user_type' => $user->user_type,
                    'email' => $user->email,
                    'token' => $token,
                ];
                //dd($data);
                $message = 'You have logged in successfully.';
                return $this->__sendResponse(200,true,$message,$data);

            } else {
                $message = 'Wrong Username Or Password';
                return $this->__sendResponse(200,false,$message);
            }
           
        }
        
    }

    public function logout(Request $request)
    {
        $user= $request->user();
        // delete all toekens belong to user
        $user->tokens()->delete();
        $user->update([
            'device_token' => ''
        ]);

        $message = __('api.logout.success');
        $message_data = Helper::getMessageByCode('NOT017');  
        $message_text_en = $message_data ? $message_data->message_value_en : $message;
        $message_text_ar = $message_data ? $message_data->message_value_ar: $message;

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('success'=>true,
            'message' => $message_text_en,
            'message_ar' => $message_text_ar)
        ];
        Helper::save_api_logs($logdata);

        return [
            'success'=>true,
            'message' => $message_text_en,
            'message_ar' => $message_text_ar
        ];
    }

    public function select_account(Request $request,$account_id,$device_type = null,$device_token = null)
    {
        $logged_in_user =  $request->user();

        $logged_in_user->currentAccessToken()->delete();
        $user = User::where('mobile', $logged_in_user->mobile)->where('id', $account_id)->first();
        // $user_id = Crypt::decryptString($request->user_id);
        // User::where('id', $account_id)->update([
        //     'device_type'=>'',
        //     'device_token'=>$request->device_token
        // ]);
        $has_active_subscription = UserPurchaseSubscription::where('user_id',$account_id)
                    ->where('payment_type','subscription')
                    ->where('status','active')
                    ->count();
        $user_id = $account_id;           
        // Send payment link in sms
        if($has_active_subscription == 0) { // if user has no subscrition
            $encrypted_user_id = Crypt::encryptString($user_id);
            //$short_payment_url = route('get_subscripton',[$encrypted_user_id]);
            //$short_payment_url = Config::get('app.url') . '/get-subscription/'. $encrypted_user_id;
            if(Config::get('app.env') == 'production') {
                //dd('gg');
                $short_payment_url = Config::get('app.site_url') . '/get-subscription/' .$encrypted_user_id;;
            } else {
                //dd('tt');
                $short_payment_url = Config::get('app.url') . '/get-subscription/' .$encrypted_user_id;
                //dd($short_payment_url);
            }
            $to = $user->mobile;
            $id = DB::table('payment_url')->insertGetId(
                [
                    'payment_url' => $short_payment_url,
                    'user_id' => $user_id,
                    'payment_type' => 'subscription',
                    'expiry_date' => Carbon::now()->addMinutes(30),
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
            //$payment_link = '<a target="_blank" href="'.$short_payment_url.'">'.trans('api.common.click_here').'</a>';
            $rand = $id.'-'.substr(md5(microtime()),rand(0,26),2).'-'.substr(md5(microtime()),rand(0,26),3);
            //$short_payment_url = route('pay',[$rand]);
            //$short_payment_url = '&lt;br&gt;https://awaser.sa/pay/'.$rand;
            //$short_payment_url = Config::get('app.url') . '/pay/' .$rand;
            if(Config::get('app.env') == 'production') {
                //dd('gg');
                $short_payment_url = Config::get('app.site_url') . '/pay/' .$rand;
            } else {
                //dd('tt');
                $short_payment_url = Config::get('app.url') . '/pay/' .$rand;
                //dd($short_payment_url);
            }
            $payment_link = $short_payment_url;
            $prefered_lag = $user->default_language ? $user->default_language : 'en';
            if($prefered_lag == 'en') {
                $type = 3;
                $message_payment = trans('api.common.message_payment' ,['attribute'=>$payment_link],'en');
            } else {
                $type = 4;
                $message_payment = trans('api.common.message_payment' ,['attribute'=>$payment_link],'ar');
            }
            //dd($message_payment);
            if($to) {
                Helper::sendSms($message_payment,$to,$type);
            }
        }

        if($request->hasHeader('X-localization')) {
            $localization = $request->header('X-localization');
        } else {
            $localization = 'en';
        }
        //update default lag
        User::where('id', $account_id)->update([
            'default_language' => $localization,
            'device_type' => $device_type,
            'device_token' => $device_token
        ]);
        //dd($request->device_type);
        $token = $user->createToken('user_token')->plainTextToken;
        $user_subs = UserPurchaseSubscription::where('user_id',$account_id)->where('status','active')->first();
        if($user_subs) {
           $has_active_subscription = true;
        } else {
            $has_active_subscription = false;
        }
        
        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('success' => true,
            'user_id' => Crypt::encryptString($account_id),
            'token'=>$token,
            'has_active_subscription' => $has_active_subscription ,
            'can_add_member_maximum' => Helper::can_add_member_maximum($account_id,$user->account_type_id))
        ];
        Helper::save_api_logs($logdata);

        $res = [
            'success' => true,
            'user_id' => Crypt::encryptString($account_id),
            'token'=>$token,
            'has_active_subscription' => $has_active_subscription ,
            'can_add_member_maximum' => Helper::can_add_member_maximum($account_id,$user->account_type_id)
        ];
        return $res;
    }
}
