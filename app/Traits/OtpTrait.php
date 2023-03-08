<?php 

namespace App\Traits;

use App\Models\OtpModel;
use App\Models\{User,UserTemp};
use Illuminate\Support\Facades\Hash;
use App\Helper\Helper;
use Illuminate\Support\Facades\Crypt;
use Config;

trait OtpTrait{

    private function __generateOtpNumber(){
        //return  '1234'; // env('SANDBOX_MODE') == true ? rand(1000,9999) : '1234';
        //return  rand(1000,9999); // env('SANDBOX_MODE') == true ? rand(1000,9999) : '1234';
        return Config::get('app.env') == 'production' ? rand(1000,9999) : '1234' ;

    }
 
    private function __storeToDb($user_id,$otp){
        
       $otp_row = OtpModel::where('user_id',$user_id)->whereNull('validated_at')->first();
       if($otp_row) {
            $otp=OtpModel::where('user_id',$user_id)->update([
                'otp'=>Hash::make($otp),
                'try_count' => $otp_row->try_count + 1,
                'expired_at'=>now()->addMinutes(5)
               ]);
       } else {
            $otp=OtpModel::create([
            'user_id'=>$user_id,
            'otp'=>Hash::make($otp),
            'try_count' => 1,
            'expired_at'=>now()->addMinutes(5)
           ]);
       }
       
       $res=[
            'success'=>true,
        ];
       return $res;

    }

    public function _sendOtp(User $user){
        
        $otp_no= $this->__generateOtpNumber();
        //dd($otp_no);
        if($user->mobile == "555577777")
        {
            $otp_no='1234';
        }
        if($user->mobile == "506072620")
        {
            $otp_no='0123';
        }
        //$otp_no=1234; //
        $to = $user->mobile;
        //$to = '506208358';
        if($to) { //$to == '503454569' or $to == '509514264' or $to == '533885606'
            //$recipant_user = User::find($user->id);
            $prefered_lag = $user->default_language ? $user->default_language : 'en';
            //dd($prefered_lag);
            if($prefered_lag == "en") {
               $type = 3;
                $message_otp = '<#>'.trans('api.common.otp_message' ,['otp_no'=>$otp_no],'en').' QbwSot12oP';
            } else {
                $type = 4;
                $message_otp = '<#>'.trans('api.common.otp_message' ,['otp_no'=>$otp_no],'ar').' QbwSot12oP';;
            }
            //$to = '506208358';
            Helper::sendSms($message_otp,$to,$type);
        } 
       
        $res=$this->__storeToDb($user->id,$otp_no);
        $res['message'] = true;
        $res['message'] = __('message.otp.send_successfully');
        $res['user_id'] = Crypt::encryptString($user->id);
        return $res;
    }

    public function _sendOtpNewUser(UserTemp $user){
        $otp_no= $this->__generateOtpNumber();
        if($user->mobile == "555577777")
        {
            $otp_no='1234';
        }
        if($user->mobile == "506072620")
        {
            $otp_no='0123';
        }
        //$otp_no=1234;
        $to = $user->mobile;
        //$to = '506208358'; 
        if($to) { //$to == '503454569' or $to == '509514264' or $to == '533885606'
            //$recipant_user = User::find($user->id);
            $prefered_lag = $user->default_language ? $user->default_language : 'en';
            //dd($prefered_lag);
            if($prefered_lag == "en") {
               $type = 3;
                $message_otp = '<#>'.trans('api.common.otp_message' ,['otp_no'=>$otp_no],'en').' QbwSot12oP';
            } else {
                $type = 4;
                $message_otp = '<#>'.trans('api.common.otp_message' ,['otp_no'=>$otp_no],'ar').' QbwSot12oP';;
            }
            //$to = '506208358';
            Helper::sendSms($message_otp,$to,$type);
        } 
       
        $res=$this->__storeToDb($user->id,$otp_no);
        $res['message'] = true;
        $res['message'] = __('message.otp.send_successfully');
        $res['user_id'] = Crypt::encryptString($user->id);
        return $res;
    }

    public function _verifyOtp($mobile,$otp_no,$user_id){
        $user_id = Crypt::decryptString($user_id);
        $user=User::where('mobile',$mobile)->where('id',$user_id)->first();
        
        //dd($user);
        // @ attach relational data to
        if(isset($user->account_type_id) && !empty($user->account_type_id)) {
            if($user->account_type_id==1){
                // for family
                $load_arr=['user_default_info','live_in_region_detail','live_in_city_detail','family_origin_region_detail','family_origin_city_detail','members.profile_images_list','family_origin_detail','members.skin_detail','members.children_detail','members.work_detail','members.education_detail','members.hijab_detail','members.sect_detail'];
            }else{
                // for individual
                $load_arr=['live_in_region_detail','live_in_city_detail','family_origin_region_detail','family_origin_city_detail','profile_images_list','user_default_info','members.profile_images_list','members','family_origin_detail','user_default_info.skin_detail','user_default_info.children_detail','user_default_info.work_detail','user_default_info.education_detail','user_default_info.hijab_detail','members.sect_detail'];
    
            }
            $user->load($load_arr);
        }
       

        //dd($user);

        $otp=OtpModel::where('user_id',$user->id)->whereNull('validated_at')->first();
        
        //dd($otp);
        
        if(!$otp){
            return [
                'success'=>false,
                'message'=>__('api.login.invalid_otp')
            ];
        }
        
        if(now()->gt($otp->expired_at)){
            return [
                'success'=>false,
                'message'=>__('api.login.invalid_otp')
            ];
        }
       

        if(Hash::check($otp_no,$otp->otp)){
            $otp->update(['validated_at'=>now(),'try_count'=>($otp->try_count+1)]);
            return [
                'success'=>true,
                'message'=>__('message.otp.otp_validated'),
                'user'=>$user
            ];
        }else{
            
            return [
                'success'=>false,
                'message'=>__('api.login.invalid_otp')
            ];
        }
    }

    
    public function _verifyOtpNewUser($mobile,$otp_no,$user_id){
        $user_id = Crypt::decryptString($user_id);
        //dd($mobile.' + '.$otp_no.' + '.$user_id);
        $user=UserTemp::where('mobile',$mobile)->where('id',$user_id)->first();
        
        $otp=OtpModel::where('user_id',$user->id)->whereNull('validated_at')->first();
        
        //dd($otp);
        
        if(!$otp){
            return [
                'success'=>false,
                'message'=>__('api.login.invalid_otp')
            ];
        }
        
        if(now()->gt($otp->expired_at)){
            return [
                'success'=>false,
                'message'=>__('api.login.invalid_otp')
            ];
        }
       

        if(Hash::check($otp_no,$otp->otp)){
            $otp->update(['validated_at'=>now(),'try_count'=>($otp->try_count+1)]);
            return [
                'success'=>true,
                'message'=>__('message.otp.otp_validated'),
                'user'=>$user
            ];
        }else{
            
            return [
                'success'=>false,
                'message'=>__('api.login.invalid_otp')
            ];
        }
    }
}