<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\UserTemp;
use App\Models\HyperPaymentNotification;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\{Transaction, AccountType, User, UserFamily, Country, SkinColor, MasterEducational, MasterWork, MasterSect, MasterTribe, HijabType, PersonalityDimension, UserPersonalityDimension, UserFamilyPersonalityDimension};
use App\Models\UserPurchaseSubscription;
use App\Helper\Helper;
use Devinweb\LaravelHyperpay\Facades\LaravelHyperpay;
use Illuminate\Support\Str;
use App\Billing\HyperPayBilling;
use DB;
use Illuminate\Support\Facades\Crypt;
use Validator;
use Redirect;;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use QrCode;
use App;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use App\Traits\OtpTrait;
use App\Rules\AlphaNumaric;
use App\Rules\StrMaxNumber;
use Storage;
use Config;

class HomeController extends Controller
{
    use OtpTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function signup(Request $request)
    {
        $data = [];
        session()->forget('signup');
        session()->forget('success-redirect');
        return view('signup', ['data' => $data]);
    }

    public function verify_otp(Request $request)
    {
        $data = [];
        //session()->forget('signup');
        return view('signup', ['data' => $data]);
    }

    public function register(Request $request)
    {
        //dd('hi');
        $request->validate([
            'mobile' => 'required|starts_with:5|size:9'
        ], [
            'mobile.required' => __('api.register.mobile.required'),
            'mobile.starts_with' => __('api.register.mobile.starts_with'),
            'mobile.size' => __('api.register.mobile.size'),
        ]);

        $user = User::where('mobile', $request->mobile)->first();
        if ($user) {

            if ($user->is_admin == 1) {
                throw ValidationException::withMessages(['mobile' => __('api.login.this_phone_number_is_used_as_admin')]);
            }
        }
        // @create new user
        // if (!$user) {
        //     $user = User::create([
        //         'mobile' => $request->mobile,
        //         'password' => Hash::make($this->__generateOtpNumber())
        //     ]);
        // }

        if ($request->hasHeader('X-localization')) {
            $localization = $request->header('X-localization');
        } else {
            $localization = 'en';
        }

        /*
        $user = User::create([
            'mobile' => $request->mobile,
            'password' => Hash::make($this->__generateOtpNumber()),
            'default_language' => $localization
        ]);
        DB::table('users')->where('id', $user->id)->update(
            [
                'default_language' => App::getLocale()
            ]
        );
        $user = User::where('id', $user->id)->first();
        */
        $user = UserTemp::create([
            'mobile' => $request->mobile,
            'password' => Hash::make($this->__generateOtpNumber()),
            'default_language' => $localization
        ]);
        //dd($user->id);
        UserTemp::where('id', $user->id)->update(
            [
                'default_language' => App::getLocale()
            ]
        );
        $user = UserTemp::where('id', $user->id)->first();
        //dd($user);
        //@ send otp to this mobile
        $otp_ob = $this->_sendOtpNewUser($user);
        $logdata = [
            'request_data' => $request->all(),
            'response_data' => $otp_ob
        ];
        Helper::save_api_logs($logdata);
        session()->put('signup', ['otp' => $otp_ob, 'mobile' => $request->mobile]);
        return redirect()->route('verify_otp');
    }

    public function verifyOtp(Request $request)
    {
        //dd($request);        
        $request->validate([
            'mobile' => 'required|exists:users,mobile|size:9',
            'otp' => 'required|size:4'
        ], [
            'mobile.required' => __('api.verify_otp.mobile.required'),
            'mobile.exists' => __('api.verify_otp.mobile.exists'),
            'mobile.size' => __('api.verify_otp.mobile.size'),
            'otp.required' => __('api.verify_otp.otp.required'),
        ]);

        $verfied_data = $this->_verifyOtp($request->mobile, $request->otp, $request->user_id);

        //dd($verfied_data);
        $user_id = Crypt::decryptString($request->user_id);
        DB::table('users')->where('id', $user_id)->update(
            [
                'default_language' => App::getLocale()
            ]
        );

        $token_exits = User::where('device_token', $request->device_token)->count();
        if ($token_exits > 0) {

            // $users = User::where('mobile',$request->mobile)->get();
            // if($users) {
            //     foreach($users as $usr) {
            //         $usr->tokens()->delete();
            //     }
            // }
            User::where('device_token', $request->device_token)->update([
                'device_token' => '',
            ]);
            User::where('id', $user_id)->update([
                'device_type' => '',
                'device_token' => $request->device_token
            ]);
        } else {
            User::where('id', $user_id)->update([
                'device_type' => '',
                'device_token' => $request->device_token
            ]);
        }
        // @ all other user logout
        $users = User::where('mobile', $request->mobile)->get();
        if ($users) {
            foreach ($users as $usr) {
                $usr->tokens()->delete();
            }
        }

        if (!$verfied_data['success']) {
            throw ValidationException::withMessages(['otp' => $verfied_data['message']]);
        }
        // $user = User::where('mobile', $request->mobile)->first();
        $user = $verfied_data['user'];
        //dd($user);
        if ($request->hasHeader('X-localization')) {
            $localization = $request->header('X-localization');
        } else {
            $localization = 'en';
        }
        //update default lag
        User::where('id', $user_id)->update([
            'default_language' => $localization
        ]);

        $user_accounts_count = User::where('mobile', $request->mobile)->count();
        //dd($user_accounts_count);
        if ($user_accounts_count == 1) {

            $user = $verfied_data['user'];
            $user_id = $user->id;
            $has_active_subscription = UserPurchaseSubscription::where('user_id', $user_id)
                ->where('payment_type', 'subscription')
                ->where('status', 'active')
                ->count();
            // Send payment link in sms
            if ($has_active_subscription == 0) { // if user has no subscrition
                $encrypted_user_id = Crypt::encryptString($user_id);
                $short_payment_url = route('get_subscripton', [$encrypted_user_id]);
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
                $rand = $id . '-' . substr(md5(microtime()), rand(0, 26), 2) . '-' . substr(md5(microtime()), rand(0, 26), 3);
                $short_payment_url = route('pay', [$rand]);
                $payment_link = $short_payment_url;
                $prefered_lag = $user->default_language ? $user->default_language : 'en';
                if ($prefered_lag == 'en') {
                    $type = 3;
                    $message_payment = trans('api.common.message_payment', ['attribute' => $payment_link], 'en');
                } else {
                    $type = 4;
                    $message_payment = trans('api.common.message_payment', ['attribute' => $payment_link], 'ar');
                }
                //dd($message_payment);
                if ($to) {
                    //Helper::sendSms($message_payment, $to, $type);
                }
            }
            $format_data = [
                "name" => $user->user_default_info->name ?? '',
                "family_name" => $user->family_name,
                "username" => $user->username ?? '',
                "gender" => $user->user_default_info->gender_obj ?? '',
                "age" => $user->user_default_info->age_obj ?? '',
                "status" => $user->user_default_info->status ?? '',
                "about_me" => $user->user_default_info->bio ?? '',
                "nationality" => $user->user_default_info->nationality_detail ?? '',
                "current_count_of_residence" => $user->user_default_info->nationality_current_detail ?? '',
                "region" => $user->live_in_region_detail ?? '',
                "city" => $user->user_default_info->live_in_city_detail ?? '',
                "family_origin_region" => $user->family_origin_region ?? '',
                "family_origin_city" => $user->family_origin_city ?? '',
                "family_origin" => $user->family_origin_detail,
                "marital_status" => $user->user_default_info->currently_married ?? '',
                "height" => $user->user_default_info->height_obj ?? '',
                "skin_color" => $user->user_default_info->skin_detail ?? '',
                "education" => $user->user_default_info->education_detail ?? '',
                "work" => $user->user_default_info->work_detail ?? '',
                "headwear_preference" => $user->user_default_info->hijab_detail ?? '',
                "tribal" => $user->is_tribal_obj ?? '',
                "tribe" => $user->tribe_detail ?? '',
                "sect_detail" => $user->sect_detail ?? '',
                "care_about_tribalism" => "",
                "marriage_flexibility" => $user->user_default_info->does_she_or_he_has_flexibility_to_marry_a_married_man ?? '',
                "connection_setting" => Helper::get_connection_limits($user->id, $user->account_type_id),
                //"profile_images" => Helper::get_profile_images($user),
            ];
            if (!empty($user)) {
                if ($user->account_type_id == 1) {
                    $user->family_members_male_count = $user->members()->where('gender', 'male')->count();
                    $user->family_members_female_count = $user->members()->where('gender', 'female')->count();
                }
                $user->connection_setting = Helper::get_connection_limits($user->id, $user->account_type_id);
                $user->profile_images = Helper::get_profile_images($user);
                $user->can_add_member_maximum = Helper::can_add_member_maximum($user->id, $user->account_type_id);
            }
            //$verfied_data['yellow_connections'] = 15;
            //$verfied_data['red_connections'] = 8;
            $verfied_data['format_data'] = $format_data;
            $verfied_data['single_account'] = true;
            $verfied_data['user_id'] = $request->user_id;
            $verfied_data['token'] = $user->createToken('user_token')->plainTextToken;
            //dd('yes');
            //return $verfied_data;
            session()->forget('signup');
            session()->put('login_success', $verfied_data);
            return redirect()->route('start_registration');
        } else {
            $data = [];
            $accounts = User::with('account_type', 'profile_images_list', 'members', 'members.profile_images_list', 'user_default_info', 'members.sect_detail')->where('mobile', $request->mobile)->get();
            if (count($accounts)) {
                foreach ($accounts as $account) {
                    $account->family_members_male_count = $user->members()->where('gender', 'male')->count();
                    $account->family_members_female_count = $user->members()->where('gender', 'female')->count();
                    $account->profile_images = Helper::get_profile_images($account); //$user->profile_images()->get();
                    $account->connection_setting = Helper::get_connection_limits($user->id, $user->account_type_id);
                    $account->can_add_member_maximum = Helper::can_add_member_maximum($user->id, $user->account_type_id);
                }
            }
            $user = $verfied_data['user'];
            $data['success'] = $verfied_data['success'];
            $data['message'] = $verfied_data['message'];
            $data['single_account'] = false;
            $data['accounts'] = $accounts;
            $data['token'] = $user->createToken('user_token')->plainTextToken;
            $data['user_id'] = $request->user_id;
            session()->forget('signup');
            session()->put('login_success', $data);
            return redirect()->route('start_registration');
        }
    }

    public function verifyOtpNewUser(Request $request)
    {
        //dd($request);        
        $request->validate([
            'mobile' => 'required|size:9',
            'otp' => 'required|size:4'
        ], [
            'mobile.required' => __('api.verify_otp.mobile.required'),
            'mobile.exists' => __('api.verify_otp.mobile.exists'),
            'mobile.size' => __('api.verify_otp.mobile.size'),
            'otp.required' => __('api.verify_otp.otp.required'),
        ]);

        $verfied_data = $this->_verifyOtpNewUser($request->mobile, $request->otp, $request->user_id);

        //dd($verfied_data);
        $user_id = Crypt::decryptString($request->user_id);
        DB::table('users_temp')->where('id', $user_id)->update(
            [
                'default_language' => App::getLocale()
            ]
        );

        $token_exits = UserTemp::where('device_token', $request->device_token)->count();
        if ($token_exits > 0) {

            // $users = User::where('mobile',$request->mobile)->get();
            // if($users) {
            //     foreach($users as $usr) {
            //         $usr->tokens()->delete();
            //     }
            // }
            UserTemp::where('device_token', $request->device_token)->update([
                'device_token' => '',
            ]);
            UserTemp::where('id', $user_id)->update([
                'device_type' => '',
                'device_token' => $request->device_token
            ]);
        } else {
            UserTemp::where('id', $user_id)->update([
                'device_type' => '',
                'device_token' => $request->device_token
            ]);
        }
        // @ all other user logout
        $users = UserTemp::where('mobile', $request->mobile)->get();
        if ($users) {
            foreach ($users as $usr) {
                $usr->tokens()->delete();
            }
        }

        if (!$verfied_data['success']) {
            throw ValidationException::withMessages(['otp' => $verfied_data['message']]);
        }
        // $user = User::where('mobile', $request->mobile)->first();
        $user = $verfied_data['user'];
        //dd($user);
        if ($request->hasHeader('X-localization')) {
            $localization = $request->header('X-localization');
        } else {
            $localization = 'en';
        }
        //update default lag
        UserTemp::where('id', $user_id)->update([
            'default_language' => $localization
        ]);

        $user_accounts_count = UserTemp::where('mobile', $request->mobile)->count();
        //dd($user_accounts_count);
        if ($user_accounts_count == 1) {

            $user = $verfied_data['user'];
            $user_id = $user->id;
            
            
            $format_data = [
                "name" => $user->name ?? '',
                "username" => $user->username ?? '',
                "gender" => $user->user_default_info->gender_obj ?? '',
                "age" => $user->user_default_info->age_obj ?? '',
                "status" => $user->user_default_info->status ?? '',
            ];
            $verfied_data['format_data'] = $format_data;
            $verfied_data['single_account'] = true;
            $verfied_data['user_id'] = $request->user_id;
            $verfied_data['token'] = $user->createToken('user_token')->plainTextToken;
            //dd('yes');
            //return $verfied_data;
            session()->forget('signup');
            session()->put('login_success', $verfied_data);
            return redirect()->route('start_registration');
        } else {
            $data = [];
            $accounts = UserTemp::where('mobile', $request->mobile)->get();
            $user = $verfied_data['user'];
            $data['success'] = $verfied_data['success'];
            $data['message'] = $verfied_data['message'];
            $data['single_account'] = false;
            $data['accounts'] = $accounts;
            $data['token'] = $user->createToken('user_token')->plainTextToken;
            $data['user_id'] = $request->user_id;
            session()->forget('signup');
            session()->put('login_success', $data);
            return redirect()->route('start_registration');
        }
    }

    public function resendOtp(Request $request)
    {
        if (session()->has('signup')) {
            $user = UserTemp::where('mobile', session()->get('signup')['mobile'])->first();
            if(isset($user))
            {
                //@ send otp to this mobile
                $otp_ob = $this->_sendOtpNewUser($user);
            }
            else
            {
                $user = User::where('mobile', session()->get('signup')['mobile'])->first();
                //dd($user);
                $otp_ob = $this->_sendOtp($user);
            }
            session()->put('signup', ['otp' => $otp_ob, 'mobile' => session()->get('signup')['mobile']]);           
        }
        return redirect()->route('verify_otp')->with('success', trans('app.otp_sent'));
    }

    public function start_registration(Request $request)
    {
        if(session()->has('login_success'))
        {
            return view('start-registration');
        }
        else
        {
            return redirect()->route('signup');
        }
    }

    public function setUserInfo(Request $request)
    {   // registration steps
        //dd($request->all());
        if(session()->has('login_success'))
        {
            //dd('hi');
            if(isset(session()->get('login_success')['accounts']))
            {
                //dd('hi3');
                $count = count(session()->get('login_success')['accounts']);
                $user_session = session()->get('login_success')['accounts'][$count-1];
            }
            else
            {
                //dd('hi4');
                $user_session = session()->get('login_success')['user'];
                //dd($user);
            }   
            //dd($user->id);  
            //dd($user_session->id);    
            $user = UserTemp::whereId($user_session->id)->count();
            //dd($user);
            if($user==0) {
                if ($request->hasHeader('X-localization')) {
                    $localization = $request->header('X-localization');
                } else {
                    $localization = 'en';
                }
                $user = UserTemp::create([
                    'mobile' => $user_session->mobile,
                    'password' => Hash::make($this->__generateOtpNumber()),
                    'default_language' => $localization
                ]);
                //dd($user->id);
                UserTemp::where('id', $user->id)->update(
                    [
                        'default_language' => App::getLocale()
                    ]
                );
                $user = UserTemp::where('id', $user->id)->first();
            } else {
                $user = UserTemp::whereId($user_session->id)->first();
            }
           
        }
        else
        {
            return redirect()->route('signup');
        }
        //dd($user);
        // return $user;

        // return $request;
        // @ username fields
        
        if (!$user->username) {
            $request->validate([
                //'name'=>'required|min:4|max:20',
                'username' => ['required', 'starts_with:@', 'unique:users,username,' . $user->id, new StrMaxNumber(4)]
            ], [
                //'name.required'=>__('api.set_profile_info.form_fields.name.required'),
                //'name.max'=>__('api.set_profile_info.form_fields.name.max'),
                //'name.min'=>__('api.set_profile_info.form_fields.name.min'),
                'username.required' => __('api.set_profile_info.form_fields.username.required'),
                'username.unique' => __('api.set_profile_info.form_fields.username.unique'),
                'username.starts_with' => __('app.starts_with'),
            ]);
            $user_dt = User::where('username', $request->username)->first();
            if ($user_dt) {
                throw ValidationException::withMessages(['username' => __('api.set_profile_info.form_fields.username.unique')]);
            }
            //$user_family->update(['name'=>$request->name]);
            $user->update(['username' => $request->username]);
        }
        // return $request;
        // @ email fields
        if (!$user->email) {
            $request->validate([
                'email' => 'required|email',

            ], [
                'email.required' => __('app.Email_Validation'),
                'email.email' => __('app.Invalid_Email'),
            ]);
            $user->update(['email' => $request->email]);
        }
        //dd('55');
        // @ dob fields

        //@ account type
        if (!$user->account_type_id || $request->account_type_id) {
            $request->validate([
                'account_type_id' => 'required|exists:account_types,id'
            ], [
                'account_type_id.required' => __('api.set_profile_info.form_fields.account_type_id.required'),
                'account_type_id.exists' => __('api.set_profile_info.form_fields.account_type_id.exists'),
            ]);
            $user->update(['account_type_id' => $request->account_type_id]);
        }
        

        // @name
        if ($user->account_type_id == 2 || $user->account_type_id == 1) {

            $request->validate([
                'name' => ['required', 'max:20', new StrMaxNumber(4)],
            ], [
                'name.required' => __('api.set_profile_info.form_fields.name.required'),
                'name.max' => __('api.set_profile_info.form_fields.name.max'),
                'name.min' => __('api.set_profile_info.form_fields.name.min'),
                // 'username.required'=>__('api.set_profile_info.form_fields.username.required'),
                // 'username.unique'=>__('api.set_profile_info.form_fields.username.unique'),
            ]);
           
            $user->update(['name' => $request->name]);
            
        }        

        //dd($user->account_type_id);
        if (($user->account_type_id == 2)) {
            $request->validate([
                'dob' => 'required|date|before:' . now()->subYears(17)->toDateString(),

            ], [
                'dob.required' => __('api.set_profile_info.form_fields.dob.required'),
                'dob.date' => __('api.set_profile_info.form_fields.dob.date'),
                'dob.before' => __('api.set_profile_info.form_fields.dob.before'),
            ]);
            $user->update(['dob' => $request->dob]);
            //dd('hi');
        }
        // @ gender [male,female,other]
        if (($user->account_type_id == 2)) {
            $request->validate([
                'gender' => 'required|in:male,female,other',

            ], [
                'gender.required' => __('api.set_profile_info.form_fields.gender.required'),
                'gender.in' => __('api.set_profile_info.form_fields.gender.in'),
            ]);
            $user->update(['gender' => $request->gender]);
        }
        //dd('hii');
        // add new user into the main user table
        if($user) {

            $user_exits = User::where('username',$user->username)->count();
            if($user_exits == 0) {
                $user_main = User::create(
                    [
                        'account_type_id' => $user->account_type_id,
                        'name' => $user->name,
                        'username' => $user->username,
                        'email' => $user->email,
                        'mobile' => $user->mobile,
                        'password' => $user->password,
                        'default_language' => $user->default_language
                    ]
                );
                $user_id = $user_main->id;
                if ($user->account_type_id == 2 || $user->account_type_id == 1) { // only case of individual
                    $user_family = UserFamily::where('user_default_id', $user_main->id)->first();
                    //dd($user_family);
                    if (!$user_family) {
                        $user_family = UserFamily::create(['user_id' => $user_main->id, 'user_default_id' => $user_main->id]);
                    }
                }
                if ($user->account_type_id == 1) {
                    $user_main->update(['name' => $user->name]);
                    $user_family->update(['name' => $user->name]);
                } else {
                    //dd($user->dob);
                    $user_main->update(['name' => $user->name]);
                    $user_family->update(['dob' => $user->dob]);
                    $user_family->update(['gender' => $user->gender]);
                    $user_family->update(['name' => $user->name]);
                }

                // delete from user temp table
                UserTemp::where('username',$user->username)->delete();

                $user = User::find($user_main->id);
               
            } else {
                $user = User::where('username',$user_main->username)->first();
            }
            
            //dd($user_id);
        }



        //dd($user->id);
        session()->put('start_reg', $user->load('user_default_info'));

        
        //session()->forget('login_success');
        $encrypted_user_id = Crypt::encryptString($user->id);
        $short_payment_url = route('get_subscripton', [$encrypted_user_id]);

        $id = DB::table('payment_url')->insertGetId(
            [
                'payment_url' => $short_payment_url,
                'user_id' => $user->id,
                'payment_type' => 'subscription',
                'expiry_date' => Carbon::now()->addMinutes(30),
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        DB::table('users')->where('id', $user->id)->update(
            [
                'default_language' => App::getLocale()
            ]
        );
        return redirect()->route('get_subscripton', [$encrypted_user_id]);
        // return $res = [
        //     'success' => true,
        //     'user' => $user->load('user_default_info')
        // ];
    }

    public function get_payment_expired(Request $request, $token = null)
    {
        $user_token = Crypt::decryptString($token);
        $user = User::find($user_token);
        $default_language = $user->default_language;
        App::setLocale($default_language);
        return view('payment-link-expired', ['default_language' => $default_language]);
    }

    public function pay(Request $request, $id = null)
    {
        $explode = explode('-', $id);
        $id = $explode[0];
        $paymet_url_ck = DB::table('payment_url')->where('id', $id)->orderBy('id', 'desc')->first();
        return redirect()->to($paymet_url_ck->payment_url);
    }

    public function get_subscripton(Request $request, $token = null)
    {
        if(session()->has('success-redirect'))
        {
            return redirect()->route('signup');
        }
        //return redirect()->route('get_payment_expired', [$token])->with('success', 'Your payment is link is expired.');
        //die;
        $user_token = '';
        $user = '';
        $subscription_list = '';
        $account_detail = '';
        if (!empty($token)) {
            $user_token = Crypt::decryptString($token);
            $paymet_url_ck = DB::table('payment_url')->whereNull('deleted_at')->where('payment_type', 'subscription')->where('user_id', $user_token)->orderBy('id', 'desc')->first();
           
            if ($paymet_url_ck) {
                if (strtotime($paymet_url_ck->expiry_date) < strtotime(date('Y-m-d H:i:s'))) {
                    DB::table('payment_url')->where('id', $paymet_url_ck->id)->update([
                        'deleted_at' => date('Y-m-d H:i:s')
                    ]);
                    return redirect()->route('get_payment_expired', [$token])->with('success', 'Your payment is link is expired.');
                } else {
                    // DB::table('payment_url')->where('id',$paymet_url_ck->id)->update([
                    //     'deleted_at' => date('Y-m-d H:i:s')
                    // ]);
                    $user = User::find($user_token);

                    $default_language = $user->default_language;

                    $account_detail = AccountType::where('id', $user->account_type_id)->first();
                    $subscription_list = Subscription::with('account_type')->where('account_type_id', $user->account_type_id)->get();
                    $vat_detail = DB::table('master_settings')->first();
                    //dd($user);
                    $user_token = Crypt::encryptString($user_token);

                    $total_member_added = DB::table('user_purchase_subscriptions')
                        ->where('payment_type', 'subscription')
                        ->where('user_id', $user->id)
                        ->where('status', 'active')
                        ->sum('member_included');

                    if (!isset($total_member_added)) {
                        $total_member_added = 0;
                    } else {
                        $addon_member = DB::table('user_purchase_subscriptions')
                            ->where('payment_type', 'member_addon')
                            ->where('user_id', $user->id)
                            ->where('status', 'active')
                            ->sum('member_included');
                        $addon_member = isset($addon_member) ?  $addon_member : 0;
                        $total_member_added = $total_member_added + $addon_member;
                    }
                    //dd($total_member_added);

                    if ($subscription_list) {
                        foreach ($subscription_list as $key => $list) {
                            $subscription_list[$key]->sub_total = $list->price;
                            $vat_amt = 0;
                            if ($vat_detail->vat_percentage != 0) {
                                $vat_amt = round(($list->price / 100) * $vat_detail->vat_percentage, 2);
                                $subscription_list[$key]->vat_amt = $vat_amt;
                            } else {
                                $subscription_list[$key]->vat_amt = '--';
                            }
                            $subscription_list[$key]->total_amt = $list->price + $vat_amt;
                        }
                    }

                    //dd($total_member_added);
                    App::setlocale($default_language);
                    return view('get-subscriptions', [
                        'default_language' => $default_language, 'user_token' => $user_token,
                        'vat_detail' => $vat_detail,
                        'user' => $user, 'total_member_added' => $total_member_added, 'subscription_list' => $subscription_list, 'account_detail' => $account_detail
                    ]);
                }
            } else {
                return redirect()->route('get_payment_expired', [$token])->with('success', 'Your payment is link is expired.');
            }
        } else {
            session()->forget('login_success');
            session()->forget('start_reg');
            return view('get-subscriptions', ['user_token' => $user_token, 'user' => $user, 'subscription_list' => $subscription_list, 'account_detail' => $account_detail]);
        }
    }

    public function subscription_checkout(Request $request)
    {

        $env = Config::get('app.env');
        //dd( App::getLocale() );
        //dd($request->all());


        // $token = $request->user_token;
        // //dd($token);
        // $token = PersonalAccessToken::findToken($token);

        // if (!$token) {
        //     dd("Error: Token not found");
        // }
        // $user = $token->tokenable;
        $token = $request->user_token;
        //dd($token);
        $user_token = Crypt::decryptString($token);
        //dd($user_token);
        $user = User::find($user_token);

        $default_language = $user->default_language;
        App::setlocale($default_language);

        $selected_package_id = $request->package_id;
        $package_detail = Subscription::select('subscriptions.*', 'account_types.name as account_name', 'account_types.name_ar as account_name_ar')
            ->leftJoin('account_types', 'account_types.id', 'subscriptions.account_type_id')
            ->where('subscriptions.id', $selected_package_id)
            ->first();
        $package_cost = $package_detail->price ? $package_detail->price : 0;
        if ($package_detail) {
            $package_detail->duration = $package_detail->duration;
        }
        $total_member_added = DB::table('user_purchase_subscriptions')
            ->where('payment_type', 'subscription')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->sum('member_included');



        if (!isset($total_member_added)) {
            $total_member_added = 0;
        } else {
            $addon_member = DB::table('user_purchase_subscriptions')
                ->where('payment_type', 'member_addon')
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->sum('member_included');
            $addon_member = isset($addon_member) ?  $addon_member : 0;
            $total_member_added = $total_member_added + $addon_member;
        }

        $member_no = 0;
        $member_cost = 0;
        if ($package_detail->account_type_id == 1) {

            if ($total_member_added == 0) {
                $member_no = $request->member_no ? $request->member_no : 1;
                $member_cost = $package_detail->member_cost ? $package_detail->member_cost : 0;
                $member_cost = $request->member_cost;
                if ($member_no > 1) {
                    $member_no;
                    $total_pay_cost = $package_cost + ($member_cost * ($member_no - 1));
                } else {
                    $total_pay_cost = $package_cost;
                }
            } else { /// for extends subscription
                $member_no = $total_member_added;
                $total_pay_cost = $package_cost;
            }

            $selected_package_id = $request->package_id;
        } else {
            $total_pay_cost = $package_cost;
        }

        //dd($member_no);

        $total_cost = $total_pay_cost;
        //Get Vat Information
        $vat_detail = DB::table('master_settings')->first();
        //dd($vat_detail );
        $total_vat_cost = ($total_cost / 100 * $vat_detail->vat_percentage);
        $total_pay_cost = ($total_cost + $total_vat_cost);

        //dd($checkout);
        //dd($checkout->getData()->script_url);
        return view('subscription-checkout', [
            'env' => $env,
            'user_token' => $request->user_token,
            'user' => $user,
            'package_detail' => $package_detail,
            'total_cost' => $total_cost,
            'total_vat_cost' => $total_vat_cost,
            'total_pay_cost' => $total_pay_cost,
            'vat_detail' => $vat_detail,
            'member_no' => $member_no,
            //'checkout'=>$checkout,
            'member_cost' => $member_cost
        ]);
    }


    public function pay_subscription(Request $request)
    {

        //dd($request->all());
        // $token = $request->user_token;
        // //dd($token);
        // $token = PersonalAccessToken::findToken($token);

        // if (!$token) {
        //     dd("Error: Token not found");
        // }
        // $user = $token->tokenable;
        $token = $request->user_token;
        if(isset($token) && !empty($token)) {
            $user_token = Crypt::decryptString($token);
            $user = User::find($user_token);

            $default_language = 'en';
            App::setlocale($default_language);

            $selected_package_id = $request->package_id;
            $package_detail = Subscription::select('subscriptions.*', 'account_types.name as account_name')
                ->leftJoin('account_types', 'account_types.id', 'subscriptions.account_type_id')
                ->where('subscriptions.id', $selected_package_id)
                ->first();
            $package_cost = $package_detail->price ? $package_detail->price : 0;
            if ($package_detail) {
                $package_detail->duration = $package_detail->duration . ' Months';
            }

            $vat_detail = DB::table('master_settings')->first();

            $total_member_added = DB::table('user_purchase_subscriptions')
                ->where('payment_type', 'subscription')
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->sum('member_included');


            if (!isset($total_member_added)) {
                $total_member_added = 0;
            } else {
                $total_member_added = $total_member_added;
            }


            $member_no = 0;
            $member_cost = 0;
            if ($package_detail->account_type_id == 1) {
                if ($total_member_added == 0) {
                    $member_no = 1;
                    $member_cost = $package_detail->member_cost ? $package_detail->member_cost : 0;
                    $member_cost = $request->member_cost;
                    $member_no = $request->member_no;
                    if ($member_no > 1) {
                        $total_pay_cost = $package_cost + ($member_cost * ($member_no - 1));
                    } else {
                        $total_pay_cost = $package_cost;
                    }
                } else {
                    $member_no = $total_member_added;
                    $total_pay_cost = $package_cost;
                }


                $selected_package_id = $request->package_id;
            } else {
                $total_pay_cost = $package_cost;


                // $trackable = [
                //     'payment_type'=>'subscription',
                //     'member_add_on' => $member_no,
                //     'member_cost' =>  $member_cost,
                //     'product_id'=> $package_detail->id,
                //     'product_type' => $package_detail,
                //     'vat_detail' => $vat_detail
                // ];
            }

            //dd($total_pay_cost);


            $total_cost = $total_pay_cost;
            //Get Vat Information

            //dd($vat_detail );
            $total_vat_cost = ($total_cost / 100 * $vat_detail->vat_percentage);
            $total_pay_cost = ($total_cost + $total_vat_cost);

            if ($vat_detail) {
                $vat_detail->total_vat_amt = $total_vat_cost;
            }

            $amount = $total_pay_cost;
            $brand = $request->brand; //'VISA MASTER MADA'; // MASTER OR MADA

            $invoice_no = 'AWS'.time().uniqid();

            $trackable = [
                'invoice_no' => $invoice_no,
                'payment_type' => 'subscription',
                'sub_total' => $total_cost,
                'member_add_on' => $member_no,
                'member_cost' =>  $member_cost,
                'product_id' => $package_detail->id,
                'product_type' => $package_detail,
                'vat_detail' => $vat_detail
            ];

            switch ($brand) {
                case 'MADA':
                    $payment_type = 'PA';
                    $entity_id = env('ENTITY_ID_MADA');
                    break;
                case 'APPLEAPY':
                    $payment_type = 'PA';
                    $entity_id = env('ENTITY_ID_APPLE_PAY');
                    break;
                default:
                    $payment_type = 'DB';
                    $entity_id = env('ENTITY_ID');
                    break;
            }
            session()->put('entity_id', $entity_id);
            //$checkout = LaravelHyperpay::addBilling(new HyperPayBilling())->checkout($trackable, $user, str_replace(',', '', number_format($amount, 2)), $brand, $request);
            //dd($checkout);
            //echo $invoice_no;
            Transaction::create(
                [
                    'id' => $invoice_no,
                    'user_id' => $user->id,
                    'brand' => $brand,
                    'amount' => $total_pay_cost,
                    'currency' => env('CURRENCY'),
                    'data' => $trackable,
                    'trackable_data' => $trackable,
                    'status' => 'pending'
                ]
            );
            $checkout = Helper::hyper_pay_prepare_checkout($invoice_no,$brand,str_replace(',','',number_format($amount,2)),$user);
            $checkout = json_decode($checkout);
            //dd($checkout);
            
            Transaction::where('id', $invoice_no)->update(
                [
                    'transaction_no' => $checkout->buildNumber,
                    'checkout_id' => $checkout->id,
                ]
            );

            //dd($checkout);
            
            //dd($checkout);
            //dd($checkout->redirect->parameters);
            //dd($checkout->getData()->script_url);
            return view('subscription-pay', [
                'user_token' => $request->user_token,
                'user' => $user,
                'package_detail' => $package_detail,
                'total_pay_cost' => $total_pay_cost,
                'member_no' => $member_no,
                'checkout' => $checkout,
                'member_cost' => $member_cost,
                'brand' => $brand
            ]);
        }
        //dd($request->all());
        if(!empty($request->id)) {
            $entity_id = session()->get('entity_id');
            $checkout_id = $request->id;
            //dd($checkout_id);
            $response_data =  Helper::hyper_pay_payment_status($checkout_id,$entity_id);
            //dd($response_data);
            if(!empty($response_data)) {
                $res_data = json_decode($response_data);
                DB::table('transactions')->where('checkout_id', $checkout_id)->update(
                    [
                        'payment_response_id' => $res_data->id,
                        'payment_response' => $response_data
                    ]
                );
            }
            session()->forget('entity_id');
            //$checkout_id = '2DE28B4346C917D5D1D9B706DD5615A8.uat01-vm-tx01';
            $trans_detail = DB::table('transactions')->where('checkout_id', $checkout_id)->first();
            if(isset($trans_detail->payment_response))
            {
                $response_data = json_decode($trans_detail->payment_response);
            }
            else
            {
                $response_data = '';
            }            
            $checkout_id = $checkout_id;
            if(isset($trans_detail->trackable_data))
            {
                $trackable_data = json_decode($trans_detail->trackable_data);
            }
            else
            {
                $trackable_data = '';
            }            
            //dd($response_data->resultDetails->Status);
            $user_id_encrypted = Crypt::encryptString($trans_detail->user_id);
           //dd($response_data->result->code);
            //if ($response_data && ( $response_data->result->code == '000.000.000' || $response_data->result->code == '000.100.112') ) { //^(000.000.|000.100.1|000.[36]|000.400.[1][12]0)/
            if($response_data && preg_match('/(000.000.|000.100.1|000.[36]|000.400.[1][12]0)/',
                $response_data->result->code)) {
                
                $user_id_encrypted = Crypt::encryptString($trans_detail->user_id);

                //dd($response_data->result->code);
                if (isset($trackable_data->payment_type) && $trackable_data->payment_type == 'subscription') {
                    //if ( $response_data->result->code == '000.000.000' || $response_data->result->code == '000.100.112') { //^(000.000.|000.100.1|000.[36]|000.400.[1][12]0)/
                    if(preg_match('/(000.000.|000.100.1|000.[36]|000.400.[1][12]0)/',
                        $response_data->result->code)) {

                        //dd('come');
                        // DB::table('payment_url')->where('user_id',$trans_detail->user_id)->update([
                        //     'deleted_at' => date('Y-m-d H:i:s')
                        // ]);

                        $user_id = $trans_detail->user_id;
                        $package_id = $trackable_data->product_id;
                        $member_add_on = $trackable_data->member_add_on;
                        //dd($user_id);    
                        $expired_date = Helper::get_subscription_expired_date($package_id, $user_id);
                        //dd($expired_date);
                        // insert into user subscrbtion
                        $subscription_data = [
                            'user_id' =>  $user_id,
                            'transaction_id' => $checkout_id,
                            'subscription_id' => $package_id,
                            'expired_date' => $expired_date,
                            'payment_type' => 'subscription',
                            'member_included' => $member_add_on,
                        ];
                        //dd($subscription_data);
                        $has_subscription = UserPurchaseSubscription::where('user_id', $user_id)->count();
                        if ($has_subscription > 0) {
                            UserPurchaseSubscription::where('user_id', $user_id)
                                ->where('payment_type', 'subscription')
                                ->where('status', 'active')
                                ->update([
                                    'status' => 'expired',
                                    'payment_type' => 'subscription',
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            $subscription_data['status'] = 'active';
                            UserPurchaseSubscription::create($subscription_data);
                        } else {
                            $subscription_data['status'] = 'active';
                            UserPurchaseSubscription::create($subscription_data);
                        }

                        DB::table('transactions')->where('checkout_id', $checkout_id)->update(
                            [
                                'status' => 'success'
                            ]
                        );
                        //die('dd');

                        $user_id_encrypted = Crypt::encryptString($user_id);
                        return redirect()->route('get_subscripton', $user_id_encrypted)->with('success', 'Your payment is done successfully.');
                    } else {
                        $error_message = $response_data->result->code.' '.$response_data->result->description;
                        return redirect()->route('get_subscripton', $user_id_encrypted)->with('error', $error_message);
                    }
                }
                if (isset($trackable_data->payment_type) && $trackable_data->payment_type == 'member_addon') {
                    //if ( $response_data->result->code == '000.000.000' || $response_data->result->code == '000.100.112') {
                    if(preg_match('/(000.000.|000.100.1|000.[36]|000.400.[1][12]0)/',
                        $response_data->result->code)) {

                        $user_id = $trans_detail->user_id;
                        $member_add_on = $trackable_data->member_add_on;

                        $subscription_data = [
                            'user_id' =>  $user_id,
                            'payment_type' => 'member_addon',
                            'transaction_id' => $checkout_id,
                            'member_included' => $member_add_on,
                            'status' => 'active',
                            'invoice_generated' => 0
                        ];
                        UserPurchaseSubscription::create($subscription_data);
                        $user_id_encrypted = Crypt::encryptString($user_id);

                        return redirect()->route('add_member_addon', $user_id_encrypted)->with('success', 'Your payment is done successfully.');
                    } else {
                        $user_id_encrypted = Crypt::encryptString($user_id);
                        $error_message = $response_data->result->code.' '.$response_data->result->description;
                        return redirect()->route('add_member_addon', $user_id_encrypted)->with('error', $error_message);
                    }
                }
            } else {
                //$user_id_encrypted = Crypt::encryptString(1);
                $error_message = $response_data->result->code.' '.$response_data->result->description;
                //dd($error_message);
                return redirect()->route('admin.hyper_payment_status', $user_id_encrypted)->with('error', $error_message);
            }
        }
    }


    public function paymentStatus(Request $request)
    {
        $resourcePath = $request->get('resourcePath');
        $checkout_id = $request->get('id');
        //dd($resourcePath);
        $response_data = LaravelHyperpay::paymentStatus($resourcePath, $checkout_id);
        //$response_data = Helper::hyper_pay_payment_status($resourcePath, $checkout_id);
        //dd($response_data);
        if ($response_data) {
            //dd($response_data->original['ndc']);
            $checkout_id = $response_data->original['ndc'];
            $trans_detail = DB::table('transactions')->where('checkout_id', $checkout_id)->first();
            $trackable_data = json_decode($trans_detail->trackable_data);
            //dd($trackable_data->product_id);
            $user_id_encrypted = Crypt::encryptString($trans_detail->user_id);

            //dd($response_data->statusText());
            if (isset($trackable_data->payment_type) && $trackable_data->payment_type == 'subscription') {
                if ($response_data->statusText() == 'OK') {

                    // DB::table('payment_url')->where('user_id',$trans_detail->user_id)->update([
                    //     'deleted_at' => date('Y-m-d H:i:s')
                    // ]);

                    $user_id = $trans_detail->user_id;
                    $package_id = $trackable_data->product_id;
                    $member_add_on = $trackable_data->member_add_on;

                    $expired_date = Helper::get_subscription_expired_date($package_id, $user_id);
                    //dd($expired_date);
                    // insert into user subscrbtion
                    $subscription_data = [
                        'user_id' =>  $user_id,
                        'transaction_id' => $checkout_id,
                        'subscription_id' => $package_id,
                        'expired_date' => $expired_date,
                        'payment_type' => 'subscription',
                        'member_included' => $member_add_on,
                    ];
                    //dd($subscription_data);
                    $has_subscription = UserPurchaseSubscription::where('user_id', $user_id)->count();
                    if ($has_subscription > 0) {
                        UserPurchaseSubscription::where('user_id', $user_id)
                            ->where('payment_type', 'subscription')
                            ->where('status', 'active')
                            ->update([
                                'status' => 'expired',
                                'payment_type' => 'subscription',
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);
                        $subscription_data['status'] = 'active';
                        UserPurchaseSubscription::create($subscription_data);
                    } else {
                        $subscription_data['status'] = 'active';
                        UserPurchaseSubscription::create($subscription_data);
                    }

                    // if($member_add_on > 0) {

                    //     $extended_member_addon_data = [
                    //         'user_id' =>  $user_id,
                    //         'transaction_id' => $checkout_id,
                    //         'member_add_on' => $member_add_on
                    //     ];
                    //     DB::table('user_member_addon')->insert($extended_member_addon_data);

                    // }

                    return redirect()->route('get_subscripton', $user_id_encrypted)->with('success', 'Your payment is done successfully.');
                } else {
                    $response = json_decode($trans_detail->data);
                    $error_message = $response->result->description;
                    return redirect()->route('get_subscripton', $user_id_encrypted)->with('error', $error_message);
                }
            }
            if (isset($trackable_data->payment_type) && $trackable_data->payment_type == 'member_addon') {
                if ($response_data->statusText() == 'OK') {

                    $user_id = $trans_detail->user_id;
                    $member_add_on = $trackable_data->member_add_on;

                    // DB::table('payment_url')->where('user_id',$trans_detail->user_id)->update([
                    //     'deleted_at' => date('Y-m-d H:i:s')
                    // ]);
                    // $extended_member_addon_data = [
                    //     'user_id' =>  $user_id,
                    //     'transaction_id' => $checkout_id,
                    //     'member_add_on' => $member_add_on
                    // ];
                    // DB::table('user_member_addon')->insert($extended_member_addon_data);

                    $subscription_data = [
                        'user_id' =>  $user_id,
                        'payment_type' => 'member_addon',
                        'transaction_id' => $checkout_id,
                        'member_included' => $member_add_on,
                        'status' => 'active',
                        'invoice_generated' => 0
                    ];
                    UserPurchaseSubscription::create($subscription_data);


                    return redirect()->route('add_member_addon', $user_id_encrypted)->with('success', 'Your payment is done successfully.');
                } else {
                    $response = json_decode($trans_detail->data);
                    $error_message = $response->result->description;
                    return redirect()->route('add_member_addon', $user_id_encrypted)->with('error', $error_message);
                }
            }
        }
        //dd($response_data['transaction_status']);

    }

    public function hyperpaypaymentstatus(Request $request)
    {
        //dd($request->payload);
       
        try {
            $data = [
                'response' => $request->all()
            ];
            HyperPaymentNotification::create($data);
            // save it in our DB.
            return 200;
        }
        catch(Exception $e) {
            return 204;
        }
    }

    public function hyper_payment_status(Request $request,$id)
    {
        $subscryption_pay = route('get_subscripton',$id);
        return view('hyper-pay-status', ['subscryption_pay' => $subscryption_pay]);
    }

    /// Add Member AddON
    public function add_member_addon(Request $request, $token = null)
    {

        //die;
        $user_token = '';
        $user = '';
        $subscription_list = '';
        $account_detail = '';
        if (!empty($token)) {
            $user_token = Crypt::decryptString($token);
            $user = User::find($user_token);
            $paymet_url_ck = DB::table('payment_url')->where('payment_type', 'member_extension')->whereNull('deleted_at')->where('user_id', $user_token)->orderBy('id', 'desc')->first();
            //dd($paymet_url_ck);
            if ($paymet_url_ck) {
                if (strtotime($paymet_url_ck->expiry_date) < strtotime(date('Y-m-d H:i:s'))) {
                    DB::table('payment_url')->where('id', $paymet_url_ck->id)->update([
                        'deleted_at' => date('Y-m-d H:i:s')
                    ]);
                    return redirect()->route('get_payment_expired', [$token])->with('success', 'Your payment is link is expired.');
                } else {
                    // DB::table('payment_url')->where('id',$paymet_url_ck->id)->update([
                    //     'deleted_at' => date('Y-m-d H:i:s')
                    // ]);
                    $default_language = $user->default_language;
                    App::setlocale($default_language);
                    $account_detail = AccountType::where('id', $user->account_type_id)->first();
                    $subscription_detail = UserPurchaseSubscription::select('subscriptions.*')
                        ->leftJoin('subscriptions', 'subscriptions.id', 'user_purchase_subscriptions.subscription_id')
                        ->where('user_purchase_subscriptions.user_id', $user->id)
                        ->where('user_purchase_subscriptions.status', 'active')
                        ->first();

                    $total_member_added = DB::table('user_purchase_subscriptions')
                        //->where('payment_type','member_addon')
                        ->where('user_id', $user->id)
                        ->where('status', 'active')
                        ->sum('member_included');
                    if (!isset($total_member_added)) {
                        $total_member_added = 1;
                    } else {
                        $total_member_added = $total_member_added;
                    }

                    $vat_detail = DB::table('master_settings')->first();
                    if ($subscription_detail) {

                        $vat_amt = 0;
                        if ($vat_detail->vat_percentage != 0) {
                            $vat_amt = round(($subscription_detail->member_cost / 100) * $vat_detail->vat_percentage, 2);
                            $subscription_detail->vat_amt = $vat_amt;
                        } else {
                            $subscription_detail->vat_amt = '--';
                        }
                        $subscription_detail->total_amt = $subscription_detail->member_cost + $vat_amt;
                    }


                    $user_token = Crypt::encryptString($user_token);
                    return view('add-member-addon', ['user_token' => $user_token, 'vat_detail' => $vat_detail, 'user' => $user, 'subscription_detail' => $subscription_detail, 'account_detail' => $account_detail, 'total_member_added' => $total_member_added]);
                }
            } else {

                return redirect()->route('get_payment_expired', [$token])->with('success', 'Your payment is link is expired.');
            }
        } else {
            return view('add-member-addon', [
                'user_token' => $user_token, 'user' => $user, 'subscription_detail' => $subscription_detail, 'account_detail' => $account_detail,
                'total_member_added' => $total_member_added
            ]);
        }
    }

    public function add_member_checkout(Request $request)
    {
        //dd($request->all());
        $token = $request->user_token;
        //dd($token);
        $user_token = Crypt::decryptString($token);
        //dd($user_token);
        $user = User::find($user_token);

        $default_language = $user->default_language;
        App::setlocale($default_language);


        $member_cost = $request->member_cost;
        $member_add_on = $request->member_add_on;

        $subscription_detail = UserPurchaseSubscription::select('subscriptions.*')
            ->leftJoin('subscriptions', 'subscriptions.id', 'user_purchase_subscriptions.subscription_id')
            ->where('user_purchase_subscriptions.user_id', $user->id)
            ->where('user_purchase_subscriptions.status', 'active')
            ->first();

        if ($subscription_detail) {
            $member_cost = $subscription_detail->member_cost;
        }

        $total_pay_cost = $member_cost * $member_add_on;
        $total_cost = $total_pay_cost;
        //Get Vat Information
        $vat_detail = DB::table('master_settings')->first();
        //dd($vat_detail );
        $total_vat_cost = ($total_cost / 100 * $vat_detail->vat_percentage);
        $total_pay_cost = ($total_cost + $total_vat_cost);

        if ($vat_detail) {
            $vat_detail->total_vat_amt = $total_vat_cost;
        }

        //dd($checkout);
        //dd($checkout->getData()->script_url);
        return view('add-member-addon-checkout', [
            'user_token' => $request->user_token,
            'user' => $user,
            'subscription_detail' => $subscription_detail,
            'total_cost' => $total_cost,
            'total_vat_cost' => $total_vat_cost,
            'total_pay_cost' => $total_pay_cost,
            'vat_detail' => $vat_detail,
            'member_add_on' => $member_add_on,
            'member_cost' => $member_cost
        ]);
    }


    public function pay_add_member(Request $request)
    {

        //dd($request->all());
        $token = $request->user_token;
        $user_token = Crypt::decryptString($token);
        $user = User::find($user_token);

        $member_cost = $request->member_cost;
        $member_add_on = $request->member_add_on;
        $subscription_detail = UserPurchaseSubscription::select('subscriptions.*')
            ->leftJoin('subscriptions', 'subscriptions.id', 'user_purchase_subscriptions.subscription_id')
            ->where('user_purchase_subscriptions.user_id', $user->id)
            ->where('user_purchase_subscriptions.status', 'active')
            ->first();

        if ($subscription_detail) {
            $member_cost = $subscription_detail->member_cost;
        }
        $vat_detail = DB::table('master_settings')->first();

        $total_pay_cost = $member_cost * $member_add_on;
        $total_cost = $total_pay_cost;
        //Get Vat Information
        $vat_detail = DB::table('master_settings')->first();
        //dd($vat_detail );
        $total_vat_cost = ($total_cost / 100 * $vat_detail->vat_percentage);
        $total_pay_cost = ($total_cost + $total_vat_cost);

        if ($vat_detail) {
            $vat_detail->total_vat_amt = $total_vat_cost;
        }

        $invoice_no = uniqid();

        $trackable = [
            'invoice_no' => $invoice_no,
            'payment_type' => 'member_addon',
            'sub_total' => $total_cost,
            'user_id' => $user->id,
            'member_add_on' => $member_add_on,
            'vat_detail' => $vat_detail
        ];
        $amount = $total_pay_cost;
        $brand = $request->brand; //'VISA MASTER MADA'; // MASTER OR MADA

        $default_language = 'en';
        App::setlocale($default_language);

        //$checkout = LaravelHyperpay::checkout($trackable, $user, round($amount), $brand, $request);
        $checkout = LaravelHyperpay::addBilling(new HyperPayBilling())->checkout($trackable, $user, str_replace(',', '', number_format($amount, 2)), $brand, $request);
        //dd($checkout);
        //dd($checkout->getData()->script_url);
        return view('add-member-addon-pay', [
            'user_token' => $request->user_token,
            'user' => $user,
            'package_detail' => $subscription_detail,
            'total_pay_cost' => $total_pay_cost,
            'member_add_on' => $member_add_on,
            'checkout' => $checkout,
            'member_cost' => $member_cost,
            'brand' => $brand
        ]);
    }

    public function run_script(Request $request)
    {
        /*
        $users = DB::table('users')
            //->whereNull('name')
            ->where('account_type_id', '2')
            ->where('id', '!=', 1)
            ->get();
        //dd($users);
        foreach ($users as $user) {
            $us_detail = DB::table('user_families')->where('user_default_id', $user->id)->first();
            //dd($us_detail);
            DB::table('users')->where('id', $user->id)->update(['name' => $us_detail->name]);
        }
        */
        //"https://d2xon88f9t2c1o.cloudfront.net/profile_img/6bL26yCWN8.jpg",
        $status = Storage::disk('s3')->exists('profile_img/6bL26yCWN8.jpg');
        dd($status);
    }


    public function complete_registration(Request $request)
    {
        $countries = Country::orderByRaw("code='SA' DESC, id ")->get();
        $skinColors = SkinColor::all();
        $educationBackgrounds = MasterEducational::all();
        $workTypes = MasterWork::all();
        $sects = MasterSect::all();
        $tribes = MasterTribe::all();
        $hijabTypes = HijabType::all();
        $personalityDimensions = PersonalityDimension::all();
        return view('complete-registration', ['countries' => $countries, 'skinColors' => $skinColors, 'educationBackgrounds' => $educationBackgrounds, 'workTypes' => $workTypes, 'sects' => $sects, 'tribes' => $tribes, 'hijabTypes' => $hijabTypes, 'personalityDimensions' => $personalityDimensions]);
    }

    public function getRegionByCountry(Request $request)
    {
        $country_id = $request->country_id;
        $list = DB::table('master_regions');
        if (!empty($country_id)) {
            $list = $list->where('country_id', $country_id);
        }
        $list = $list->get();
        $response = [
            'status' => true,
            'data' => $list
        ];
        return $response;
    }

    public function getCityByRegion(Request $request)
    {
        $region_id = $request->region_id;
        $list = DB::table('master_cities');
        if (!empty($region_id)) {
            $list = $list->where('region_id', $region_id);
        }
        $list = $list->get();
        $response = [
            'status' => true,
            'data' => $list
        ];
        return $response;
    }

    public function submit_complete_registration(Request $request)
    {
        $user = $request->user();
        $user_family = UserFamily::where('user_default_id', $user->id)->first();
        $request->validate([
            'name' => ($user->account_type_id == 1) ? 'required' : 'nullable',
            'gender' => ($user->account_type_id == 1) ? 'required' : 'nullable',
            'dob' => ($user->account_type_id == 1) ? 'required' : 'nullable',
            'personality_dimensions' => 'required|array',
            'personality_dimensions.*.id' => 'required',
            'personality_dimensions.*.value' => 'required|numeric ',
            'region_id' => 'nullable',
            'bio' => 'required',
            'nationality_id' => 'nullable',
            'resident_country_id' => 'nullable',
            'family_origin_id' => 'nullable',
            'married_previously' => 'nullable',
            'currently_married' => 'nullable',
            'children_id' => 'nullable',
            'height' => 'nullable',
            'skin_color_id' => 'nullable',
            'education_id' => 'nullable',
            'work_id' => 'nullable',
            'do_you_allow_talking_before_marriage' => 'nullable',
            'smoking' => 'nullable',
            'is_your_family_tribal' => 'nullable',
            'tribe_id' => 'nullable',
            'hijab_type_id' => 'nullable',
        ], [
            'region_id.required' => __('api.user_profile_update.region_id.required'),
            'bio.required' => __('api.user_profile_update.bio.required'),
            'nationality_id.required' => __('api.user_profile_update.nationality_id.required'),
            'resident_country_id.required' => __('api.user_profile_update.resident_country_id.required'),
            'family_origin_id.required' => __('api.user_profile_update.family_origin_id.required'),
            'married_previously.required' => __('api.user_profile_update.married_previously.required'),
            'currently_married.required' => __('api.user_profile_update.currently_married.required'),
            'children_id.required' => __('api.user_profile_update.children_id.required'),
            'height.required' => __('api.user_profile_update.height.required'),
            'skin_color_id.required' => __('api.user_profile_update.skin_color_id.required'),
            'education_id.required' => __('api.user_profile_update.education_id.required'),
            'work_id.required' => __('api.user_profile_update.work_id.required'),
            'smoking.required' => __('api.user_profile_update.smoking.required'),
            'is_your_family_tribal.required' => __('api.user_profile_update.is_your_family_tribal.required'),
            'tribe_id.required' => __('api.user_profile_update.tribe_id.required'),
            'other.required' => __('api.user_profile_update.other.required'),
            'do_you_care_about_tribalism.required' => __('api.user_profile_update.do_you_care_about_tribalism.required'),
            'hijab_type_id.required' => __('api.user_profile_update.hijab_type_id.required'),
            'accept_poligamy.required' => __('api.user_profile_update.accept_poligamy.required'),
        ]);

        $dt_personality_dimensions = $request->personality_dimensions;
        $same = [];
        if (isset($dt_personality_dimensions) && count($dt_personality_dimensions)) {
            foreach ($dt_personality_dimensions as $pd) {
                if ($pd['value'] == 3) {
                    $same[] = $pd['id'];
                }
            }
        }
        if (count($same) == count($dt_personality_dimensions)) {
            Toastr::info('All values should not be same as 3!');
            return back();
        }


        if ($user->account_type_id == 2) {
            if (isset($dt_personality_dimensions) && count($dt_personality_dimensions)) {
                foreach ($dt_personality_dimensions as $pd) {
                    $db_user_pd = UserPersonalityDimension::where([
                        'user_id' => $user->id,
                        'personality_dimension_id' => $pd['id']
                    ])->first();
                    if ($db_user_pd) {
                        $db_user_pd->update(['point' => $pd['value']]);
                    } else {
                        $db_user_pd = UserPersonalityDimension::create([
                            'user_id' => $user->id,
                            'personality_dimension_id' => $pd['id'],
                            'point' => $pd['value']
                        ]);
                    }
                }
            }
        }

        if ($user->account_type_id == 1) {
            if (isset($dt_personality_dimensions) && count($dt_personality_dimensions)) {
                foreach ($dt_personality_dimensions as $pd) {
                    $db_user_pd = UserFamilyPersonalityDimension::where([
                        'user_family_id' => $user_family->id,
                        'personality_dimension_id' => $pd['id']
                    ])->first();
                    if ($db_user_pd) {
                        $db_user_pd->update(['point' => $pd['value']]);
                    } else {
                        $db_user_pd = UserFamilyPersonalityDimension::create([
                            'user_family_id' => $user_family->id,
                            'personality_dimension_id' => $pd['id'],
                            'point' => $pd['value']
                        ]);
                    }
                }
            }
        }

        $req_data = $request->only(
            'name',
            'gender',
            'dob',
            'status',
            'bio',
            'married_previously',
            'currently_married',
            'children_id',
            'height',
            'skin_color_id',
            'body_appearence',
            'education_id',
            'work_id',
            'religion_id',
            'smoking',
            'sect_id',
            'other',
            'do_you_care_about_tribalism',
            'hijab_type_id',
            'accept_poligamy',
            'does_she_or_he_has_flexibility_to_marry_a_married_man'
        );

        $req_master_data = $request->only(
            'live_in_region_id',
            'live_in_city_id',
            'saudi_family_origin_region_id',
            'saudi_family_origin_city_id',
            'nationality_id',
            'resident_country_id',
            'family_origin_id',
            'saudi_family_origin_id',
            'is_your_family_tribal',
            'tribe_id'
        );

        if ($request->nationality_id == 195) {
            $req_master_data['saudi_family_origin_id'] = '';
            $req_master_data['family_origin_id'] = $request->family_origin_id;
        } else {
            $req_master_data['family_origin_id'] = $request->family_origin_id;
            $req_master_data['saudi_family_origin_id'] = '';
        }

        if (!empty($request->resident_country_id == 195)) {
            $req_master_data['live_in_region_id'] = $request->live_in_region_id ? $request->live_in_region_id : '';
            $req_master_data['live_in_city_id'] = $request->live_in_city_id ?  $request->live_in_city_id : '';
        }

        if (!empty($request->family_origin_id == 195)) {
            $req_master_data['saudi_family_origin_region_id'] = $request->saudi_family_origin_region_id ? $request->saudi_family_origin_region_id : '';
            $req_master_data['saudi_family_origin_city_id'] = $request->saudi_family_origin_city_id ? $request->saudi_family_origin_city_id : '';
        }

        if ($user->account_type_id == 2) {
            $req_master_data['bio'] = $request->bio;
            $req_master_data['live_in_city_id'] = $request->live_in_city_id;
        }
        if ($user->account_type_id == 1) {
            $req_master_data['bio'] = $request->family_bio;
            $req_master_data['live_in_city_id'] = $request->live_in_city_id;
            $req_master_data['about_family'] = $request->about_family;
            $req_master_data['do_you_care_about_tribalism'] = $request->do_you_care_about_tribalism;
            $req_master_data['do_you_allow_talking_before_marriage'] = $request->do_you_allow_talking_before_marriage;
        }
        $req_master_data['is_completed'] = 1;

        if ($user->is_completed == 0) {
            $user->update($req_master_data);
        }

        $req_data['user_id'] = $user->id;
        if (!empty($request->height)) {
            $step = $request->step;
            $height_min = 0;
            if (is_array($request->height)) {
                $height_min = $request->height[0];
                $max_height = $height_min + $request->step;
                $height_label = $height_min . '-' . $max_height . ' cm';
            } else {
                $height_min = $request->height;
                $max_height = $height_min + $request->step;
                $height_label = $height_min . '-' . $max_height . ' cm';
            }
            $req_data['height'] = $height_label;
            $req_data['height_min'] = $height_min;
            $req_data['height_max'] = $max_height;
        }

        if ($user->account_type_id == 1) {
            $new_family_member = UserFamily::where('id', $user_family->id)->update($req_data);
        } else {
            $user_family->update($req_data);
        }

        $verfied_data = Helper::user_all_detail($user);

        if ($user->is_completed == 0 && $user->account_type_id == 1) {
            $message_data = Helper::getMessageByCode('NOT013');
        }
        if ($user->is_completed == 1 && $user->account_type_id == 1) {
            $message_data = Helper::getMessageByCode('NOT014');
        }
        if ($user->is_completed == 0 && $user->account_type_id == 2) {
            $message_data = Helper::getMessageByCode('NOT013');
        }
        if ($user->is_completed == 1 && $user->account_type_id == 2) {
            $message_data = Helper::getMessageByCode('NOT013');
        }
        $message = '';
        $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
        if ($prefered_lag == 'en') {
            $message_text = $message_data ? $message_data->message_value_en : $message;
        } else {
            $message_text = $message_data ? $message_data->message_value_ar : $message;
        }
        $message = $message_text;

        // return [
        //     'success' => true,
        //     'data' => $verfied_data,
        //     'member_id' => $user_family->id,
        //     'message' => $message
        // ];
        return redirect()->route('signup')->with('success', $message);
    }
}
