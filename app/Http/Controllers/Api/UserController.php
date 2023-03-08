<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use App\Models\{PersonalityDimension, UserYellowConnections, UserRedConnections, UserFamilyPersonalityDimension};
use App\Models\{CommonIcon, User, UserPurchaseSubscription, Transaction, Connection, Message};
use App\Models\UserProfileImage;
use App\Rules\Base64FileMaxSize;
use App\Rules\Base64FileType;
use App\Traits\Base64FileTrait;
use Carbon\Carbon;
use App\Helper\Helper;
use App\Models\AccountType;
use App\Models\UserPersonalityDimension;
use App\Models\{UserFamily, UserLikesHideBlocked, UserFamilyProfileImage};
use App\Rules\AlphaNumaric;
use App\Rules\StrMaxNumber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use DB;
use Session;
use Codedge\Fpdf\Fpdf\Fpdf;
use PDF;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Api\ConnectionController;
use Config;

class UserController extends Controller
{
    use UserTrait, Base64FileTrait;

    public function getUserInfo(Request $request, $user_id = null)
    {

        if (!empty($user_id)) {
            $user = User::find($user_id);
            $all_detail = Helper::user_all_detail($user);
        } else {
            $user = $request->user();
            $all_detail = Helper::user_all_detail($user, 1);
        }


        

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('success' => true,
            'user' => $all_detail)
        ];
        Helper::save_api_logs($logdata);

        return [
            'success' => true,
            'user' => $all_detail
        ];
    }

    public function getMemberInfo(Request $request, $member_id = null)
    {
        $member = UserFamily::with('profile_images_list')
        ->with('skin_detail')
        ->with('personality_dimension')
        ->with('work_detail')
        ->with('education_detail')
        ->where('user_families.id', $member_id)->first();
        if(isset($member)){
            $user = User::find($member->user_id);
            $commonIcon = CommonIcon::all();
            $height_obj = isset($member->height_detail) ? $member->height_detail : '';
            if(!empty($height_obj)) {
                $height_obj->icon = $commonIcon->where('name','height')->first()->icon??'';
                $height_obj->tag_name_en = isset($member->height_detail) ? '📏 '.$member->height_detail->height_min . ' - '.$member->height_detail->height_max . ' cm'  : '';
                $height_obj->tag_name_ar = isset($member->height_detail) ? '📏 '.$member->height_detail->height_min . ' - '.$member->height_detail->height_max . ' cm'  : ''; 
            }
            
            
            $skin_color=isset($member->skin_detail)?$member->skin_detail:'';
            if(!empty($skin_color)) {
                $skin_color->tag_name_en =  isset($member->skin_detail) ? '👨 '.trans('api.common.skin', [ 'attribute' => $member->skin_detail->name_en ], 'en')  : '';
                $skin_color->tag_name_ar =  isset($member->skin_detail->name_ar) ? '👨 '.trans('api.common.skin', [ 'attribute' => $member->skin_detail->name_ar ], 'ar')  : '';
            }

            $children=isset($member->children_detail)?$member->children_detail:'';
            //Has 1 child
            if(!empty($children)) {
                $children->tag_name_en =  isset($member->children_detail) ? '👶 '.$member->children_detail->children_number_en  : '';
                $children->tag_name_ar =  isset($member->children_detail) ? '👶 '.$member->children_detail->children_number_ar  : '';
            }
            // @ education and career Undergraduate studies
            $education=isset($member->education_detail)?$member->education_detail:'';
            if(!empty($education)) {
                $education->tag_name_en =  isset($member->education_detail) ? '🎓 '.$member->education_detail->name_en  : '';
                $education->tag_name_ar =  isset($member->education_detail) ? '🎓 '.$member->education_detail->name_ar  : '';
            }
            // Freelancer
            $career=isset($member->work_detail)?$member->work_detail:'';
            if(!empty($career)) {
                $career->tag_name_en =  isset($member->work_detail) ? '💼 '.$member->work_detail->name_en  : '';
                $career->tag_name_ar =  isset($member->work_detail) ? '💼 '.$member->work_detail->name_ar  : '';
            }
            // @ social
            $sect=isset($member->sect_detail)?$member->sect_detail:'';
            
            if(!empty($sect)) {
                $sect->tag_name_en =  isset($member->sect_detail) ? '🌑 '.$member->sect_detail->name_en  : '';
                $sect->tag_name_ar =  isset($member->sect_detail) ? '🌑 '.$member->sect_detail->name_ar  : '';
            }
            
            $tribal=isset($user->tribe_detail)?$user->tribe_detail:'';

            if(!empty($tribal)) {
                $tribal->tag_name_en=isset($user->tribe_detail->name_en)? '👥 '.trans('api.common.tribe', [ 'attribute' => $user->tribe_detail->name_en ], 'en') :'';
                $tribal->tag_name_ar=isset($user->tribe_detail->name_ar)? '👥 '.trans('api.common.tribe', [ 'attribute' => $user->tribe_detail->name_ar ], 'ar') :'';
            }
            

            $hijab=isset($member->hijab_detail)?$member->hijab_detail:'';
            if(!empty($hijab)) {
               
                $hijab->tag_name_en =  isset($member->hijab_detail) ? '👩🏻 '.$member->hijab_detail->name_en  : '';
                $hijab->tag_name_ar =  isset($member->hijab_detail) ? '👩🏻 '.$member->hijab_detail->name_ar  : '';
                
            }
            
            $yes_no_obj=[
                "yes"=>['name_en'=>'YES','name_ar'=>'نعم'],
                "no"=>['name_en'=>'NO','name_ar'=>'رقم'],
                "sometimes" => ['name_en'=>'Sometimes','name_ar'=>'رقم']
            ];
            // current marriedCurrently married
            $currently_married_obj=[
                "married"=> true,
                "value"=> ($member->currently_married=='yes')?'currently married':'not married',
                "tag_name_en" => ($member->currently_married=='yes') ? '💍 '.trans('api.common.currently_married', [ 'attribute' => '' ], 'en') : '💍 '.trans('api.common.not_married', [ 'attribute' => '' ], 'en'),
                "tag_name_ar" => ($member->currently_married=='yes') ? '💍 '.trans('api.common.currently_married', [ 'attribute' => '' ], 'ar') : '💍 '.trans('api.common.not_married', [ 'attribute' => '' ], 'ar'),
                "icon"=> $commonIcon->where('name','currently_married')->first()->icon??''
            ];
            // $currently_married_obj=(isset($member->currently_married) && $member->currently_married)?$yes_no_obj[$member->currently_married]:[];
            // $currently_married_obj['icon']=$commonIcon->where('name','currently_married')->first()->icon??'';
            // @ smoking obj
            $smoking_obj=(isset($member->smoking) && $member->smoking)?$yes_no_obj[$member->smoking]:[];
            //Non-smoker
            $smoking_tag_en = ''; $smoking_tag_ar = '';
            if($member->smoking == 'yes') {
                $smoking_tag_en = '🚬 '.trans('api.common.smoke', [ 'attribute' => '' ], 'en');
                $smoking_tag_ar = '🚬 '.trans('api.common.smoke', [ 'attribute' => '' ], 'ar');
            } else if($member->smoking == 'sometimes') {
                $smoking_tag_en = '🚬 '.trans('api.common.sometimes_smoke', [ 'attribute' => '' ], 'en');
                $smoking_tag_ar = '🚬 '.trans('api.common.sometimes_smoke', [ 'attribute' => '' ], 'ar');
            } else {
                $smoking_tag_en = '🚭 '.trans('api.common.no_smoke', [ 'attribute' => '' ], 'en');
                $smoking_tag_ar = '🚭 '.trans('api.common.no_smoke', [ 'attribute' => '' ], 'ar');
            }
            $smoking_obj['tag_name_en'] =  $smoking_tag_en;
            $smoking_obj['tag_name_ar'] =  $smoking_tag_ar;
            $smoking_obj['icon']=$commonIcon->where('name','smoking')->first()->icon;


            $care_tribalism_obj=(isset($member->do_you_care_about_tribalism) && 
            $member->do_you_care_about_tribalism)?$yes_no_obj[$member->do_you_care_about_tribalism]:[];


            $care_tribalism_obj_en = ''; $care_tribalism_obj_ar = '';
            if($member->do_you_care_about_tribalism == 'yes') {
                $care_tribalism_obj_en = '👤 ' . trans('api.common.care_about_tribalism', ['attribute' => ''], 'en');
                $care_tribalism_obj_ar = '👤 ' . trans('api.common.care_about_tribalism', ['attribute' => ''], 'ar');
            } else {
                $care_tribalism_obj_en = '👤 ' . trans('api.common.not_care_about_tribalism', ['attribute' => ''], 'en');
                $care_tribalism_obj_ar = '👤 ' . trans('api.common.not_care_about_tribalism', ['attribute' => ''], 'ar');
            }

            $care_tribalism_obj['tag_name_en'] =  $care_tribalism_obj_en;
            $care_tribalism_obj['tag_name_ar'] =   $care_tribalism_obj_ar;

            $care_tribalism_obj['icon']=$commonIcon->where('name','is_tribal')->first()->icon??'';
            // @is tribal
            $is_tribal_obj=(isset($user->is_your_family_tribal) && $user->is_your_family_tribal)
                             ?$yes_no_obj[$user->is_your_family_tribal]:[];


            $is_tribal_obj_en = ''; $is_tribal_obj_ar = '';
            if($user->is_your_family_tribal == 'yes') {
                $is_tribal_obj_en = '👤 ' . trans('api.common.tribal_person', ['attribute' => ''], 'en');
                $is_tribal_obj_ar = '👤 ' . trans('api.common.tribal_person', ['attribute' => ''], 'ar');
            } else {
                $is_tribal_obj_en = '👤 ' . trans('api.common.not_tribal_person', ['attribute' => ''], 'en');
                $is_tribal_obj_ar = '👤 ' . trans('api.common.not_tribal_person', ['attribute' => ''], 'ar');
            }

            $is_tribal_obj['tag_name_en'] = $is_tribal_obj_en;
            $is_tribal_obj['tag_name_ar'] = $is_tribal_obj_ar;
            $is_tribal_obj['icon']=$commonIcon->where('name','is_tribal')->first()->icon??'';

            
           
            $temp_about_me = [
                'height'=>$height_obj,
                'skin_color' => $skin_color,
                'currently_married' => $currently_married_obj,
                'children' => $children,
            ];
            $temp_education_and_career=[
                'education'=>$education,
                'career'=>$career
            ];
            $temp_social=[
                'sect'=>$sect,
                'smoking'=>$smoking_obj,
                // 'smoking'=>["value"=>($smoking=='yes')?__('admin_dashboard.common.yes'):__('admin_dashboard.common.no')],
                'Tribal_Person'=>$is_tribal_obj,
                'tribal'=>$tribal,
                'Cares_About_Tribalism'=>$care_tribalism_obj,
                'Flexible_About_Hijab'=>$hijab,
            ];
            
            //$member->about_me_arr=array_merge($about_me_arr,$temp_about_me);
            $member->about_me_arr=$temp_about_me;
            $member->education_and_career_arr=$temp_education_and_career;
            $member->social_arr=$temp_social;
            $member->profile_images = Helper::get_profile_individual_or_family_images($member);
            $member->user_likes_hide_blocked= Helper::user_likes_hide_blocked($member->id,'member');
        }
        //$all_detail = Helper::user_all_detail($user, 1);
        return [
            'success' => true,
            'user' => $member
        ];
    }


    public function setUserInfo(Request $request, $selected_user_id = null)
    {   // registration steps
        if (empty($selected_user_id)) {
            $user = $request->user();
        } else {
            $user = User::find($selected_user_id);
        }



        // return $user;

        //@ account type
        if (!$user->account_type_id) {
            $request->validate([
                'account_type_id' => 'required|exists:account_types,id'
            ], [
                'account_type_id.required' => __('api.set_profile_info.form_fields.account_type_id.required'),
                'account_type_id.exists' => __('api.set_profile_info.form_fields.account_type_id.exists'),
            ]);
            $user->update(['account_type_id' => $request->account_type_id]);
        }

        if ($request->account_type_id == 2 || $request->account_type_id == 1) { // only case of individual
            $user_family = UserFamily::where('user_default_id', $user->id)->first();
            //dd($user_family);
            if (!$user_family) {
                $user_family = UserFamily::create(['user_id' => $user->id, 'user_default_id' => $user->id]);
            }
        }

        // @name
        if ($user->account_type_id == 2 && !$user_family->name || $user->account_type_id == 1 && !$user->name) {


            $request->validate([
                'name' => 'required',
            ], [
                'name.required' => __('api.set_profile_info.form_fields.name.required'),
                'name.max' => __('api.set_profile_info.form_fields.name.max'),
                'name.min' => __('api.set_profile_info.form_fields.name.min'),
                // 'username.required'=>__('api.set_profile_info.form_fields.username.required'),
                // 'username.unique'=>__('api.set_profile_info.form_fields.username.unique'),
            ]);
            if ($user->account_type_id == 1) {
                $user->update(['name' => $request->name]);
            } else {
                $user->update(['name' => $request->name]);
                $user_family->update(['name' => $request->name]);
            }
        }

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
            ]);

            //$user_family->update(['name'=>$request->name]);
            $user->update(['username' => $request->username]);
        }
        // return $request;
        // @ email fields
        if (!$user->email) {
            $request->validate([
                'email' => 'required|email',

            ], [

                'email.required' => __('api.set_profile_info.form_fields.email.required'),
                'email.email' => __('api.set_profile_info.form_fields.email.email'),
            ]);
            $user->update(['email' => $request->email]);
        }
        //dd('55');
        // @ dob fields

        if (($user->account_type_id == 2) && !$user_family->dob) {
            $request->validate([
                'dob' => 'required|date|before:' . now()->subYears(17)->toDateString(),

            ], [
                'dob.required' => __('api.set_profile_info.form_fields.dob.required'),
                'dob.date' => __('api.set_profile_info.form_fields.dob.date'),
                'dob.before' => __('api.set_profile_info.form_fields.dob.before'),
            ]);
            $user_family->update(['dob' => $request->dob]);
        }
        // @ gender [male,female,other]
        if (($user->account_type_id == 2) && !$user_family->gender) {
            $request->validate([
                'gender' => 'required|in:male,female,other',

            ], [
                'gender.required' => __('api.set_profile_info.form_fields.gender.required'),
                'gender.in' => __('api.set_profile_info.form_fields.gender.in'),
            ]);
            $user_family->update(['gender' => $request->gender]);
        }

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('success' => true,
            'user' => $user->load('user_default_info'))
        ];
        Helper::save_api_logs($logdata);


        return $res = [
            'success' => true,
            'user' => $user->load('user_default_info')
        ];
    }


    public function setUserDefaultInfo(Request $request)
    {
        $user = $request->user();
        $user->load('user_default_info');
        $user_default_info = $user->user_default_info;



        $request->validate([
            'status' => 'required',
            'name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'bio' => 'required',
            'married_previously' => 'required',
            'currently_married' => 'required',
            'children_id' => 'required',
            'height' => 'required',
            'skin_color_id' => 'required',
            'education_id' => 'required',
            'work_id' => 'required',
            'sect_id' => 'required',
            'smoking' => 'required',
            'hijab_type_id' => 'required',
            'does_she_or_he_has_flexibility_to_marry_a_married_man' => 'required',
            'do_you_care_about_tribalism' => 'required',
        ]);
    }


    public function personality_dimension(Request $request)
    {
        $list = PersonalityDimension::all();

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('status' => true,
            'data' => $list)
        ];
        Helper::save_api_logs($logdata);


        $response = [
            'status' => true,
            'data' => $list
        ];
        return $response;
    }
    // @ for individual update default member account
    // @ for family add one member
    public function userProfileUpdate(Request $request)
    {
        $user = $request->user();
        $user_family = UserFamily::where('user_default_id', $user->id)->first();
        $personality_dimensions = PersonalityDimension::all();
        // return $personality_dimensions;
        $request->validate([
            'name' => ($user->account_type_id == 1) ? 'required' : 'nullable',
            'gender' => ($user->account_type_id == 1) ? 'required' : 'nullable',
            'dob' => ($user->account_type_id == 1) ? 'required' : 'nullable',
            // 'profile_image'=>'null',
            // 'personality_dimensions' => 'required|array',
            // 'personality_dimensions.*.id' => 'required',
            // 'personality_dimensions.*.value' => 'required|numeric ',

            //'status'=>'required',
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
            //'body_appearence'=>'required',
            'education_id' => 'nullable',
            'work_id' => 'nullable',
            'do_you_allow_talking_before_marriage' => 'nullable',
            'smoking' => 'nullable',
            'is_your_family_tribal' => 'nullable',
            'tribe_id' => 'nullable',
            //'do_you_care_about_tribalism'=>'required',
            'hijab_type_id' => 'nullable',
            //'accept_poligamy'=>'required',
        ], [
            // 'profile_image.required'=>__('api.user_profile_update.profile_image.required'),
            //'status.required'=>__('api.user_profile_update.status.required'),
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
            //'body_appearence.required'=>__('api.user_profile_update.body_appearence.required'),
            'education_id.required' => __('api.user_profile_update.education_id.required'),
            'work_id.required' => __('api.user_profile_update.work_id.required'),
            //'religion_id.required'=>__('api.user_profile_update.religion_id.required'),
            'smoking.required' => __('api.user_profile_update.smoking.required'),
            'is_your_family_tribal.required' => __('api.user_profile_update.is_your_family_tribal.required'),
            'tribe_id.required' => __('api.user_profile_update.tribe_id.required'),
            'other.required' => __('api.user_profile_update.other.required'),
            'do_you_care_about_tribalism.required' => __('api.user_profile_update.do_you_care_about_tribalism.required'),
            'hijab_type_id.required' => __('api.user_profile_update.hijab_type_id.required'),
            'accept_poligamy.required' => __('api.user_profile_update.accept_poligamy.required'),
        ]);


        // return $request;

        $dt_personality_dimensions = $request->personality_dimensions;
        // return $dt_personality_dimensions;
        $same = [];
        if (isset($dt_personality_dimensions) && count($dt_personality_dimensions)) {
            foreach ($dt_personality_dimensions as $pd) {
                if ($pd['value'] == 3) {
                    $same[] = $pd['id'];
                }
            }
        }
        // return $same;
        if (count($same) == count($dt_personality_dimensions)) {
            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('errors' => array('personality_dimensions' => 'all values should not be same as 3'))
            ];
            Helper::save_api_logs($logdata);

            return response([
                'errors' => [
                    'personality_dimensions' => ['all values should not be same as 3']
                ],
            ], 422);
        }


        //@ update personality dimensions
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


        // //@ update profile image

        // if ($user->account_type_id==1) {
        //     if($request->has('family_profile_img')) { 


        //         if ($request->family_profile_img) {

        //             //$path = $this->_base64fileUpload($request->family_profile_img, '/profile_img');
        //             $path = $this->_normalFileUpload($request->family_profile_img,'/profile_img');
        //             $total_pic_count = UserProfileImage::where('user_id',$user->id)
        //                                             ->where('is_default',1)
        //                                             ->count();

        //             if($total_pic_count) {
        //                 $user_profile_img = UserProfileImage::where('user_id',$user->id)
        //                 ->where('is_default',1)
        //                 ->update([
        //                     'profile_img' => $path,
        //                     ]);
        //             } else{

        //                 // return $path;
        //                 $user_profile_img = UserProfileImage::create([
        //                     'user_id' => $user->id,
        //                     'profile_img' => $path,
        //                     'is_default' => 1
        //                 ]);
        //             }

        //         }
        //     } else {
        //         $path = '/profile_img/dummy_profile.png';
        //         $user_profile_img = UserProfileImage::create([
        //             'user_id' => $user->id,
        //             'profile_img' => $path,
        //             'is_default' => 1
        //         ]);
        //     }
        // } 

        // if ($user->account_type_id==2) {
        //     if($request->has('individual_profile_img')) { // individaul_profile_img
        //         // $request->validate([
        //         //     'individual_profile_img' => ['required', new Base64FileType, new Base64FileMaxSize(5120)]
        //         // ]);

        //         if ($request->individual_profile_img) {

        //             //$path = $this->_base64fileUpload($request->individual_profile_img, '/profile_img');
        //             $path = $this->_normalFileUpload($request->individual_profile_img,'/profile_img');
        //             $total_pic_count = UserProfileImage::where('user_id',$user->id)
        //                                             ->where('is_default',1)
        //                                             ->count();

        //             if($total_pic_count) {

        //                 $user_profile_data = UserProfileImage::where('user_id',$user->id)->first();
        //                 if($user_profile_data) {
        //                     $user_profile_img = UserProfileImage::
        //                     where('id',$user_profile_data->id)
        //                     ->update([
        //                         'profile_img' => $path,
        //                         'is_default' => 1
        //                     ]);
        //                 } 

        //             } else{

        //                 // return $path;
        //                 $user_profile_img = UserProfileImage::create([
        //                     'user_id' => $user->id,
        //                     'profile_img' => $path,
        //                     'is_default' => 1
        //                 ]);
        //             }

        //         }
        //     } else {
        //         $path = '/profile_img/dummy_profile.png';
        //         $user_profile_img = UserProfileImage::create([
        //             'user_id' => $user->id,
        //             'profile_img' => $path,
        //             'is_default' => 1
        //         ]);
        //     }
        // } 




        $req_data = $request->only(
            'name',
            'gender',
            'dob',
            'status',
            //  'region_id',
            'bio',
            // 'nationality_id',
            // 'resident_country_id',
            // 'family_origin_id',
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
            // 'is_your_family_tribal',
            'sect_id',
            'other',
            'do_you_care_about_tribalism',
            'hijab_type_id',
            'accept_poligamy',
            'does_she_or_he_has_flexibility_to_marry_a_married_man'
        );

        //    @update master user table
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
            'tribe_id',
            //'bio'
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
            $user->update($req_master_data); // only for first timme else for add member
        }


        $req_data['user_id'] = $user->id;
        if (!empty($request->height)) {
            $step = $request->step;
            $height_min;
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

            // update family member
            //dd($user_family);
            $new_family_member = UserFamily::where('id', $user_family->id)->update($req_data);
            //($req_data);
            //add image for member
            // $family_user_id = $user_family->id;
            // //dd($family_user_id);
            // $family_user=UserFamily::where('id',$user_family->id)->first();
            // $profile_pic = [];
            // $total_pic_count = UserFamilyProfileImage::where('user_family_id',$user_family->id)->where('is_default',1)->count();
            // if($total_pic_count) {


            //         if(isset($request->member_profile_img)) {
            //             $image = $request->member_profile_img;
            //             if (!empty($image)) {
            //                 //$path = $this->_base64fileUpload($image, '/family_profile_img');
            //                 $path = $this->_normalFileUpload($image,'/family_profile_img');
            //                 // return $path;
            //                     $user_profile_img = UserFamilyProfileImage::where('user_family_id',$family_user_id)
            //                     ->where('is_default',1)
            //                     ->update([
            //                         'profile_img' => $path,
            //                     ]);
            //             }

            //         } else {
            //             $path = '/family_profile_img/dummy_profile.png';
            //             $user_profile_img = UserFamilyProfileImage::create([
            //                 'user_family_id' => $family_user_id,
            //                 'profile_img' => $path,
            //                 'is_default' => 1
            //             ]);
            //         }

            // } else {
            //     if(isset($request->member_profile_img)) {
            //         $image = $request->member_profile_img;
            //         if (!empty($image)) {
            //             //$path = $this->_base64fileUpload($image, '/family_profile_img');
            //             $path = $this->_normalFileUpload($image,'/family_profile_img');
            //             // return $path;
            //             $user_profile_img = UserFamilyProfileImage::create([
            //                 'user_family_id' => $family_user_id,
            //                 'profile_img' => $path,
            //                 'is_default' => 1
            //             ]);
            //         }

            //     } else {
            //         $path = '/family_profile_img/dummy_profile.png';
            //         $user_profile_img = UserFamilyProfileImage::create([
            //             'user_family_id' => $family_user_id,
            //             'profile_img' => $path,
            //             'is_default' => 1
            //         ]);
            //     }
            // }

        } else {
            // update individual
            $user_family->update($req_data);
        }

        $user_id = Auth::user()->id;
        $user = User::find($user_id);



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

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('success' => true,
            'data' => $verfied_data,
            'member_id' => $user_family->id,
            'message' => $message)
        ];
        Helper::save_api_logs($logdata);

        return [
            'success' => true,
            'data' => $verfied_data,
            'member_id' => $user_family->id,
            'message' => $message
        ];
    }


    public function user_basic_profile_edit(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
       // $user_family = UserFamily::where('user_default_id', $user->id)->first();

        if (!$user->username) {
            $request->validate([
                //'name'=>'required|min:4|max:20',
                'username' => ['required', 'starts_with:@', 'unique:users,username,' . $user->id, new StrMaxNumber(4)]
            ], [
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
        // @ dob fields

        //@ account type
        if (!$user->account_type_id) {
            $request->validate([
                'account_type_id' => 'required|exists:account_types,id'
            ], [
                'account_type_id.required' => __('api.set_profile_info.form_fields.account_type_id.required'),
                'account_type_id.exists' => __('api.set_profile_info.form_fields.account_type_id.exists'),
            ]);
            $user->update(['account_type_id' => $request->account_type_id]);
        }

        if ($request->account_type_id == 2 || $request->account_type_id == 1 || $user->account_type_id) { // only case of individual
            $user_family = UserFamily::where('user_default_id', $user->id)->first();
            //dd($user_family);
            if (!$user_family) {
                $user_family = UserFamily::create(['user_id' => $user->id, 'user_default_id' => $user->id]);
            }
        }

        // @name
        if ($user->account_type_id == 2 && !$user_family->name || $user->account_type_id == 1 && !$user->name) {
            
            $request->validate([
                'name' => ['required', 'max:20', new StrMaxNumber(4)],
            ], [
                'name.required' => __('api.set_profile_info.form_fields.name.required'),
                'name.max' => __('api.set_profile_info.form_fields.name.max'),
                'name.min' => __('api.set_profile_info.form_fields.name.min'),
                // 'username.required'=>__('api.set_profile_info.form_fields.username.required'),
                // 'username.unique'=>__('api.set_profile_info.form_fields.username.unique'),
            ]);
            if ($user->account_type_id == 1) {
                $user->update(['name' => $request->name]);
            } else {
                $user->update(['name' => $request->name]);
                $user_family->update(['name' => $request->name]);
            }
        }        

        if (($user->account_type_id == 2) && !$user_family->dob) {
            $request->validate([
                'dob' => 'required|date|before:' . now()->subYears(17)->toDateString(),

            ], [
                'dob.required' => __('api.set_profile_info.form_fields.dob.required'),
                'dob.date' => __('api.set_profile_info.form_fields.dob.date'),
                'dob.before' => __('api.set_profile_info.form_fields.dob.before'),
            ]);
            $user_family->update(['dob' => $request->dob]);
        }
        // @ gender [male,female,other]
        if (($user->account_type_id == 2) && !$user_family->gender) {
            $request->validate([
                'gender' => 'required|in:male,female,other',

            ], [
                'gender.required' => __('api.set_profile_info.form_fields.gender.required'),
                'gender.in' => __('api.set_profile_info.form_fields.gender.in'),
            ]);
            $user_family->update(['gender' => $request->gender]);
        }
        

        $verfied_data = Helper::user_all_detail($user);


        //message come form db
        $message_text = __('api.user_profile_update.success_message');
        $message_data = Helper::getMessageByCode('NOT08');
        $prefered_lag = $user->default_language;
        if ($prefered_lag == 'en') {
            $message_text = $message_data->message_value_en;
        } else {
            $message_text = $message_data->message_value_ar;
        }

        $response = [
            'success' => true,
            'message' => $message_text
        ];

        $response['data']['user'] = $verfied_data;

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => $response
        ];
        Helper::save_api_logs($logdata);

        return $response;
    }

    public function get_other_avaliable_users_old(Request $request, $account_type = null, $sent_connection_request = null)
    {
        //dd(Auth::user()->id);
        //dd($request->all());
        $message = '';
        if ($request->has('recepintUser')) {
            $username = Helper::getUserName($request->recepintUser);

            $message_data = Helper::getMessageByCode('NOT011');
            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }
            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }
        if ($request->has('is_liked')) {

            $message = $request->is_liked ? trans('api.common.successfully_liked') : trans('api.common.successfully_disliked');
            if ($request->is_liked) {
                $message_data = Helper::getMessageByCode('NOT09');
            } else {
                $message_data = Helper::getMessageByCode('NOT010');
            }

            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }

            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }

        if ($request->has('is_reported')) {

            if ($request->is_reported) {
                $message_data = Helper::getMessageByCode('NOT018');
            }
            if ($request->is_blocked == 0) {
                $message_data = Helper::getMessageByCode('NOT022');
            }

            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }

            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }

        if ($request->has('is_blocked')) {


            if (1) {
                $message_data = Helper::getMessageByCode('NOT022');
            }

            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }

            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }


        // GENERAL DATA
        $commonIcon = CommonIcon::all();

        //dd($request->filter_option);
        //return User::with('education_detail')->get();

        //\DB::enableQueryLog(); // Enable query log
        $list = User::query()->select('users.*')->with('account_type');
        //->with('profile_images')

        $list = $list->with('members');

        $list = $list
            ->with('members.skin_detail')
            ->with('members.work_detail')
            ->with('members.education_detail')
            ->with('members.children_detail')
            ->with('members.sect_detail')
            ->with('members.hijab_detail')
        
            ->with('family_origin_detail')
            ->with('nationality_detail')
            ->with('nationality_current_detail')
            ->with('live_in_city_detail')
            ->with('tribe_detail')
            ->has('user_has_active_subscription')
            ->with('personality_dimension');
            

        // if(Auth::user()->status == 'yellow') {
        //     $list->leftJoin('user_yellow_connections','user_yellow_connections.request_id','users.id')
        //           ->where('user_yellow_connections.user_id',Auth::user()->id);
        // } 


        /*
        DB::raw("(SELECT round(AVG( ratings ), 2) FROM user_ratings WHERE user_ratings.user_id = orders.user_id) as ratings")
        */
        if (Auth::user()->status == 'red') {
            $list->leftJoin('user_red_connections', 'user_red_connections.request_id', 'users.id')
                ->where('user_red_connections.user_id', Auth::user()->id);
        }

        if ($sent_connection_request) {
            $user_id = Auth::user()->id;
            $connected_users_ids = Helper::get_all_connected_users_array($user_id);
            //dd($connected_users_ids);
            $list = $list->whereIn('users.id', $connected_users_ids);
        }





        //$list = $list->where('user_families.is_hide',0);

        //dd($request->search_keyword);
        $list = Helper::custom_user_filter($list, $account_type, $request->search_keyword, $request->filter_option);

        if (empty($request->search_keyword) && !isset($request->filter_apply)) {
            if (Session::has('shown_user_ids') && $request->page != 1) {
                $user_id = Auth::user()->id;
                $user_ids_not_to_display = Session::get('shown_user_ids');
                //dd($user_ids_not_to_display[$user_id]);
                if (isset($user_ids_not_to_display[$user_id])) {
                    $list = $list->whereNotIn('users.id', $user_ids_not_to_display[$user_id]);
                }
            } else {
                $user_id = Auth::user()->id;
                $user_ids_not_to_display[$user_id] = [];
            }
        } else {
            if (Session::has('shown_user_ids') && $request->page != 1) {
                $user_id = Auth::user()->id;
                $user_ids_not_to_display = Session::get('shown_user_ids');
                //dd($user_ids_not_to_display[$user_id]);
                if (isset($user_ids_not_to_display[$user_id])) {
                    $list = $list->whereNotIn('users.id', $user_ids_not_to_display[$user_id]);
                }
            } else {
                $user_id = Auth::user()->id;
                $user_ids_not_to_display[$user_id] = [];
            }
        }

        $list = $list->whereHas('members', function ($list) {
            $list->where('is_hide', 0);
        });

        $list = $list->where('users.is_completed', 1)
            ->where('users.mobile', '!=', Auth::user()->mobile)
            ->where('users.account_blocked', '!=', 1)
            ->where('users.id', '!=', 1);

        $user_id = Auth::user()->id;

        if ($request->page == 1) {
            $list_count = $list->count();
            $total_user_count = [];
            $total_user_count[$user_id] = $list_count;
            Session::put('total_users', $total_user_count);
        } else {
            $list_count = Session::get('total_users');
        }



        if (empty($request->search_keyword) && !isset($request->filter_apply)) {

            $list = $list->inRandomOrder();
            //$list = $list->orderBy('users.id','desc');
        } else {
            $list = $list->orderBy('users.id', 'desc');
        }



        if ($request->page != 1) {
            $user_ids_not_to_display[$user_id] = Session::has('shown_user_ids') ? Session::get('shown_user_ids') : [];
        }




        if ($request->page == 1 && (isset($user_ids_not_to_display[$user_id]) && $list_count > count($user_ids_not_to_display[$user_id]))) {
            $shown_user_ids = [];
            // $query = str_replace(array('?'), array('\'%s\''), $list->toSql());
            // $query = vsprintf($query, $list->getBindings());
            // dump($query);
            // die;
            $list = $list->take(10)->get();
        } else if ((isset($user_ids_not_to_display[$user_id]) && $list_count > count($user_ids_not_to_display[$user_id]))) {
            // $query = str_replace(array('?'), array('\'%s\''), $list->toSql());
            // $query = vsprintf($query, $list->getBindings());
            // dump($query);
            // die;
            $list = $list->take(10)->get();
        } else {

            // $query = str_replace(array('?'), array('\'%s\''), $list->toSql());
            // $query = vsprintf($query, $list->getBindings());
            // dump($query);
            // die;
            if (isset($user_ids_not_to_display[$user_id]) && count($user_ids_not_to_display[$user_id]) < 10) {
                $list = $list->take(10)->get();
            } else {
                $list = $list->take(10)->get();
            }
        }



        //
        //dd(\DB::getQueryLog()); // Show results of log

        //dd($list);
        //dd($user_ids_not_to_display[$user_id]);

        // return $list;
        $shown_user_ids = [];
        $new_list['data'] = [];
        //$new_list['data2'] = [];
        if (count($list) > 0) {

            //dd($shown_user_ids);
            foreach ($list as $user) {

                // Undefined error occured so I have written isset condition
                if ($request->page != 1 && (isset($user_ids_not_to_display[$user_id]) && !in_array($user->id, $user_ids_not_to_display[$user_id]))) {

                    $shown_user_ids[$user_id][] = $user->id;

                    $member_detaail = Helper::user_all_detail($user);
                    $user->members = $member_detaail;
                    $new_list['data'][] = $user;
                }
                if ($request->page == 1) {
                    $shown_user_ids[$user_id][] = $user->id;

                    $member_detaail = Helper::user_all_detail($user);
                    $user->members = $member_detaail;
                    $new_list['data'][] = $user;
                }


                if ($user->individual_detail) {
                    $temp_about_me = [];
                    $temp_education_and_carrer=[];
                    $temp_social=[];
                    if($user->account_type_id == 2) { // family
                        foreach ($user->individual_detail as $member) {
                        
                            $height_obj = isset($member->height_detail) ? $member->height_detail : '';
                            if(!empty($height_obj)) {
                                $height_obj->icon = $commonIcon->where('name','height')->first()->icon??'';
                                $height_obj->tag_name_en = isset($member->height_detail) ? '📏 '.$member->height_detail->height_min . ' - '.$member->height_detail->height_max . ' cm'  : '';
                                $height_obj->tag_name_ar = isset($member->height_detail) ? '📏 '.$member->height_detail->height_min . ' - '.$member->height_detail->height_max . ' cm'  : ''; 
                            }
                            
                            
                            $skin_color=isset($member->skin_detail)?$member->skin_detail:'';
                            if(!empty($skin_color)) {
                                $skin_color->tag_name_en =  isset($member->skin_detail) ? '👨 '.trans('api.common.skin', [ 'attribute' => $member->skin_detail->name_en ], 'en')  : '';
                                $skin_color->tag_name_ar =  isset($member->skin_detail->name_ar) ? '👨 '.trans('api.common.skin', [ 'attribute' => $member->skin_detail->name_ar ], 'ar')  : '';
                            }
    
                            $children=isset($member->children_detail)?$member->children_detail:'';
                            //Has 1 child
                            if(!empty($children)) {
                                $children->tag_name_en =  isset($member->children_detail) ? '👶 '.$member->children_detail->children_number_en  : '';
                                $children->tag_name_ar =  isset($member->children_detail) ? '👶 '.$member->children_detail->children_number_ar  : '';
                            }
                            // @ education and career Undergraduate studies
                            $education=isset($member->education_detail)?$member->education_detail:'';
                            if(!empty($education)) {
                                $education->tag_name_en =  isset($member->education_detail) ? '🎓 '.$member->education_detail->name_en  : '';
                                $education->tag_name_ar =  isset($member->education_detail) ? '🎓 '.$member->education_detail->name_ar  : '';
                            }
                            // Freelancer
                            $career=isset($member->work_detail)?$member->work_detail:'';
                            if(!empty($career)) {
                                $career->tag_name_en =  isset($member->work_detail) ? '💼 '.$member->work_detail->name_en  : '';
                                $career->tag_name_ar =  isset($member->work_detail) ? '💼 '.$member->work_detail->name_ar  : '';
                            }
                            // @ social
                            $sect=isset($member->sect_detail)?$member->sect_detail:'';
                            
                            if(!empty($sect)) {
                                $sect->tag_name_en =  isset($member->sect_detail) ? '🌑 '.$member->sect_detail->name_en  : '';
                                $sect->tag_name_ar =  isset($member->sect_detail) ? '🌑 '.$member->sect_detail->name_ar  : '';
                            }
                            
                            $tribal=isset($user->tribe_detail)?$user->tribe_detail:'';
    
                            if(!empty($tribal)) {
                                $tribal->tag_name_en=isset($user->tribe_detail->name_en)? '👥 '.trans('api.common.tribe', [ 'attribute' => $user->tribe_detail->name_en ], 'en') :'';
                                $tribal->tag_name_ar=isset($user->tribe_detail->name_ar)? '👥 '.trans('api.common.tribe', [ 'attribute' => $user->tribe_detail->name_ar ], 'ar') :'';
                            }
                            
    
                            $hijab=isset($member->hijab_detail)?$member->hijab_detail:'';
                            if(!empty($hijab)) {
                               
                                $hijab->tag_name_en =  isset($member->hijab_detail) ? '👩🏻 '.$member->hijab_detail->name_en  : '';
                                $hijab->tag_name_ar =  isset($member->hijab_detail) ? '👩🏻 '.$member->hijab_detail->name_ar  : '';
                                
                            }
                            
                            $yes_no_obj=[
                                "yes"=>['name_en'=>'YES','name_ar'=>'نعم'],
                                "no"=>['name_en'=>'NO','name_ar'=>'رقم'],
                                "sometimes" => ['name_en'=>'Sometimes','name_ar'=>'رقم']
                            ];
                            // current marriedCurrently married
                            $currently_married_obj=[
                                "married"=> true,
                                "value"=> ($member->currently_married=='yes')?'currently married':'not married',
                                "tag_name_en" => ($member->currently_married=='yes') ? '💍 '.trans('api.common.currently_married', [ 'attribute' => '' ], 'en') : '💍 '.trans('api.common.not_married', [ 'attribute' => '' ], 'en'),
                                "tag_name_ar" => ($member->currently_married=='yes') ? '💍 '.trans('api.common.currently_married', [ 'attribute' => '' ], 'ar') : '💍 '.trans('api.common.not_married', [ 'attribute' => '' ], 'ar'),
                                "icon"=> $commonIcon->where('name','currently_married')->first()->icon??''
                            ];
                            // $currently_married_obj=(isset($member->currently_married) && $member->currently_married)?$yes_no_obj[$member->currently_married]:[];
                            // $currently_married_obj['icon']=$commonIcon->where('name','currently_married')->first()->icon??'';
                            // @ smoking obj
                            $smoking_obj=(isset($member->smoking) && $member->smoking)?$yes_no_obj[$member->smoking]:[];
                            //Non-smoker
                            $smoking_tag_en = ''; $smoking_tag_ar = '';
                            if($member->smoking == 'yes') {
                                $smoking_tag_en = '🚬 '.trans('api.common.smoke', [ 'attribute' => '' ], 'en');
                                $smoking_tag_ar = '🚬 '.trans('api.common.smoke', [ 'attribute' => '' ], 'ar');
                            } else if($member->smoking == 'sometimes') {
                                $smoking_tag_en = '🚬 '.trans('api.common.sometimes_smoke', [ 'attribute' => '' ], 'en');
                                $smoking_tag_ar = '🚬 '.trans('api.common.sometimes_smoke', [ 'attribute' => '' ], 'ar');
                            } else {
                                $smoking_tag_en = '🚭 '.trans('api.common.no_smoke', [ 'attribute' => '' ], 'en');
                                $smoking_tag_ar = '🚭 '.trans('api.common.no_smoke', [ 'attribute' => '' ], 'ar');
                            }
                            $smoking_obj['tag_name_en'] =  $smoking_tag_en;
                            $smoking_obj['tag_name_ar'] =  $smoking_tag_ar;
                            $smoking_obj['icon']=$commonIcon->where('name','smoking')->first()->icon;
    
    
                            $care_tribalism_obj=(isset($member->do_you_care_about_tribalism) && 
                            $member->do_you_care_about_tribalism)?$yes_no_obj[$member->do_you_care_about_tribalism]:[];
    
    
                            $care_tribalism_obj_en = ''; $care_tribalism_obj_ar = '';
                            if($member->do_you_care_about_tribalism == 'yes') {
                                $care_tribalism_obj_en = '👤 ' . trans('api.common.care_about_tribalism', ['attribute' => ''], 'en');
                                $care_tribalism_obj_ar = '👤 ' . trans('api.common.care_about_tribalism', ['attribute' => ''], 'ar');
                            } else {
                                $care_tribalism_obj_en = '👤 ' . trans('api.common.not_care_about_tribalism', ['attribute' => ''], 'en');
                                $care_tribalism_obj_ar = '👤 ' . trans('api.common.not_care_about_tribalism', ['attribute' => ''], 'ar');
                            }
    
                            $care_tribalism_obj['tag_name_en'] =  $care_tribalism_obj_en;
                            $care_tribalism_obj['tag_name_ar'] =   $care_tribalism_obj_ar;
    
                            $care_tribalism_obj['icon']=$commonIcon->where('name','is_tribal')->first()->icon??'';
                            // @is tribal
                            $is_tribal_obj=(isset($user->is_your_family_tribal) && $user->is_your_family_tribal)
                                             ?$yes_no_obj[$user->is_your_family_tribal]:[];
    
    
                            $is_tribal_obj_en = ''; $is_tribal_obj_ar = '';
                            if($user->is_your_family_tribal == 'yes') {
                                $is_tribal_obj_en = '👤 ' . trans('api.common.tribal_person', ['attribute' => ''], 'en');
                                $is_tribal_obj_ar = '👤 ' . trans('api.common.tribal_person', ['attribute' => ''], 'ar');
                            } else {
                                $is_tribal_obj_en = '👤 ' . trans('api.common.not_tribal_person', ['attribute' => ''], 'en');
                                $is_tribal_obj_ar = '👤 ' . trans('api.common.not_tribal_person', ['attribute' => ''], 'ar');
                            }
    
                            $is_tribal_obj['tag_name_en'] = $is_tribal_obj_en;
                            $is_tribal_obj['tag_name_ar'] = $is_tribal_obj_ar;
                            $is_tribal_obj['icon']=$commonIcon->where('name','is_tribal')->first()->icon??'';
    
                            
                           
                            $temp_about_me = [
                                'height'=>$height_obj,
                                'skin_color' => $skin_color,
                                'currently_married' => $currently_married_obj,
                                'children' => $children,
                            ];
                            $temp_education_and_career=[
                                'education'=>$education,
                                'career'=>$career
                            ];
                            $temp_social=[
                                'sect'=>$sect,
                                'smoking'=>$smoking_obj,
                                // 'smoking'=>["value"=>($smoking=='yes')?__('admin_dashboard.common.yes'):__('admin_dashboard.common.no')],
                                'Tribal_Person'=>$is_tribal_obj,
                                'tribal'=>$tribal,
                                'Cares_About_Tribalism'=>$care_tribalism_obj,
                                'Flexible_About_Hijab'=>$hijab,
                            ];
    
                            $member->about_me_arr=array_merge($about_me_arr,$temp_about_me);
                            $member->education_and_career_arr=$temp_education_and_career;
                            $member->social_arr=$temp_social;
                            $member->profile_images = Helper::get_profile_individual_or_family_images($member);
                            $member->user_likes_hide_blocked= Helper::user_likes_hide_blocked($member->id,'member');
                        }
                    } 
                    
                    
                }

                
            }


            //@ take random
            //dd(Session::get('shown_user_ids'));
            //dd($request->page);

            if (Session::has('shown_user_ids') && $request->page != 1) {
                $already_shown_users = Session::get('shown_user_ids');
                //dd($already_shown_users[$user_id]);
                if (isset($already_shown_users[$user_id]) && isset($shown_user_ids[$user_id])) {
                    //dd($shown_user_ids);
                    $shown_user_ids[$user_id] = array_merge($already_shown_users[$user_id], $shown_user_ids[$user_id]);
                }
                Session::put('shown_user_ids', $shown_user_ids);
            } else if ($request->page == 1) { //page == 1
                Session::put('shown_user_ids', $shown_user_ids);
                //dd(Session::get('shown_user_ids'));
            }



            $user_id = Auth::user()->id;
            $user = User::find($user_id);


            $verfied_data = Helper::user_all_detail($user);
            // $list = json_decode(json_encode($list), true);
            // foreach($list['data'] as $key => $users)
            // {
            //     //dd($users['members']);
            //     if(!empty($users['members']))
            //     {
            //         foreach($users['members'] as $mkey => $mems)
            //         {
            //             if($mems['is_hide'] == 1)
            //             {
            //                 unset($users['members'][$mkey]);
            //             }
            //         }
            //     }
            //     $list['data'][$key]['members'] = array_values($users['members']);
            // }
            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('status' => true,
                'message' => $message,
                'list_count' => $list_count,
                'shown_user_ids' => Session::get('shown_user_ids'),
                'search_keyword' => $request->search_keyword,
                'data' => $new_list,
                'user_detail' => $verfied_data)
            ];
            Helper::save_api_logs($logdata);

            $response = [
                'status' => true,
                'message' => $message,
                'list_count' => $list_count,
                'shown_user_ids' => Session::get('shown_user_ids'),
                'search_keyword' => $request->search_keyword,
                'data' => $new_list,
                'user_detail' => $verfied_data
            ];
        } else {

            $shown_user_ids[$user_id] = [];
            $message_data = Helper::getMessageByCode('NOT012');
            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }
            $message = $message_text;

            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('status' => true,
                'list_count' => $list_count,
                'shown_user_ids' => $shown_user_ids,
                'search_keyword' => $request->search_keyword,
                'message' => $message,
                'data' => [])
            ];
            Helper::save_api_logs($logdata);

            $response = [
                'status' => true,
                'list_count' => $list_count,
                'shown_user_ids' => $shown_user_ids,
                'search_keyword' => $request->search_keyword,
                'message' => $message,
                'data' => []
            ];
        }

        return $response;
    }

    public function get_other_avaliable_users(Request $request, $account_type = null, $sent_connection_request = null)
    {
        //dd(Auth::user()->id);
        //dd($request->all());
        $message = '';
        if ($request->has('recepintUser')) {
            $username = Helper::getUserName($request->recepintUser);

            $message_data = Helper::getMessageByCode('NOT011');
            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }
            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }
        if ($request->has('is_liked')) {

            $message = $request->is_liked ? trans('api.common.successfully_liked') : trans('api.common.successfully_disliked');
            if ($request->is_liked) {
                $message_data = Helper::getMessageByCode('NOT09');
            } else {
                $message_data = Helper::getMessageByCode('NOT010');
            }

            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }

            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }

        if ($request->has('is_reported')) {

            if ($request->is_reported) {
                $message_data = Helper::getMessageByCode('NOT018');
            }
            if ($request->is_blocked == 0) {
                $message_data = Helper::getMessageByCode('NOT022');
            }

            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }

            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }

        if ($request->has('is_blocked')) {


            if (1) {
                $message_data = Helper::getMessageByCode('NOT022');
            }

            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }

            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }


        // GENERAL DATA
        $commonIcon = CommonIcon::all();

        //dd($request->filter_option);
        //return User::with('education_detail')->get();

        //\DB::enableQueryLog(); // Enable query log
        $list = User::query()->select('users.*')->with('account_type');
        //->with('profile_images')

        $list = $list->with('members');

        $list = $list
            ->with('profile_images_list')
            ->with('members.profile_images_list')
            //->with('members.skin_detail')
            //->with('members.work_detail')
            //->with('members.education_detail')
            //->with('members.children_detail')
            //->with('members.sect_detail')
            //->with('members.hijab_detail')
        
            //->with('family_origin_detail')
            //->with('nationality_detail')
            //->with('nationality_current_detail')
            ->with('live_in_city_detail')
            //->with('tribe_detail')
            ->has('user_has_active_subscription');
            
            //->with('personality_dimension')
            

        // if(Auth::user()->status == 'yellow') {
        //     $list->leftJoin('user_yellow_connections','user_yellow_connections.request_id','users.id')
        //           ->where('user_yellow_connections.user_id',Auth::user()->id);
        // } 


        /*
        DB::raw("(SELECT round(AVG( ratings ), 2) FROM user_ratings WHERE user_ratings.user_id = orders.user_id) as ratings")
        */
        if (Auth::user()->status == 'red') {
            $list->leftJoin('user_red_connections', 'user_red_connections.request_id', 'users.id')
                ->where('user_red_connections.user_id', Auth::user()->id);
        }

        if ($sent_connection_request) {
            $user_id = Auth::user()->id;
            $connected_users_ids = Helper::get_all_connected_users_array($user_id);
            //dd($connected_users_ids);
            $list = $list->whereIn('users.id', $connected_users_ids);
        }

        

        //$list = $list->where('user_families.is_hide',0);

        //dd($request->search_keyword);
        $list = Helper::custom_user_filter($list, $account_type, $request->search_keyword, $request->filter_option);

        if (empty($request->search_keyword) && !isset($request->filter_apply)) {
            if (Session::has('shown_user_ids') && $request->page != 1) {
                $user_id = Auth::user()->id;
                $user_ids_not_to_display = Session::get('shown_user_ids');
                //dd($user_ids_not_to_display[$user_id]);
                if (isset($user_ids_not_to_display[$user_id])) {
                    $list = $list->whereNotIn('users.id', $user_ids_not_to_display[$user_id]);
                }
            } else {
                $user_id = Auth::user()->id;
                $user_ids_not_to_display[$user_id] = [];
            }
        } else {
            if (Session::has('shown_user_ids') && $request->page != 1) {
                $user_id = Auth::user()->id;
                $user_ids_not_to_display = Session::get('shown_user_ids');
                //dd($user_ids_not_to_display[$user_id]);
                if (isset($user_ids_not_to_display[$user_id])) {
                    $list = $list->whereNotIn('users.id', $user_ids_not_to_display[$user_id]);
                }
            } else {
                $user_id = Auth::user()->id;
                $user_ids_not_to_display[$user_id] = [];
            }
        }

        $list = $list->whereHas('members', function ($list) {
            $list->where('is_hide', 0);
        });

        $list = $list->where('users.is_completed', 1)
            ->where('users.mobile', '!=', Auth::user()->mobile)
            ->where('users.account_blocked', '!=', 1)
            ->where('users.id', '!=', 1);

        $user_id = Auth::user()->id;

        if ($request->page == 1) {
            $list_count = $list->count();
            $total_user_count = [];
            $total_user_count[$user_id] = $list_count;
            Session::put('total_users', $total_user_count);
        } else {
            $list_count = Session::get('total_users');
        }



        if (empty($request->search_keyword) && !isset($request->filter_apply)) {

            $list = $list->inRandomOrder();
            //$list = $list->orderBy('users.id','desc');
        } else {
            $list = $list->inRandomOrder(); //$list->orderBy('users.id', 'desc');
        }



        if ($request->page != 1) {
            $user_ids_not_to_display[$user_id] = Session::has('shown_user_ids') ? Session::get('shown_user_ids') : [];
        }




        if ($request->page == 1 && (isset($user_ids_not_to_display[$user_id]) && $list_count > count($user_ids_not_to_display[$user_id]))) {
            $shown_user_ids = [];
            // $query = str_replace(array('?'), array('\'%s\''), $list->toSql());
            // $query = vsprintf($query, $list->getBindings());
            // dump($query);
            // die;
            $list = $list->take(10)->get();
        } else if ((isset($user_ids_not_to_display[$user_id]) && $list_count > count($user_ids_not_to_display[$user_id]))) {
            // $query = str_replace(array('?'), array('\'%s\''), $list->toSql());
            // $query = vsprintf($query, $list->getBindings());
            // dump($query);
            // die;
            $list = $list->take(10)->get();
        } else {

            // $query = str_replace(array('?'), array('\'%s\''), $list->toSql());
            // $query = vsprintf($query, $list->getBindings());
            // dump($query);
            // die;
            if (isset($user_ids_not_to_display[$user_id]) && count($user_ids_not_to_display[$user_id]) < 10) {
                $list = $list->take(10)->get();
            } else {
                $list = $list->take(10)->get();
            }
        }



        //
        //dd(\DB::getQueryLog()); // Show results of log

        //dd($list);
        //dd($user_ids_not_to_display[$user_id]);

        // return $list;
        $shown_user_ids = [];
        $new_list['data'] = [];
        //$new_list['data2'] = [];
        if (count($list) > 0) {

            //dd($shown_user_ids);
            foreach ($list as $user) {

                $not_blocked = Helper::get_other_blocked_users(Auth::user()->id, $user->id);
                if($not_blocked) {

                
                    // Undefined error occured so I have written isset condition
                    if ($request->page != 1 && (isset($user_ids_not_to_display[$user_id]) && !in_array($user->id, $user_ids_not_to_display[$user_id]))) {

                        $shown_user_ids[$user_id][] = $user->id;

                        //$member_detaail = Helper::user_all_detail($user);
                        //$user->members = $member_detaail;
                        $user->family_members_male_count = $user->members()->where('is_hide', 0)->where('gender', 'male')->count();
                        $user->family_members_female_count = $user->members()->where('is_hide', 0)->where('gender', 'female')->count();
                        $new_list['data'][] = $user;
                    }
                    if ($request->page == 1) {
                        $shown_user_ids[$user_id][] = $user->id;

                        //$member_detaail = Helper::user_all_detail($user);
                        //$user->members = $member_detaail;
                        $user->family_members_male_count = $user->members()->where('is_hide', 0)->where('gender', 'male')->count();
                        $user->family_members_female_count = $user->members()->where('is_hide', 0)->where('gender', 'female')->count();
                        $new_list['data'][] = $user;
                    }


                    if ($user->individual_detail) {
                        $temp_about_me = [];
                        $temp_education_and_carrer=[];
                        $temp_social=[];
                        if($user->account_type_id == 2) { // family
                            foreach ($user->individual_detail as $member) {
                            
                                /*
                                $height_obj = isset($member->height_detail) ? $member->height_detail : '';
                                if(!empty($height_obj)) {
                                    $height_obj->icon = $commonIcon->where('name','height')->first()->icon??'';
                                    $height_obj->tag_name_en = isset($member->height_detail) ? '📏 '.$member->height_detail->height_min . ' - '.$member->height_detail->height_max . ' cm'  : '';
                                    $height_obj->tag_name_ar = isset($member->height_detail) ? '📏 '.$member->height_detail->height_min . ' - '.$member->height_detail->height_max . ' cm'  : ''; 
                                }
                                */
                                
                                /*
                                $skin_color=isset($member->skin_detail)?$member->skin_detail:'';
                                if(!empty($skin_color)) {
                                    $skin_color->tag_name_en =  isset($member->skin_detail) ? '👨 '.trans('api.common.skin', [ 'attribute' => $member->skin_detail->name_en ], 'en')  : '';
                                    $skin_color->tag_name_ar =  isset($member->skin_detail->name_ar) ? '👨 '.trans('api.common.skin', [ 'attribute' => $member->skin_detail->name_ar ], 'ar')  : '';
                                }
                                */
        
                                /*
                                $children=isset($member->children_detail)?$member->children_detail:'';
                                //Has 1 child
                                if(!empty($children)) {
                                    $children->tag_name_en =  isset($member->children_detail) ? '👶 '.$member->children_detail->children_number_en  : '';
                                    $children->tag_name_ar =  isset($member->children_detail) ? '👶 '.$member->children_detail->children_number_ar  : '';
                                }
                                */
                                // @ education and career Undergraduate studies
                                /*
                                $education=isset($member->education_detail)?$member->education_detail:'';
                                if(!empty($education)) {
                                    $education->tag_name_en =  isset($member->education_detail) ? '🎓 '.$member->education_detail->name_en  : '';
                                    $education->tag_name_ar =  isset($member->education_detail) ? '🎓 '.$member->education_detail->name_ar  : '';
                                }
                                */
                                /*
                                // Freelancer
                                $career=isset($member->work_detail)?$member->work_detail:'';
                                if(!empty($career)) {
                                    $career->tag_name_en =  isset($member->work_detail) ? '💼 '.$member->work_detail->name_en  : '';
                                    $career->tag_name_ar =  isset($member->work_detail) ? '💼 '.$member->work_detail->name_ar  : '';
                                }
                                */
                                /*
                                // @ social
                                $sect=isset($member->sect_detail)?$member->sect_detail:'';
                                
                                if(!empty($sect)) {
                                    $sect->tag_name_en =  isset($member->sect_detail) ? '🌑 '.$member->sect_detail->name_en  : '';
                                    $sect->tag_name_ar =  isset($member->sect_detail) ? '🌑 '.$member->sect_detail->name_ar  : '';
                                }
                                */
                                /*
                                $tribal=isset($user->tribe_detail)?$user->tribe_detail:'';
        
                                if(!empty($tribal)) {
                                    $tribal->tag_name_en=isset($user->tribe_detail->name_en)? '👥 '.trans('api.common.tribe', [ 'attribute' => $user->tribe_detail->name_en ], 'en') :'';
                                    $tribal->tag_name_ar=isset($user->tribe_detail->name_ar)? '👥 '.trans('api.common.tribe', [ 'attribute' => $user->tribe_detail->name_ar ], 'ar') :'';
                                }
                                */
                                /*
                                $hijab=isset($member->hijab_detail)?$member->hijab_detail:'';
                                if(!empty($hijab)) {
                                
                                    $hijab->tag_name_en =  isset($member->hijab_detail) ? '👩🏻 '.$member->hijab_detail->name_en  : '';
                                    $hijab->tag_name_ar =  isset($member->hijab_detail) ? '👩🏻 '.$member->hijab_detail->name_ar  : '';
                                    
                                }
                                */
                                /*
                                $yes_no_obj=[
                                    "yes"=>['name_en'=>'YES','name_ar'=>'نعم'],
                                    "no"=>['name_en'=>'NO','name_ar'=>'رقم'],
                                    "sometimes" => ['name_en'=>'Sometimes','name_ar'=>'رقم']
                                ];
                                */
                                /*
                                // current marriedCurrently married
                                $currently_married_obj=[
                                    "married"=> true,
                                    "value"=> ($member->currently_married=='yes')?'currently married':'not married',
                                    "tag_name_en" => ($member->currently_married=='yes') ? '💍 '.trans('api.common.currently_married', [ 'attribute' => '' ], 'en') : '💍 '.trans('api.common.not_married', [ 'attribute' => '' ], 'en'),
                                    "tag_name_ar" => ($member->currently_married=='yes') ? '💍 '.trans('api.common.currently_married', [ 'attribute' => '' ], 'ar') : '💍 '.trans('api.common.not_married', [ 'attribute' => '' ], 'ar'),
                                    "icon"=> $commonIcon->where('name','currently_married')->first()->icon??''
                                ];
                                */
                                // $currently_married_obj=(isset($member->currently_married) && $member->currently_married)?$yes_no_obj[$member->currently_married]:[];
                                // $currently_married_obj['icon']=$commonIcon->where('name','currently_married')->first()->icon??'';
                                /*
                                // @ smoking obj
                                $smoking_obj=(isset($member->smoking) && $member->smoking)?$yes_no_obj[$member->smoking]:[];
                                //Non-smoker
                                $smoking_tag_en = ''; $smoking_tag_ar = '';
                                if($member->smoking == 'yes') {
                                    $smoking_tag_en = '🚬 '.trans('api.common.smoke', [ 'attribute' => '' ], 'en');
                                    $smoking_tag_ar = '🚬 '.trans('api.common.smoke', [ 'attribute' => '' ], 'ar');
                                } else if($member->smoking == 'sometimes') {
                                    $smoking_tag_en = '🚬 '.trans('api.common.sometimes_smoke', [ 'attribute' => '' ], 'en');
                                    $smoking_tag_ar = '🚬 '.trans('api.common.sometimes_smoke', [ 'attribute' => '' ], 'ar');
                                } else {
                                    $smoking_tag_en = '🚭 '.trans('api.common.no_smoke', [ 'attribute' => '' ], 'en');
                                    $smoking_tag_ar = '🚭 '.trans('api.common.no_smoke', [ 'attribute' => '' ], 'ar');
                                }
                                $smoking_obj['tag_name_en'] =  $smoking_tag_en;
                                $smoking_obj['tag_name_ar'] =  $smoking_tag_ar;
                                $smoking_obj['icon']=$commonIcon->where('name','smoking')->first()->icon;
                                */
        
                                /*
                                $care_tribalism_obj=(isset($member->do_you_care_about_tribalism) && 
                                $member->do_you_care_about_tribalism)?$yes_no_obj[$member->do_you_care_about_tribalism]:[];
        
        
                                $care_tribalism_obj_en = ''; $care_tribalism_obj_ar = '';
                                if($member->do_you_care_about_tribalism == 'yes') {
                                    $care_tribalism_obj_en = '👤 Cares about tribalism';
                                    $care_tribalism_obj_ar = '👤 Cares about tribalism';
                                } else {
                                    $care_tribalism_obj_en = '👤 Not cares about tribalism';
                                    $care_tribalism_obj_ar = '👤 Not cares about tribalism';
                                }
        
                                $care_tribalism_obj['tag_name_en'] =  $care_tribalism_obj_en;
                                $care_tribalism_obj['tag_name_ar'] =   $care_tribalism_obj_ar;
        
                                $care_tribalism_obj['icon']=$commonIcon->where('name','is_tribal')->first()->icon??'';
                                */
                                /*
                                // @is tribal
                                $is_tribal_obj=(isset($user->is_your_family_tribal) && $user->is_your_family_tribal)
                                                ?$yes_no_obj[$user->is_your_family_tribal]:[];
        
        
                                $is_tribal_obj_en = ''; $is_tribal_obj_ar = '';
                                if($user->is_your_family_tribal == 'yes') {
                                    $is_tribal_obj_en = '👤 Tribal Person';
                                    $is_tribal_obj_ar = '👤 Tribal Person';
                                } else {
                                    $is_tribal_obj_en = '👤 Non Tribal Person';
                                    $is_tribal_obj_ar = '👤 Non Tribal Person';
                                }
        
                                $is_tribal_obj['tag_name_en'] = $is_tribal_obj_en;
                                $is_tribal_obj['tag_name_ar'] = $is_tribal_obj_ar;
                                $is_tribal_obj['icon']=$commonIcon->where('name','is_tribal')->first()->icon??'';
                                */
                                
                            /*
                                $temp_about_me = [
                                    'height'=>$height_obj,
                                    'skin_color' => $skin_color,
                                    'currently_married' => $currently_married_obj,
                                    'children' => $children,
                                ];
                                $temp_education_and_career=[
                                    'education'=>$education,
                                    'career'=>$career
                                ];
                                $temp_social=[
                                    'sect'=>$sect,
                                    'smoking'=>$smoking_obj,
                                    // 'smoking'=>["value"=>($smoking=='yes')?__('admin_dashboard.common.yes'):__('admin_dashboard.common.no')],
                                    'Tribal_Person'=>$is_tribal_obj,
                                    'tribal'=>$tribal,
                                    'Cares_About_Tribalism'=>$care_tribalism_obj,
                                    'Flexible_About_Hijab'=>$hijab,
                                ];
        
                                $member->about_me_arr=array_merge($about_me_arr,$temp_about_me);
                                $member->education_and_career_arr=$temp_education_and_career;
                                $member->social_arr=$temp_social;
                                */
                                $member->profile_images = Helper::get_profile_individual_or_family_images($member);
                                $member->user_likes_hide_blocked= Helper::user_likes_hide_blocked($member->id,'member');
                                
                            }
                        } 
                        
                        
                    }


                    $user->connection_detail = UserTrait::_check_connection_status($user->id, Auth::user()->id);
                    $user->is_requested = UserTrait::_check_is_requested($user->id, Auth::user()->id);
                    if ($user->account_type_id == 1) {
                        $user_type = 'family';
                        $user->user_likes_hide_blocked = Helper::user_likes_hide_blocked($user->id, $user_type);
                    }
                    if (1) {
                        $user->user_likes_hide_blocked = Helper::user_likes_hide_blocked_detail($user->id);
                    }

                }
            }


            //@ take random
            //dd(Session::get('shown_user_ids'));
            //dd($request->page);

            if (Session::has('shown_user_ids') && $request->page != 1) {
                $already_shown_users = Session::get('shown_user_ids');
                //dd($already_shown_users[$user_id]);
                if (isset($already_shown_users[$user_id]) && isset($shown_user_ids[$user_id])) {
                    //dd($shown_user_ids);
                    $shown_user_ids[$user_id] = array_merge($already_shown_users[$user_id], $shown_user_ids[$user_id]);
                }
                Session::put('shown_user_ids', $shown_user_ids);
            } else if ($request->page == 1) { //page == 1
                Session::put('shown_user_ids', $shown_user_ids);
                //dd(Session::get('shown_user_ids'));
            }



            //$user_id = Auth::user()->id;
            //$user = User::find($user_id);


            //$verfied_data = Helper::user_all_detail($user);
            // $list = json_decode(json_encode($list), true);
            // foreach($list['data'] as $key => $users)
            // {
            //     //dd($users['members']);
            //     if(!empty($users['members']))
            //     {
            //         foreach($users['members'] as $mkey => $mems)
            //         {
            //             if($mems['is_hide'] == 1)
            //             {
            //                 unset($users['members'][$mkey]);
            //             }
            //         }
            //     }
            //     $list['data'][$key]['members'] = array_values($users['members']);
            // }

            $response = [
                'status' => true,
                'message' => $message,
                'list_count' => $list_count,
                'shown_user_ids' => Session::get('shown_user_ids'),
                'search_keyword' => $request->search_keyword,
                'data' => $new_list,
                //'user_detail' => $verfied_data
            ];
        } else {

            $shown_user_ids[$user_id] = [];
            $message_data = Helper::getMessageByCode('NOT012');
            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }
            $message = $message_text;

            $response = [
                'status' => true,
                'list_count' => $list_count,
                'shown_user_ids' => $shown_user_ids,
                'search_keyword' => $request->search_keyword,
                'message' => $message,
                'data' => []
            ];
        }

        return $response;
    }

    
    public function get_other_avaliable_users_optimized(Request $request, $account_type = null, $sent_connection_request = null)
    {
        //dd(Auth::user()->id);
        //dd($request->all());
        $message = '';
        if ($request->has('recepintUser')) {
            $username = Helper::getUserName($request->recepintUser);

            $message_data = Helper::getMessageByCode('NOT011');
            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }
            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }
        if ($request->has('is_liked')) {

            $message = $request->is_liked ? trans('api.common.successfully_liked') : trans('api.common.successfully_disliked');
            if ($request->is_liked) {
                $message_data = Helper::getMessageByCode('NOT09');
            } else {
                $message_data = Helper::getMessageByCode('NOT010');
            }

            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }

            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }

        if ($request->has('is_reported')) {

            if ($request->is_reported) {
                $message_data = Helper::getMessageByCode('NOT018');
            }
            if ($request->is_blocked == 0) {
                $message_data = Helper::getMessageByCode('NOT022');
            }

            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }

            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }

        if ($request->has('is_blocked')) {


            if (1) {
                $message_data = Helper::getMessageByCode('NOT022');
            }

            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }

            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }


        // GENERAL DATA
        $commonIcon = CommonIcon::all();

        //dd($request->filter_option);
        //return User::with('education_detail')->get();

        //\DB::enableQueryLog(); // Enable query log
        $list = User::query()->select('users.*')->with('account_type');
        //->with('profile_images')

        $list = $list->with('members');
        
        // $list = $list->with(['products' => function ($q) {
        //     $q->where('types.id', $SpecificID);
        // }]);

        $list = $list
            ->with('profile_images_list')
            ->with('members.profile_images_list')
            //->with('members.skin_detail')
            //->with('members.work_detail')
            //->with('members.education_detail')
            //->with('members.children_detail')
            //->with('members.sect_detail')
            //->with('members.hijab_detail')
        
            //->with('family_origin_detail')
            //->with('nationality_detail')
            //->with('nationality_current_detail')
            ->with('live_in_city_detail')
            //->with('tribe_detail')
            ->has('user_has_active_subscription');
            //->with('personality_dimension')
            

        // if(Auth::user()->status == 'yellow') {
        //     $list->leftJoin('user_yellow_connections','user_yellow_connections.request_id','users.id')
        //           ->where('user_yellow_connections.user_id',Auth::user()->id);
        // } 


        /*
        DB::raw("(SELECT round(AVG( ratings ), 2) FROM user_ratings WHERE user_ratings.user_id = orders.user_id) as ratings")
        */
        if (Auth::user()->status == 'red') {
            $list->leftJoin('user_red_connections', 'user_red_connections.request_id', 'users.id')
                ->where('user_red_connections.user_id', Auth::user()->id);
        }

        if ($sent_connection_request) {
            $user_id = Auth::user()->id;
            $connected_users_ids = Helper::get_all_connected_users_array($user_id);
            //dd($connected_users_ids);
            $list = $list->whereIn('users.id', $connected_users_ids);
        }


        

        //$list = $list->where('user_families.is_hide',0);

        //dd($request->search_keyword);
        $list = Helper::custom_user_filter($list, $account_type, $request->search_keyword, $request->filter_option);

        if (empty($request->search_keyword) && !isset($request->filter_apply)) {
            if (Session::has('shown_user_ids') && $request->page != 1) {
                $user_id = Auth::user()->id;
                $user_ids_not_to_display = Session::get('shown_user_ids');
                //dd($user_ids_not_to_display[$user_id]);
                if (isset($user_ids_not_to_display[$user_id])) {
                    $list = $list->whereNotIn('users.id', $user_ids_not_to_display[$user_id]);
                }
            } else {
                $user_id = Auth::user()->id;
                $user_ids_not_to_display[$user_id] = [];
            }
        } else {
            if (Session::has('shown_user_ids') && $request->page != 1) {
                $user_id = Auth::user()->id;
                $user_ids_not_to_display = Session::get('shown_user_ids');
                //dd($user_ids_not_to_display[$user_id]);
                if (isset($user_ids_not_to_display[$user_id])) {
                    $list = $list->whereNotIn('users.id', $user_ids_not_to_display[$user_id]);
                }
            } else {
                $user_id = Auth::user()->id;
                $user_ids_not_to_display[$user_id] = [];
            }
        }

        $list = $list->whereHas('members', function ($list) {
            $list->where('is_hide', 0);
        });

        $list = $list->where('users.is_completed', 1)
            ->where('users.mobile', '!=', Auth::user()->mobile)
            ->where('users.account_blocked', '!=', 1)
            ->where('users.id', '!=', 1);

        $user_id = Auth::user()->id;

        if ($request->page == 1) {
            $list_count = $list->count();
            $total_user_count = [];
            $total_user_count[$user_id] = $list_count;
            Session::put('total_users', $total_user_count);
        } else {
            $list_count = Session::get('total_users');
        }



        if (empty($request->search_keyword) && !isset($request->filter_apply)) {

            $list = $list->inRandomOrder();
            //$list = $list->orderBy('users.id','desc');
        } else {
            $list = $list->inRandomOrder(); //$list->orderBy('users.id', 'desc');
        }



        if ($request->page != 1) {
            $user_ids_not_to_display[$user_id] = Session::has('shown_user_ids') ? Session::get('shown_user_ids') : [];
        }




        if ($request->page == 1 && (isset($user_ids_not_to_display[$user_id]) && $list_count > count($user_ids_not_to_display[$user_id]))) {
            $shown_user_ids = [];
            // $query = str_replace(array('?'), array('\'%s\''), $list->toSql());
            // $query = vsprintf($query, $list->getBindings());
            // dump($query);
            // die;
            $list = $list->take(10)->get();
        } else if ((isset($user_ids_not_to_display[$user_id]) && $list_count > count($user_ids_not_to_display[$user_id]))) {
            // $query = str_replace(array('?'), array('\'%s\''), $list->toSql());
            // $query = vsprintf($query, $list->getBindings());
            // dump($query);
            // die;
            $list = $list->take(10)->get();
        } else {

            // $query = str_replace(array('?'), array('\'%s\''), $list->toSql());
            // $query = vsprintf($query, $list->getBindings());
            // dump($query);
            // die;
            if (isset($user_ids_not_to_display[$user_id]) && count($user_ids_not_to_display[$user_id]) < 10) {
                $list = $list->take(10)->get();
            } else {
                $list = $list->take(10)->get();
            }
        }



        //
        //dd(\DB::getQueryLog()); // Show results of log

        //dd($list);
        //dd($user_ids_not_to_display[$user_id]);

        // return $list;
        $shown_user_ids = [];
        $new_list['data'] = [];
        //$new_list['data2'] = [];
        if (count($list) > 0) {

            //dd($shown_user_ids);
            foreach ($list as $user) {

                $not_blocked = Helper::get_other_blocked_users(Auth::user()->id, $user->id);
                if($not_blocked) {
                    // Undefined error occured so I have written isset condition
                    if ($request->page != 1 && (isset($user_ids_not_to_display[$user_id]) && !in_array($user->id, $user_ids_not_to_display[$user_id]))) {

                        $shown_user_ids[$user_id][] = $user->id;

                        //$member_detaail = Helper::user_all_detail($user);
                        //$user->members = $member_detaail;
                        $user->family_members_male_count = $user->members()->where('is_hide', 0)->where('gender', 'male')->count();
                        $user->family_members_female_count = $user->members()->where('is_hide', 0)->where('gender', 'female')->count();
                        $new_list['data'][] = $user;
                    }
                    if ($request->page == 1) {
                        $shown_user_ids[$user_id][] = $user->id;

                        //$member_detaail = Helper::user_all_detail($user);
                        //$user->members = $member_detaail;
                        $user->family_members_male_count = $user->members()->where('is_hide', 0)->where('gender', 'male')->count();
                        $user->family_members_female_count = $user->members()->where('is_hide', 0)->where('gender', 'female')->count();
                        $new_list['data'][] = $user;
                    }


                    if ($user->individual_detail) {
                        $temp_about_me = [];
                        $temp_education_and_carrer=[];
                        $temp_social=[];
                        if($user->account_type_id == 2) { // family
                            foreach ($user->individual_detail as $member) {
                            
                                /*
                                $height_obj = isset($member->height_detail) ? $member->height_detail : '';
                                if(!empty($height_obj)) {
                                    $height_obj->icon = $commonIcon->where('name','height')->first()->icon??'';
                                    $height_obj->tag_name_en = isset($member->height_detail) ? '📏 '.$member->height_detail->height_min . ' - '.$member->height_detail->height_max . ' cm'  : '';
                                    $height_obj->tag_name_ar = isset($member->height_detail) ? '📏 '.$member->height_detail->height_min . ' - '.$member->height_detail->height_max . ' cm'  : ''; 
                                }
                                */
                                
                                /*
                                $skin_color=isset($member->skin_detail)?$member->skin_detail:'';
                                if(!empty($skin_color)) {
                                    $skin_color->tag_name_en =  isset($member->skin_detail) ? '👨 '.trans('api.common.skin', [ 'attribute' => $member->skin_detail->name_en ], 'en')  : '';
                                    $skin_color->tag_name_ar =  isset($member->skin_detail->name_ar) ? '👨 '.trans('api.common.skin', [ 'attribute' => $member->skin_detail->name_ar ], 'ar')  : '';
                                }
                                */
        
                                /*
                                $children=isset($member->children_detail)?$member->children_detail:'';
                                //Has 1 child
                                if(!empty($children)) {
                                    $children->tag_name_en =  isset($member->children_detail) ? '👶 '.$member->children_detail->children_number_en  : '';
                                    $children->tag_name_ar =  isset($member->children_detail) ? '👶 '.$member->children_detail->children_number_ar  : '';
                                }
                                */
                                // @ education and career Undergraduate studies
                                /*
                                $education=isset($member->education_detail)?$member->education_detail:'';
                                if(!empty($education)) {
                                    $education->tag_name_en =  isset($member->education_detail) ? '🎓 '.$member->education_detail->name_en  : '';
                                    $education->tag_name_ar =  isset($member->education_detail) ? '🎓 '.$member->education_detail->name_ar  : '';
                                }
                                */
                                /*
                                // Freelancer
                                $career=isset($member->work_detail)?$member->work_detail:'';
                                if(!empty($career)) {
                                    $career->tag_name_en =  isset($member->work_detail) ? '💼 '.$member->work_detail->name_en  : '';
                                    $career->tag_name_ar =  isset($member->work_detail) ? '💼 '.$member->work_detail->name_ar  : '';
                                }
                                */
                                /*
                                // @ social
                                $sect=isset($member->sect_detail)?$member->sect_detail:'';
                                
                                if(!empty($sect)) {
                                    $sect->tag_name_en =  isset($member->sect_detail) ? '🌑 '.$member->sect_detail->name_en  : '';
                                    $sect->tag_name_ar =  isset($member->sect_detail) ? '🌑 '.$member->sect_detail->name_ar  : '';
                                }
                                */
                                /*
                                $tribal=isset($user->tribe_detail)?$user->tribe_detail:'';
        
                                if(!empty($tribal)) {
                                    $tribal->tag_name_en=isset($user->tribe_detail->name_en)? '👥 '.trans('api.common.tribe', [ 'attribute' => $user->tribe_detail->name_en ], 'en') :'';
                                    $tribal->tag_name_ar=isset($user->tribe_detail->name_ar)? '👥 '.trans('api.common.tribe', [ 'attribute' => $user->tribe_detail->name_ar ], 'ar') :'';
                                }
                                */
                                /*
                                $hijab=isset($member->hijab_detail)?$member->hijab_detail:'';
                                if(!empty($hijab)) {
                                
                                    $hijab->tag_name_en =  isset($member->hijab_detail) ? '👩🏻 '.$member->hijab_detail->name_en  : '';
                                    $hijab->tag_name_ar =  isset($member->hijab_detail) ? '👩🏻 '.$member->hijab_detail->name_ar  : '';
                                    
                                }
                                */
                                /*
                                $yes_no_obj=[
                                    "yes"=>['name_en'=>'YES','name_ar'=>'نعم'],
                                    "no"=>['name_en'=>'NO','name_ar'=>'رقم'],
                                    "sometimes" => ['name_en'=>'Sometimes','name_ar'=>'رقم']
                                ];
                                */
                                /*
                                // current marriedCurrently married
                                $currently_married_obj=[
                                    "married"=> true,
                                    "value"=> ($member->currently_married=='yes')?'currently married':'not married',
                                    "tag_name_en" => ($member->currently_married=='yes') ? '💍 '.trans('api.common.currently_married', [ 'attribute' => '' ], 'en') : '💍 '.trans('api.common.not_married', [ 'attribute' => '' ], 'en'),
                                    "tag_name_ar" => ($member->currently_married=='yes') ? '💍 '.trans('api.common.currently_married', [ 'attribute' => '' ], 'ar') : '💍 '.trans('api.common.not_married', [ 'attribute' => '' ], 'ar'),
                                    "icon"=> $commonIcon->where('name','currently_married')->first()->icon??''
                                ];
                                */
                                // $currently_married_obj=(isset($member->currently_married) && $member->currently_married)?$yes_no_obj[$member->currently_married]:[];
                                // $currently_married_obj['icon']=$commonIcon->where('name','currently_married')->first()->icon??'';
                                /*
                                // @ smoking obj
                                $smoking_obj=(isset($member->smoking) && $member->smoking)?$yes_no_obj[$member->smoking]:[];
                                //Non-smoker
                                $smoking_tag_en = ''; $smoking_tag_ar = '';
                                if($member->smoking == 'yes') {
                                    $smoking_tag_en = '🚬 '.trans('api.common.smoke', [ 'attribute' => '' ], 'en');
                                    $smoking_tag_ar = '🚬 '.trans('api.common.smoke', [ 'attribute' => '' ], 'ar');
                                } else if($member->smoking == 'sometimes') {
                                    $smoking_tag_en = '🚬 '.trans('api.common.sometimes_smoke', [ 'attribute' => '' ], 'en');
                                    $smoking_tag_ar = '🚬 '.trans('api.common.sometimes_smoke', [ 'attribute' => '' ], 'ar');
                                } else {
                                    $smoking_tag_en = '🚭 '.trans('api.common.no_smoke', [ 'attribute' => '' ], 'en');
                                    $smoking_tag_ar = '🚭 '.trans('api.common.no_smoke', [ 'attribute' => '' ], 'ar');
                                }
                                $smoking_obj['tag_name_en'] =  $smoking_tag_en;
                                $smoking_obj['tag_name_ar'] =  $smoking_tag_ar;
                                $smoking_obj['icon']=$commonIcon->where('name','smoking')->first()->icon;
                                */
        
                                /*
                                $care_tribalism_obj=(isset($member->do_you_care_about_tribalism) && 
                                $member->do_you_care_about_tribalism)?$yes_no_obj[$member->do_you_care_about_tribalism]:[];
        
        
                                $care_tribalism_obj_en = ''; $care_tribalism_obj_ar = '';
                                if($member->do_you_care_about_tribalism == 'yes') {
                                    $care_tribalism_obj_en = '👤 Cares about tribalism';
                                    $care_tribalism_obj_ar = '👤 Cares about tribalism';
                                } else {
                                    $care_tribalism_obj_en = '👤 Not cares about tribalism';
                                    $care_tribalism_obj_ar = '👤 Not cares about tribalism';
                                }
        
                                $care_tribalism_obj['tag_name_en'] =  $care_tribalism_obj_en;
                                $care_tribalism_obj['tag_name_ar'] =   $care_tribalism_obj_ar;
        
                                $care_tribalism_obj['icon']=$commonIcon->where('name','is_tribal')->first()->icon??'';
                                */
                                /*
                                // @is tribal
                                $is_tribal_obj=(isset($user->is_your_family_tribal) && $user->is_your_family_tribal)
                                                ?$yes_no_obj[$user->is_your_family_tribal]:[];
        
        
                                $is_tribal_obj_en = ''; $is_tribal_obj_ar = '';
                                if($user->is_your_family_tribal == 'yes') {
                                    $is_tribal_obj_en = '👤 Tribal Person';
                                    $is_tribal_obj_ar = '👤 Tribal Person';
                                } else {
                                    $is_tribal_obj_en = '👤 Non Tribal Person';
                                    $is_tribal_obj_ar = '👤 Non Tribal Person';
                                }
        
                                $is_tribal_obj['tag_name_en'] = $is_tribal_obj_en;
                                $is_tribal_obj['tag_name_ar'] = $is_tribal_obj_ar;
                                $is_tribal_obj['icon']=$commonIcon->where('name','is_tribal')->first()->icon??'';
                                */
                                
                            /*
                                $temp_about_me = [
                                    'height'=>$height_obj,
                                    'skin_color' => $skin_color,
                                    'currently_married' => $currently_married_obj,
                                    'children' => $children,
                                ];
                                $temp_education_and_career=[
                                    'education'=>$education,
                                    'career'=>$career
                                ];
                                $temp_social=[
                                    'sect'=>$sect,
                                    'smoking'=>$smoking_obj,
                                    // 'smoking'=>["value"=>($smoking=='yes')?__('admin_dashboard.common.yes'):__('admin_dashboard.common.no')],
                                    'Tribal_Person'=>$is_tribal_obj,
                                    'tribal'=>$tribal,
                                    'Cares_About_Tribalism'=>$care_tribalism_obj,
                                    'Flexible_About_Hijab'=>$hijab,
                                ];
        
                                $member->about_me_arr=array_merge($about_me_arr,$temp_about_me);
                                $member->education_and_career_arr=$temp_education_and_career;
                                $member->social_arr=$temp_social;
                                */
                                $member->profile_images = Helper::get_profile_individual_or_family_images($member);
                                $member->user_likes_hide_blocked= Helper::user_likes_hide_blocked($member->id,'member');
                                
                            }
                        } 
                        
                        
                    }


                    $user->connection_detail = UserTrait::_check_connection_status($user->id, Auth::user()->id);
                    $user->is_requested = UserTrait::_check_is_requested($user->id, Auth::user()->id);
                    if ($user->account_type_id == 1) {
                        $user_type = 'family';
                        $user->user_likes_hide_blocked = Helper::user_likes_hide_blocked($user->id, $user_type);
                    }
                    if (1) {
                        $user->user_likes_hide_blocked = Helper::user_likes_hide_blocked_detail($user->id);
                    }

                }

                
            }


            //@ take random
            //dd(Session::get('shown_user_ids'));
            //dd($request->page);

            if (Session::has('shown_user_ids') && $request->page != 1) {
                $already_shown_users = Session::get('shown_user_ids');
                //dd($already_shown_users[$user_id]);
                if (isset($already_shown_users[$user_id]) && isset($shown_user_ids[$user_id])) {
                    //dd($shown_user_ids);
                    $shown_user_ids[$user_id] = array_merge($already_shown_users[$user_id], $shown_user_ids[$user_id]);
                }
                Session::put('shown_user_ids', $shown_user_ids);
            } else if ($request->page == 1) { //page == 1
                Session::put('shown_user_ids', $shown_user_ids);
                //dd(Session::get('shown_user_ids'));
            }



            //$user_id = Auth::user()->id;
            //$user = User::find($user_id);


            //$verfied_data = Helper::user_all_detail($user);
            // $list = json_decode(json_encode($list), true);
            // foreach($list['data'] as $key => $users)
            // {
            //     //dd($users['members']);
            //     if(!empty($users['members']))
            //     {
            //         foreach($users['members'] as $mkey => $mems)
            //         {
            //             if($mems['is_hide'] == 1)
            //             {
            //                 unset($users['members'][$mkey]);
            //             }
            //         }
            //     }
            //     $list['data'][$key]['members'] = array_values($users['members']);
            // }

            $response = [
                'status' => true,
                'message' => $message,
                'list_count' => $list_count,
                'shown_user_ids' => Session::get('shown_user_ids'),
                'search_keyword' => $request->search_keyword,
                'data' => $new_list,
                //'user_detail' => $verfied_data
            ];
        } else {

            $shown_user_ids[$user_id] = [];
            $message_data = Helper::getMessageByCode('NOT012');
            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }
            $message = $message_text;

            $response = [
                'status' => true,
                'list_count' => $list_count,
                'shown_user_ids' => $shown_user_ids,
                'search_keyword' => $request->search_keyword,
                'message' => $message,
                'data' => []
            ];
        }

        return $response;
    }

    public function member_details(Request $request)
    {
        $user_id = $request->user_id;

        $data = UserFamily::with('profile_images_list')
            ->with('skin_detail')
            ->with('personality_dimension')
            ->with('work_detail')
            ->with('education_detail')
            //->with('getNationalityDetailAttribute')
            ->where('user_families.id', '=', $user_id)
            ->first();

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('status' => true,
            'message' => '',
            'data' => $data)
        ];
        Helper::save_api_logs($logdata);

        return $response = [
            'status' => true,
            'message' => '',
            'data' => $data
        ];
    }

    public function userProfileImageAdd(Request $request)
    {
        //@ update profile image
        $user = $request->user();
        $path = '';
        if (isset($request->family_profile_img)) {
            if ($user->account_type_id == 1) {
                if ($request->has('family_profile_img')) {

                    // $request->validate([
                    //     $request->family_profile_img => 'required|mimes:png,jpeg|max:25120'
                    // ]);
                    if ($request->family_profile_img) {

                        //$path = $this->_base64fileUpload($request->family_profile_img, '/profile_img');
                        $path = $this->_normalFileUpload($request->family_profile_img, 'profile_img');
                        $total_pic_count = UserProfileImage::where('user_id', $user->id)
                            ->where('is_default', 1)
                            ->count();

                        if ($total_pic_count == 1) {
                            $user_profile_img = UserProfileImage::where('user_id', $user->id)
                                ->where('is_default', 1)
                                ->update([
                                    'profile_img' => $path,
                                ]);
                            $file_exits = UserProfileImage::where('user_id', $user->id)
                                ->where('is_default', 1)->first();
                            if($file_exits) {
                                $status = $this->_deleteFile($file_exits->profile_img);
                                //dd( $status );
                            }
                            
                        } else {

                            // return $path;
                            $user_profile_img = UserProfileImage::create([
                                'user_id' => $user->id,
                                'profile_img' => $path,
                                'is_default' => 1
                            ]);
                        }
                    }
                } else {
                    $path = 'profile_img/dummy_family_profile.png';
                    $user_profile_img = UserProfileImage::create([
                        'user_id' => $user->id,
                        'profile_img' => $path,
                        'is_default' => 1
                    ]);
                }
            }
        }
        if (isset($request->individual_profile_img)) {
            if ($user->account_type_id == 2) {
                if ($request->has('individual_profile_img')) { // individaul_profile_img
                    $request->validate([
                        'individual_profile_img' => 'required|mimes:png,jpeg|max:25120'
                    ]);
                    // $request->validate([
                    //     'individual_profile_img' => ['required',new Base64FileType(['mimes:png'])]
                    // ]);
                    if ($request->individual_profile_img) {

                        //$path = $this->_base64fileUpload($request->individual_profile_img, '/profile_img');
                        $path = $this->_normalFileUpload($request->individual_profile_img, 'profile_img');
                        $total_pic_count = UserProfileImage::where('user_id', $user->id)
                            ->where('is_default', 1)
                            ->count();

                        if ($total_pic_count) {

                            $user_profile_data = UserProfileImage::where('user_id', $user->id)->where('is_default', 1)->first();
                            if ($user_profile_data) {

                                $user_profile_img = UserProfileImage::where('id', $user_profile_data->id)
                                    ->update([
                                        'profile_img' => $path,
                                        'is_default' => 1
                                    ]);
                                    //dd($user_profile_data->profile_img);
                                $status = $this->_deleteFile($user_profile_data->profile_img);
                                //dd( $status );
                            }
                        } else {

                            // return $path;
                            $user_profile_img = UserProfileImage::create([
                                'user_id' => $user->id,
                                'profile_img' => $path,
                                'is_default' => 1
                            ]);
                        }
                    }
                } else {
                    //check gender
                    $user_family = UserFamily::where('user_default_id', $user->id)->first();
                    //dd($user_family);
                    $gender = '';
                    if (isset($user_family->gender)) {
                        $gender = $user_family->gender . '_';
                    }
                    $path = 'profile_img/dummy_'. $gender .'profile.png';
                    $user_profile_img = UserProfileImage::create([
                        'user_id' => $user->id,
                        'profile_img' => $path,
                        'is_default' => 1
                    ]);
                }
            }
        }


        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('success' => true,
            'user_detail' => $user,
            'profile_img' => $path)
        ];
        Helper::save_api_logs($logdata);

        return [
            'success' => true,
            'user_detail' => $user,
            'profile_img' => $path
        ];
    }

    public function userProfileImageUpdate(Request $request, $member_id = null)
    {
        //@ update profile image
        $user_id = Auth::user()->id;
        $path = '';
        if ($request->img) {

            $request->validate([
                'img' => 'required|mimes:png,jpeg|max:25120'
            ]);
            // return $path;
            if (empty($member_id)) {
                $path = $this->_normalFileUpload($request->img, 'profile_img');
                if (!empty($request->profile_img_id)) {
                    $user_profile_img = UserProfileImage::where('id', $request->profile_img_id)->where('user_id', $user_id)->update([
                        'profile_img' => $path
                    ]);
                } else {
                    $total_pic_count = UserProfileImage::where('user_id', $user_id)->count();
                    if ($total_pic_count < 8) {
                        // UserProfileImage::where('user_id', $user_id)->update([
                        //     'is_default' => 0
                        // ]);
                        $all_old_files = UserProfileImage::where('user_id', $user_id)->where('is_default', 1)->get();
                        if(isset($all_old_files)) {
                            foreach($all_old_files as $file) {
                                // delete a existing file
                                $this->_deleteFile($file->profile_img);
                                $exit_row = UserProfileImage::where('id', $file->id)->delete();
                            }
                        }
                        

                        $user_profile_img = UserProfileImage::insert([
                            'profile_img' => $path,
                            'user_id' => $user_id,
                            'is_default' => 1,
                        ]);
                    } else {
                        $user_profile = UserProfileImage::where('user_id', $user_id)->first();
                        if ($user_profile) {
                            // UserProfileImage::where('user_id', $user_id)->update([
                            //     'is_default' => 0
                            // ]);
                            UserProfileImage::where('user_id', $user_id)->where('is_default', 1)->delete();
                            $user_profile_img = UserProfileImage::where('id', $user_profile->id)->update([
                                'profile_img' => $path,
                                'user_id' => $user_id,
                                'is_default' => 1,
                            ]);
                        }
                    }
                }
            }
            /// in case of member
            if (!empty($member_id)) {
                $path = $this->_normalFileUpload($request->img, 'family_profile_img');
                if (!empty($request->profile_img_id)) {
                    $user_profile_img = UserFamilyProfileImage::where('id', $request->profile_img_id)->where('user_family_id', $member_id)->update([
                        'profile_img' => $path
                    ]);
                } else {

                    $user_profile = UserFamilyProfileImage::where('user_family_id', $member_id)->orderBy('id', 'desc')->first();
                    if ($user_profile) {

                        // $user_profile_img = UserFamilyProfileImage::where('user_family_id', $user_profile->user_family_id)->update([
                        //     'is_default' => 0,
                        // ]);
                        $all_old_files = UserFamilyProfileImage::where('user_family_id', $user_profile->user_family_id)->where('is_default', 1)->get();
                        if(isset($all_old_files)) {
                            foreach($all_old_files as $file) {
                                // delete a existing file
                                $this->_deleteFile($file->profile_img);
                                $exit_row = UserFamilyProfileImage::where('id', $file->id)->delete();
                            }
                        }
                        $user_profile_img = UserFamilyProfileImage::where('id', $user_profile->id)->update([
                            'profile_img' => $path,
                            'user_family_id' => $member_id,
                            'is_default' => 1,
                        ]);
                    } else {

                        $user_profile_img = UserFamilyProfileImage::insert([
                            'profile_img' => $path,
                            'user_family_id' => $member_id,
                            'is_default' => 1,
                        ]);
                    }
                }
            }
        }

        //$user = User::find($user_id);

        //$verfied_data = Helper::user_all_detail($user);
        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('success' => true,
            'user_id' => $user_id,
            'profile_img' => $path)
        ];
        Helper::save_api_logs($logdata);

        $response = [
            'success' => true,
            'user_id' => $user_id,
            'profile_img' => $path,
        ];

        //$response['data']['user'] = $verfied_data;

        return $response;
    }

    public function userGalleryImageAdd(Request $request, $member_id = null)
    {
        $user = $request->user();
        //dd($user);
        if (empty($member_id)) {
            $user_family = UserFamily::where('user_default_id', $user->id)->first();
            $member_id = $user_family->id;
        } else {
            $member_id = $member_id;
        }

        //dd($user->account_type_id);

        $profile_pic = [];

        if ($user->account_type_id == 1) {

            $profile_pic = [];
            $total_pic_count = UserFamilyProfileImage::where('user_family_id', $member_id)
                ->where('is_default', 0)
                ->count();
            //dd($user->id);
            if ($total_pic_count < 9) {

                if (isset($request->img)) {
                    $request->validate([
                        'img' => 'required|mimes:png,jpeg|max:25120'
                    ]);
                    $rem_pic_can_upload = 1;
                    
                    if (!empty($request->img) && $rem_pic_can_upload < 9) {

                        
                        //dd($image);
                        //$path = $this->_base64fileUpload($image, '/family_profile_img');
                        $path = $this->_normalFileUpload($request->img, 'family_profile_img');
                        //dd($path);
                        $user_profile_img = UserFamilyProfileImage::create([
                            'user_family_id' => $member_id,
                            'profile_img' => $path,
                            'is_default' => 0,
                        ]);
                        $profile_pic[] = $path;
                        $rem_pic_can_upload++;
                    }
                    
                }
            }
        }
        if ($user->account_type_id == 2) {
            $total_pic_count = UserProfileImage::where('user_id', $user->id)
                ->where('is_default', 0)
                ->count();
            //dd($user->id);
            if ($total_pic_count < 9) {
                $rem_pic_can_upload = 1;
                if ($rem_pic_can_upload) {
                    if (isset($request->img)) {
                        //dd('ff');
                        $request->validate([
                            'img' => 'required|mimes:png,jpeg|max:25120'
                        ]);
                        
                        if (!empty($request->img) && $rem_pic_can_upload < 9) {
                            //$path = $this->_base64fileUpload($image, '/profile_img');
                            $path = $this->_normalFileUpload($request->img, 'profile_img');
                            // return $path;
                            $user_profile_img = UserProfileImage::create([
                                'user_id' => $user->id,
                                'is_default' => 0,
                                'profile_img' => $path
                            ]);
                            $profile_pic[] = $path;
                            $rem_pic_can_upload++;
                        }
                        
                    } else {
                        // $path = '/profile_img/dummy_profile.png';
                        // $user_profile_img = UserProfileImage::create([
                        //     'user_id' => $user->id,
                        //     'profile_img' => $path,
                        //     'is_default' => 0
                        // ]);
                    }
                }
            }
        }

        
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $all_detail = Helper::user_all_detail($user, 1);

        //message come form db
        $message_text = __('api.user_profile_update.success_message');
        $message_data = Helper::getMessageByCode('NOT08');
        $prefered_lag = $user->default_language ? $user->default_language : 'en';
        if ($prefered_lag == 'en') {
            $message_text = $message_data->message_value_en;
        } else {
            $message_text = $message_data->message_value_ar;
        }

        $response = [];
        $response['success'] = true;
        $response['message'] =  $message_text;
        $response['data']['user'] = $all_detail;

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('success' => true,
            'profile_img' => $profile_pic)
        ];
        Helper::save_api_logs($logdata);

        return $response;
    }


    public function userGalleryImageUpdate(Request $request, $image_id = null, $member_id = null)
    {
        $user = $request->user();

        if (!empty($image_id)) { // old image update

            $request->validate([
                'img' => 'required|mimes:png,jpeg|max:25120'
            ]);

            if (empty($member_id) && (isset($user->account_type_id) && $user->account_type_id == 2)) {
                

                $path = $this->_normalFileUpload($request->img, 'profile_img');
                // delete a existing file
                $exit_row = UserProfileImage::where('id', $image_id)->first();
                $this->_deleteFile($exit_row->profile_img);

                $deleted = UserProfileImage::where('is_default', 0)
                    ->where('id', $image_id)
                    ->update(
                    [
                        'profile_img' => $path
                    ]
                );
            } else {
                // $deleted = UserFamilyProfileImage::where('is_default', 0)
                //     ->where('id', $image_id)
                //     ->delete();

                $path = $this->_normalFileUpload($request->img, 'profile_img');
                // return $path;
                // delete a existing file
                $exit_row = UserFamilyProfileImage::where('id', $image_id)->first();
                $this->_deleteFile($exit_row->profile_img);
                $deleted = UserFamilyProfileImage::where('is_default', 0)
                    ->where('id', $image_id)
                    ->update(
                    [
                        'profile_img' => $path
                    ]
                );
            }
        } else { // new image add
            if (empty($member_id) && $user->account_type_id == 2) {

                $request->validate([
                    'img' => 'required|mimes:png,jpeg|max:25120'
                ]);
                $path = $this->_normalFileUpload($request->img, 'profile_img');
                //dd($path);
                // return $path;
                $user_profile_img = UserProfileImage::create([
                    'user_id' => $user->id,
                    'profile_img' => $path
                ]);
            } else {
                $request->validate([
                    'img' => 'required|mimes:png,jpeg|max:25120'
                ]);

                $path = $this->_normalFileUpload($request->img, 'profile_img');
                // return $path;
                $user_profile_img = UserFamilyProfileImage::create([
                    'user_family_id' => $member_id,
                    'profile_img' => $path
                ]);
            }
        }


        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $all_detail = Helper::user_all_detail($user, 1);

        //message come form db
        $message_text = __('api.user_profile_update.success_message');
        $message_data = Helper::getMessageByCode('NOT08');
        $prefered_lag = $user->default_language ? $user->default_language : 'en';
        if ($prefered_lag == 'en') {
            $message_text = $message_data->message_value_en;
        } else {
            $message_text = $message_data->message_value_ar;
        }

        $response = [];
        $response['success'] = true;
        $response['message'] =  $message_text;
        $response['data']['user'] = $all_detail;

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => $response
        ];
        Helper::save_api_logs($logdata);

        return $response;
    }

    public function userGalleryImageDelete(Request $request, $image_id = null, $member_id = null)
    {
        $user = $request->user();
        if (empty($member_id) && $user->account_type_id == 2) {
            $deleted_img = UserProfileImage::where('is_default', 0)
                ->where('id', $image_id)
                ->delete();
        } else {
            $deleted_img = UserFamilyProfileImage::where('is_default', 0)
                ->where('id', $image_id)
                ->delete();
        }






        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $all_detail = Helper::user_all_detail($user, 1);

        //message come form db
        $message_text = __('api.user_profile_update.success_message');
        $message_data = Helper::getMessageByCode('NOT08');
        $prefered_lag = $user->default_language ? $user->default_language : 'en';
        if ($prefered_lag == 'en') {
            $message_text = $message_data->message_value_en;
        } else {
            $message_text = $message_data->message_value_ar;
        }

        $response = [];
        $response['success'] = true;
        $response['message'] =  $message_text;
        $response['data']['user'] = $all_detail;


        $logdata = [
            'request_data' => $request->all(),
            'response_data' => $response
        ];
        Helper::save_api_logs($logdata);

        return $response;
    }


    // @username validate
    function usernameValidate(Request $request)
    {

        $request->validate([
            'username' => ['required', 'starts_with:@', new StrMaxNumber(4), 'unique:users,username'],
            'name' => ['required', 'max:20', new StrMaxNumber(4)],
        ], [
            'username.unique' => __('api.set_profile_info.form_fields.username.unique'),
        ]);

        // return $request;


        $user_dt = User::where('username', $request->username)->first();

        if ($user_dt) {

            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array( 'success' => false,
                'message' => __('api.set_profile_info.form_fields.username.unique'),
                'data' => $request->all())
            ];
            Helper::save_api_logs($logdata);

            return [
                'success' => false,
                'message' => __('api.set_profile_info.form_fields.username.unique'),
                'data' => $request->all(),
            ];
        } else {

            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('success' => true,
                'message' => __('api.set_profile_info.form_fields.username.avaliable'),
                'data' => $request->all())
            ];
            Helper::save_api_logs($logdata);

            return [
                'success' => true,
                'message' => __('api.set_profile_info.form_fields.username.avaliable'),
                'data' => $request->all(),
            ];
        }
    }

    // @email validate
    function emailValidate(Request $request)
    {

        $request->validate([
            'email' => 'required|email|unique:users,email',
        ], [

            'email.required' => __('api.set_profile_info.form_fields.email.required'),
            'email.unique' => __('api.set_profile_info.form_fields.email.unique'),
        ]);

        // return $request;


        $user_dt = User::where('email', $request->email)->first();

        if ($user_dt) {
            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('success' => false,
                'message' => __('api.set_profile_info.form_fields.email.unique'),
                'data' => $request->all())
            ];
            Helper::save_api_logs($logdata);


            return [
                'success' => false,
                'message' => __('api.set_profile_info.form_fields.email.unique'),
                'data' => $request->all(),
            ];
        } else {
            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('success' => true,
                'message' => __('api.set_profile_info.form_fields.email.avaliable'),
                'data' => $request->all())
            ];
            Helper::save_api_logs($logdata);
            
            return [
                'success' => true,
                'message' => __('api.set_profile_info.form_fields.email.avaliable'),
                'data' => $request->all(),
            ];
        }
    }




    public function user_subscription_01_10_22(Request $request)
    {
        $user_id = Auth::user()->id;
        //dd($user_id);
        $subscription_history_list = Transaction::select('transactions.*', 'user_purchase_subscriptions.*', 'transactions.created_at as purchase_date')
            ->leftJoin('user_purchase_subscriptions', 'user_purchase_subscriptions.transaction_id', 'transactions.checkout_id')
            ->leftJoin('user_member_addon', 'user_member_addon.transaction_id', 'transactions.checkout_id')
            ->where('transactions.user_id', $user_id)
            ->orderBy('transactions.created_at', 'desc')
            ->get();

        $active = [];
        $history = [];

        // $vat_detail = DB::table('master_settings')->first();
        // $vat_percentage = $vat_detail->vat_percentage;
        $vat_percentage = 0;
        $package_cost = 0;
        $total_vat_cost = 0;
        $total_member_added = DB::table('user_member_addon')->where('user_id', $user_id)->sum('member_add_on');
        if (!$total_member_added) {
            $total_member_added = 1;
        }

        $active_subscription = UserPurchaseSubscription::with('transaction_detail')
            ->with('subscription_detail')
            ->where('user_id', $user_id)
            ->where('status', 'active')
            ->get();

        if ($active_subscription) {
            $active_key = 0;
            $history_key = 0;
            $vat_no = '';
            foreach ($active_subscription as $key => $subscription) {
                if (strtotime($subscription->expired_date) > strtotime(date('Y-m-d')) && $subscription->status == 'active') {
                    if (isset($subscription->transaction_detail['trackable_data']['vat_detail']) && count($subscription->transaction_detail['trackable_data']['vat_detail']) > 0) {
                        $vat_percentage = $subscription->transaction_detail['trackable_data']['vat_detail']['vat_percentage'];
                        $vat_no = $subscription->transaction_detail['trackable_data']['vat_detail']['vat_no'];
                    }


                    if (isset($subscription->transaction_detail['trackable_data']['product_type']) && count($subscription->transaction_detail['trackable_data']) > 0) {
                        $package_cost = $subscription->transaction_detail['trackable_data']['product_type']['price'];
                    }

                    if ($vat_percentage > 0 && $package_cost > 0) {
                        $total_vat_cost = ($package_cost / 100 * $vat_percentage);
                    }

                    // Active
                    $active[$active_key]['id'] = $subscription->subscription_detail ? $subscription->subscription_detail->id : '';
                    $active[$active_key]['subscription_name'] = $subscription->subscription_detail ? $subscription->subscription_detail->name : '';
                    $active[$active_key]['duration'] = $subscription->subscription_detail ? $subscription->subscription_detail->duration : '';
                    $active[$active_key]['total_member'] = $total_member_added;
                    // $active[ $active_key ]['type_of_acount'] = $subscription->subscription_detail ? $subscription->subscription_detail->account_type->name : '';
                    $active[$active_key]['package_cost'] = $package_cost;
                    $active[$active_key]['vat_no'] = $vat_no;
                    $active[$active_key]['vat_percentage'] = $vat_percentage ? $vat_percentage : '--';
                    $active[$active_key]['vat_cost'] = $total_vat_cost ? $total_vat_cost : '--';
                    $active[$active_key]['total_cost'] = $subscription->transaction_detail ? $subscription->transaction_detail->amount : '';
                    $active[$active_key]['expired_date'] = $subscription->expired_date ? $subscription->expired_date : '';
                    $active_key++;
                }
            }
        }

        if ($subscription_history_list) {
            $history_key = 0;
            $vat_no = 0;
            foreach ($subscription_history_list as $subscription) {
                // History

            }
        }


        $data = [];
        $data['active'] = $active_subscription;
        $data['history'] = $subscription_history_list;
        $user_accounts_count = User::where('mobile', Auth::user()->mobile)->count();
        if ($user_accounts_count == 1) {
            $data['single_account'] = true;
        } else {
            $data['single_account'] = false;
        }

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array( 'status' => true,
            'message' => '',
            'data' => $data)
        ];
        Helper::save_api_logs($logdata);


        return $response = [
            'status' => true,
            'message' => '',
            'data' => $data
        ];
    }


    public function user_subscription(Request $request)
    {
        $user_id = Auth::user()->id;
        //dd($user_id);
        $subscription_history_list = UserPurchaseSubscription::select('*')
            ->with('transaction_detail')
            ->with('subscription_detail')
            ->where('user_purchase_subscriptions.user_id', $user_id)
            ->orderBy('user_purchase_subscriptions.created_at', 'desc')
            ->get();

        $active = [];
        $history = [];

        // $vat_detail = DB::table('master_settings')->first();
        // $vat_percentage = $vat_detail->vat_percentage;
        $vat_percentage = 0;
        $package_cost = 0;
        $total_vat_cost = 0;


        $active_subscription = UserPurchaseSubscription::with('transaction_detail')
            ->with('subscription_detail')
            ->where('payment_type', 'subscription')
            ->where('user_id', $user_id)
            ->where('status', 'active')
            ->get();

        if ($active_subscription) {
            $active_key = 0;
            $history_key = 0;
            $vat_no = '';
            $total_member_added = DB::table('user_purchase_subscriptions')
                //->where('payment_type','subscription')
                ->where('user_id', $user_id)
                ->where('status', 'active')
                ->sum('member_included');

            if (!isset($total_member_added)) {
                $total_member_added = 0;
            }
            //dd($total_member_added);
            foreach ($active_subscription as $key => $subscription) {
                if (strtotime($subscription->expired_date) > strtotime(date('Y-m-d')) && $subscription->status == 'active') {
                    if (isset($subscription->transaction_detail['trackable_data']['vat_detail']) && count($subscription->transaction_detail['trackable_data']['vat_detail']) > 0) {
                        $vat_percentage = $subscription->transaction_detail['trackable_data']['vat_detail']['vat_percentage'];
                        $vat_no = $subscription->transaction_detail['trackable_data']['vat_detail']['vat_no'];
                    }


                    if (isset($subscription->transaction_detail['trackable_data']['product_type']) && count($subscription->transaction_detail['trackable_data']) > 0) {
                        $package_cost = $subscription->transaction_detail['trackable_data']['product_type']['price'];
                    }

                    if ($vat_percentage > 0 && $package_cost > 0) {
                        $total_vat_cost = ($package_cost / 100 * $vat_percentage);
                    }

                    // Active
                    $active[$active_key]['id'] = $subscription->subscription_detail ? $subscription->subscription_detail->id : '';
                    $active[$active_key]['transaction_detail'] = $subscription->transaction_detail;
                    $active[$active_key]['subscription_detail'] = $subscription->subscription_detail;
                    $active[$active_key]['subscription_name'] = $subscription->subscription_detail ? $subscription->subscription_detail->name : '';
                    $active[$active_key]['duration'] = $subscription->subscription_detail ? $subscription->subscription_detail->duration : '';
                    $active[$active_key]['member_included'] = $total_member_added;
                    // $active[ $active_key ]['type_of_acount'] = $subscription->subscription_detail ? $subscription->subscription_detail->account_type->name : '';
                    $active[$active_key]['package_cost'] = $package_cost;
                    $active[$active_key]['vat_no'] = $vat_no;
                    $active[$active_key]['vat_percentage'] = $vat_percentage ? $vat_percentage : '--';
                    $active[$active_key]['vat_cost'] = $total_vat_cost ? $total_vat_cost : '--';
                    $active[$active_key]['total_cost'] = $subscription->transaction_detail ? $subscription->transaction_detail->amount : '';
                    $active[$active_key]['expired_date'] = $subscription->expired_date ? $subscription->expired_date : '';
                    $active_key++;
                }
            }
        }

        if ($subscription_history_list) {
            $history_key = 0;
            $vat_no = 0;
            foreach ($subscription_history_list as $key => $subscription) {
                // History
                if(isset($subscription->transaction_detail->trackable_data))
                {
                    $subscription_history_list[$key]->trackable_data = $subscription->transaction_detail->trackable_data;
                }
                else
                {
                    $subscription_history_list[$key]->trackable_data = '';
                }
            }
        }


        $data = [];
        $data['active'] = $active;
        $data['history'] = $subscription_history_list;
        $user_accounts_count = User::where('mobile', Auth::user()->mobile)->count();
        if ($user_accounts_count == 1) {
            $data['single_account'] = true;
        } else {
            $data['single_account'] = false;
        }

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('status' => true,
            'message' => '',
            'data' => $data)
        ];
        Helper::save_api_logs($logdata);


        return $response = [
            'status' => true,
            'message' => '',
            'data' => $data
        ];
    }



    public function user_profile_edit(Request $request, $member_id = null)
    {
        $user_data = [];
        $user_other_data = [];

        switch ($request) {
            case $request->has('default_language'): {
                    $request->validate([
                        'default_language' => ['nullable']
                    ]);
                    $user_data['default_language'] = $request->default_language;
                    break;
                }
            case $request->has('allow_notification_messages'): {
                    $request->validate([
                        'allow_notification_messages' => ['nullable']
                    ]);
                    $user_data['allow_notification_messages'] = $request->allow_notification_messages;
                    break;
                }
            case $request->has('allow_notification_education_content'): {
                    $request->validate([
                        'allow_notification_education_content' => ['nullable']
                    ]);
                    $user_data['allow_notification_education_content'] = $request->allow_notification_education_content;
                    break;
                }
            case $request->has('img'): {
                    $request->validate([
                        'img' => 'required|mimes:png,jpeg|max:25120'
                    ]);

                    break;
                }
            case $request->has('name'): {
                    $request->validate([
                        'name' => 'required'
                    ]);
                    //$user_data['family_name'] = $request->name;
                    $user_other_data['name'] = $request->name;
                    $user_data['name'] = $request->name;
                    break;
                }
            case $request->has('do_you_allow_talking_before_marriage'): {
                    $request->validate([
                        'do_you_allow_talking_before_marriage' => 'required'
                    ]);
                    //$user_data['family_name'] = $request->name;
                    $user_data['do_you_allow_talking_before_marriage'] = $request->do_you_allow_talking_before_marriage;
                    break;
                }

            case $request->has('status'): {

                    $user_other_data['status'] = $request->status;
                    $user_data['status'] = $request->status;
                    $logged_in_user_id = Auth::user()->id;
                    if ($request->status == 'green') {
                        DB::table('user_yellow_connections')->where('user_id', $logged_in_user_id)->delete();
                        DB::table('user_red_connections')->where('user_id', $logged_in_user_id)->delete();
                    } else if ($request->status == 'yellow') {
                        DB::table('user_red_connections')->where('user_id', $logged_in_user_id)->delete();
                    } else {
                        DB::table('user_yellow_connections')->where('user_id', $logged_in_user_id)->delete();
                    }
                    break;
                }
            case $request->has('family_name'): {
                    $request->validate([
                        'family_name' => 'required'
                    ]);
                    $user_data['name'] = $request->family_name;
                    //$user_other_data['name'] = $request->name;
                    break;
                }
            case $request->has('dob'): {

                    $request->validate([
                        'dob' => 'required|date|before:' . now()->subYears(17)->toDateString(),

                    ], [
                        'dob.required' => __('api.set_profile_info.form_fields.dob.required'),
                        'dob.date' => __('api.set_profile_info.form_fields.dob.date'),
                        'dob.before' => __('api.set_profile_info.form_fields.dob.before'),
                    ]);
                    $user_other_data['dob'] = date('Y-m-d', strtotime($request->dob));
                    break;
                }
            case $request->has('bio'): {
                    $request->validate([
                        'bio' => 'required'
                    ]);
                    //$user_data['bio'] = $request->bio;
                    $user_other_data['bio'] = $request->bio;
                    break;
                }
            case $request->has('family_bio'): {
                    $request->validate([
                        'family_bio' => 'required'
                    ]);
                    $user_data['bio'] = $request->family_bio;
                    $user_data['about_family'] = $request->family_bio;
                    break;
                }
            case $request->has('nationality_id'): {
                    $request->validate([
                        'nationality_id' => 'required'
                    ]);
                    $user_data['nationality_id'] = $request->nationality_id;


                    if (!empty($request->family_origin_id == 195)) {
                        $user_data['saudi_family_origin_region_id'] = $request->saudi_family_origin_region_id ? $request->saudi_family_origin_region_id : '';
                        $user_data['saudi_family_origin_city_id'] = $request->saudi_family_origin_city_id ? $request->saudi_family_origin_city_id : '';
                    }
                    break;
                }
            case $request->has('resident_country_id'): {
                    $request->validate([
                        'resident_country_id' => 'required'
                    ]);
                    $user_data['resident_country_id'] = $request->resident_country_id;

                    if (!empty($request->resident_country_id == 195)) {
                        $req_master_data['live_in_region_id'] = $request->live_in_region_id ? $request->live_in_region_id : '';
                        $req_master_data['live_in_city_id'] = $request->live_in_city_id ?  $request->live_in_city_id : '';
                    }


                    break;
                }
            case $request->has('live_in_region_id') or $request->has('live_in_city_id'): {
                    // $request->validate([
                    //     'live_in_region_id' => $request->has('live_in_region_id') ? 'required' : null,
                    //     'live_in_city_id' => $request->has('live_in_city_id') ? 'required' : null,
                    // ]);
                    if(isset($request->live_in_region_id))
                    $user_data['live_in_region_id'] = $request->live_in_region_id;
                    if(isset($request->live_in_city_id))
                    $user_data['live_in_city_id'] = $request->live_in_city_id;
                    break;
            }
            case $request->has('saudi_family_origin_id'): {
                    $request->validate([
                        'saudi_family_origin_id' => 'required'
                    ]);
                    $user_data['saudi_family_origin_id'] = $request->saudi_family_origin_id ? $request->saudi_family_origin_id : '';
                    $user_data['saudi_family_origin_region_id'] = $request->saudi_family_origin_region_id ? $request->saudi_family_region_id : '';
                    $user_data['saudi_family_origin_city_id'] = $request->saudi_family_origin_city_id ? $request->saudi_family_origin_city_id : '';
                    break;
                }
            case $request->has('family_origin_id'): {
                    $request->validate([
                        'family_origin_id' => 'required'
                    ]);
                    $user_data['family_origin_id'] = $request->family_origin_id;

                    // $user_data['saudi_family_origin_region_id'] = $request->saudi_family_origin_region_id ? $request->saudi_family_origin_region_id : '';
                    // $user_data['saudi_family_origin_city_id'] = $request->saudi_family_origin_city_id ?$request->saudi_family_origin_city_id : '';

                    break;
                }
            case $request->has('saudi_family_origin_region_id'): {
                    $request->validate([
                        'saudi_family_origin_region_id' => 'nullable'
                    ]);
                    $user_data['saudi_family_origin_region_id'] = $request->saudi_family_origin_region_id;
                    break;
                }
            case $request->has('saudi_family_origin_city_id'): {
                    $request->validate([
                        'saudi_family_origin_city_id' => 'nullable'
                    ]);
                    $user_data['saudi_family_origin_city_id'] = $request->saudi_family_origin_city_id;
                    break;
                }
            case $request->has('tribe_id'): {
                    $request->validate([
                        'tribe_id' => 'required'
                    ]);
                    $user_data['tribe_id'] = $request->tribe_id;
                    break;
                }
            case $request->has('is_your_family_tribal'): {
                    $request->validate([
                        'is_your_family_tribal' => 'required'
                    ]);

                    $user_data['is_your_family_tribal'] = $request->is_your_family_tribal;
                    if($request->is_your_family_tribal == 'no') {
                        $user_data['tribe_id'] = '';
                    }
                    break;
                }
                // More details
            case $request->has('married_previously'): {
                    $request->validate([
                        'married_previously' => 'required'
                    ]);
                    $user_other_data['married_previously'] = $request->married_previously;
                    $user_other_data['currently_married'] = $request->currently_married;
                    $user_other_data['children_id'] = $request->children_id;
                    break;
                }
            case $request->has('do_you_care_about_tribalism'): {
                    $request->validate([
                        'do_you_care_about_tribalism' => 'required'
                    ]);
                    $user_other_data['do_you_care_about_tribalism'] = $request->do_you_care_about_tribalism;
                    break;
                }

            case $request->has('does_she_or_he_has_flexibility_to_marry_a_married_man'): {
                    $request->validate([
                        'does_she_or_he_has_flexibility_to_marry_a_married_man' => 'required'
                    ]);
                    $user_other_data['does_she_or_he_has_flexibility_to_marry_a_married_man'] = $request->does_she_or_he_has_flexibility_to_marry_a_married_man;
                    $user_other_data['accept_polygamy'] = $request->accept_polygamy;
                    break;
                }
            case $request->has('height'): {
                    $request->validate([
                        'height' => 'required'
                    ]);
                    $step = $request->step;
                    $height_min;
                    if (is_array($request->height)) {
                        $height_min = $request->height[0];
                        $max_height = $height_min + $request->step;
                        $height_label = $height_min . '-' . $max_height . ' cm';
                    } else {
                        $height_min = $request->height;
                        $max_height = $height_min + $request->step;
                        $height_label = $height_min . '-' . $max_height . ' cm';
                    }
                    $user_other_data['height'] = $height_label;
                    $user_other_data['height_min'] = $height_min;
                    $user_other_data['height_max'] = $max_height;
                    break;
                }
            case $request->has('skin_color_id'): {
                    $request->validate([
                        'skin_color_id' => 'required'
                    ]);
                    $user_other_data['skin_color_id'] = $request->skin_color_id;
                    break;
                }
            case $request->has('education_id'): {
                    $request->validate([
                        'education_id' => 'required'
                    ]);
                    $user_other_data['education_id'] = $request->education_id;
                    break;
                }
            case $request->has('work_id'): {
                    $request->validate([
                        'work_id' => 'required'
                    ]);
                    $user_other_data['work_id'] = $request->work_id;
                    break;
                }
            case $request->has('sect_id'): {
                    $request->validate([
                        'sect_id' => 'required'
                    ]);
                    $user_other_data['sect_id'] = $request->sect_id;
                    break;
                }
            case $request->has('smoking'): {
                    $request->validate([
                        'smoking' => 'required'
                    ]);
                    $user_other_data['smoking'] = $request->smoking;
                    break;
                }
            case $request->has('hijab_type_id'): {
                    $request->validate([
                        'hijab_type_id' => 'required'
                    ]);
                    $user_other_data['hijab_type_id'] = $request->hijab_type_id;
                    break;
                }
            case $request->has('personality_dimensions'): {
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
                        $logdata = [
                            'request_data' => $request->all(),
                            'response_data' => array('errors' => array('personality_dimensions' => 'all values should not be same as 3'))
                        ];
                        Helper::save_api_logs($logdata);
                        return response([
                            'errors' => [
                                'personality_dimensions' => ['all values should not be same as 3']
                            ],
                        ], 422);
                    }

                    //update personality_dimensions for individual profile
                    if ($request->account_type_id == 2) {
                        if (isset($dt_personality_dimensions) && count($dt_personality_dimensions)) {
                            foreach ($dt_personality_dimensions as $pd) {
                                $db_user_pd = UserPersonalityDimension::where([
                                    'user_id' => $request->user_id,
                                    'personality_dimension_id' => $pd['id']
                                ])->first();
                                if ($db_user_pd) {
                                    $db_user_pd->update(['point' => $pd['value']]);
                                } else {
                                    $db_user_pd = UserPersonalityDimension::create([
                                        'user_id' => $request->user_id,
                                        'personality_dimension_id' => $pd['id'],
                                        'point' => $pd['value']
                                    ]);
                                }
                            }
                        }
                    }

                    //update personality_dimensions for family account or members in family
                    if ($request->account_type_id == 1) {
                        if (isset($dt_personality_dimensions) && count($dt_personality_dimensions)) {
                            foreach ($dt_personality_dimensions as $pd) {
                                $db_user_pd = UserFamilyPersonalityDimension::where([
                                    'user_family_id' => $request->user_family_id,
                                    'personality_dimension_id' => $pd['id']
                                ])->first();
                                if ($db_user_pd) {
                                    $db_user_pd->update(['point' => $pd['value']]);
                                } else {
                                    $db_user_pd = UserFamilyPersonalityDimension::create([
                                        'user_family_id' => $request->user_family_id,
                                        'personality_dimension_id' => $pd['id'],
                                        'point' => $pd['value']
                                    ]);
                                }
                            }
                        }
                    }
                    break;
                }
        }


        $user_id = Auth::user()->id;
        $user = User::find($user_id);


        $user->update($user_data);

        // if ($request->img) {

        //     // return $path;
        //     if(empty($member_id)) {
        //         $path = $this->_base64fileUpload($request->img, '/profile_img');
        //         if(!empty($request->profile_img_id)) {
        //             $user_profile_img = UserProfileImage::where('id',$request->profile_img_id)->where('user_id',$user_id)->update([
        //                 'profile_img' => $path
        //             ]);
        //         } else {
        //             $total_pic_count = UserProfileImage::where('user_id',$user->id)->count();
        //             if($total_pic_count < 8) {
        //                 UserProfileImage::where('user_id',$user_id)->update([
        //                     'is_default' =>0
        //                 ]);
        //                 $user_profile_img = UserProfileImage::insert([
        //                     'profile_img' => $path,
        //                     'user_id' => $user_id,
        //                     'is_default' => 1,
        //                 ]);
        //             } else {
        //                 $user_profile = UserProfileImage::where('user_id',$user->id)->first();
        //                 if($user_profile) {
        //                     UserProfileImage::where('user_id',$user_id)->update([
        //                         'is_default' =>0
        //                     ]);
        //                     $user_profile_img = UserProfileImage::where('id',$user_profile->id)->update([
        //                         'profile_img' => $path,
        //                         'user_id' => $user_id,
        //                         'is_default' => 1,
        //                     ]);
        //                 }

        //             }

        //         }
        //     }
        //     /// in case of member
        //     if(!empty($member_id)) {
        //         $path = $this->_base64fileUpload($request->img, '/family_profile_img');
        //         if(!empty($request->profile_img_id)) {
        //             $user_profile_img = UserFamilyProfileImage::where('id',$request->profile_img_id)->where('user_family_id',$member_id)->update([
        //                 'profile_img' => $path
        //             ]);
        //         } else {

        //             $user_profile = UserFamilyProfileImage::where('user_family_id',$member_id)->orderBy('id','desc')->first();
        //             if($user_profile) {

        //                 $user_profile_img = UserFamilyProfileImage::where('user_family_id',$user_profile->user_family_id)->update([
        //                    'is_default' => 0,
        //                 ]);

        //                 $user_profile_img = UserFamilyProfileImage::where('id',$user_profile->id)->update([
        //                     'profile_img' => $path,
        //                     'user_family_id' => $member_id,
        //                     'is_default' => 1,
        //                 ]);
        //             } else {

        //                 $user_profile_img = UserFamilyProfileImage::insert([
        //                     'profile_img' => $path,
        //                     'user_family_id' => $member_id,
        //                     'is_default' => 1,
        //                 ]);

        //             }
        //         }
        //     }

        // } else {

        //     // if(!empty($member_id)) {
        //     //     $path = '/family_profile_img/dummy_profile.png';
        //     //     $user_profile_img = UserFamilyProfileImage::create([
        //     //         'user_family_id' => $member_id,
        //     //         'profile_img' => $path,
        //     //         'is_default' => 1
        //     //     ]);
        //     // } else {
        //     //     $path = '/profile_img/dummy_profile.png';
        //     //     $user_profile_img = UserProfileImage::create([
        //     //         'user_id' => $user_id,
        //     //         'profile_img' => $path,
        //     //         'is_default' => 1
        //     //     ]); 
        //     // }
        // }

        if (!empty($member_id)) {
            $member_data_exits = UserFamily::where('id', $member_id)->first();
            if ($member_data_exits) {
                UserFamily::where('id', $member_id)->update($user_other_data);
            } else {
                $user_other_data['user_id'] = $user_id;
                UserFamily::insert($user_other_data);
            }
        } else {
            //dd(Auth::user()->account_type_id);
            if (Auth::user()->account_type_id == 2) { // Indi
                //dd($user_other_data);
                UserFamily::where('user_default_id', $user_id)->update($user_other_data);
            } else { // fami
                UserFamily::where('user_default_id', $user_id)->update($user_other_data);
            }
        }


        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $verfied_data = Helper::user_all_detail($user);


        //message come form db
        $message_text = __('api.user_profile_update.success_message');
        $message_data = Helper::getMessageByCode('NOT08');
        $prefered_lag = $user->default_language;
        if ($prefered_lag == 'en') {
            $message_text = $message_data->message_value_en;
        } else {
            $message_text = $message_data->message_value_ar;
        }

        $response = [
            'success' => true,
            'message' => $message_text
        ];

        $response['data']['user'] = $verfied_data;

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => $response
        ];
        Helper::save_api_logs($logdata);

        return $response;
    }

    public function user_likes_hide_blocked(Request $request, $user_type, $user_id, $reason_id = null)
    {

        $user_other_data = [];
        $message = "";
        switch ($request) {
            case $request->has('is_liked'): {
                    $request->validate([
                        'is_liked' => 'required'
                    ]);
                    $user_other_data['is_liked'] = $request->is_liked;

                    //@ send notifications
                    if ($user_type != 'member' && $request->is_liked == 1) {
                        $device_tokens = Helper::getRecipantDeviceTokens($user_id, 'liked');
                        //dd($device_tokens);
                        $message_data = Helper::getMessageByCode('NOT05');
                        $messgae = array(
                            "title" => $message_data->message_value_en,
                            "body" => $message_data->message_value_en
                        );
                        $sender_id = Auth::user()->id;
                        $notification_type = 'profile_like';
                        $key1 = Helper::getUserName($sender_id);
                        $key2 = '';
                        Helper::send_notification_FCM($device_tokens, $messgae, $message_data, $sender_id, $user_id, $key1, $key2, $notification_type);
                        // End send notifications
                    }
                    break;
                }
            case $request->has('is_reported'): {
                    $request->validate([
                        'is_reported' => 'required'
                    ]);
                    $user_other_data['is_reported'] = $request->is_reported;
                    $user_other_data['is_blocked'] = $request->is_blocked ? $request->is_blocked : 0;
                    $user_other_data['reason_id'] = $reason_id;
                    $user_other_data['reported_date'] = date('Y-m-d');
                    $logged_in_id = Auth::user()->id;
                    Helper::connection_removed($logged_in_id, $user_id);
                    // @send Notification
                    /*
                    $device_tokens = Helper::getRecipantDeviceTokens($user_id, 'reported');
                    //dd();
                    $message_data = Helper::getMessageByCode('NOT023');

                    $sender_id = Auth::user()->id;
                    if ($request->is_blocked == 1) {
                        $notification_type = 'block_connection';
                        $key1 = Helper::getUserName($sender_id);
                        $key2 = '';
                        $recipant_user = User::find($user_id);
                        $prefered_lag = $recipant_user->default_language ? $recipant_user->default_language : 'en';
                        if ($prefered_lag == 'en') {
                            $noti_title = trans('api.common.blocked_reported', ['attribute' => $key1], 'en');
                            $noti_mesage = trans('api.common.blocked_reported', ['attribute' => $key1], 'en');
                        } else {
                            $noti_title = trans('api.common.blocked_reported', ['attribute' => $key1], 'ar');
                            $noti_mesage = trans('api.common.blocked_reported', ['attribute' => $key1], 'ar');
                        }
                        $badge_count = Helper::user_has_unread_notifications();
                        $message_data = Helper::getMessageByCode('NOT023');
                        $messgae = array(
                            "title" => $noti_title,
                            "body" => $noti_mesage,
                            'badge' => $badge_count,
                            "key_name" => 'reported',
                            "sound" => "default"
                        );
                        Helper::send_notification_FCM($device_tokens, $messgae, $message_data, $sender_id, $user_id, $key1, $key2, $notification_type);
                    }
                    */
                    break;
                }
            case $request->has('is_hide'): {
                    $request->validate([
                        'is_hide' => 'required'
                    ]);
                    $user_other_data['is_hide'] = $request->is_hide;
                    // Update the user family records
                    if (in_array($user_type, ['member', 'individual'])) {
                        UserFamily::where('id', $user_id)->update(
                            [
                                'is_hide' => $request->is_hide ? $request->is_hide : 0
                            ]
                        );
                    }

                    break;
                }
            case $request->has('is_blocked'): {
                    $request->validate([
                        'is_blocked' => 'required'
                    ]);
                    $user_other_data['is_blocked'] = $request->is_blocked;
                    $user_other_data['is_reported'] = 0;
                    $user_other_data['reason_id'] = null;
                    $logged_in_id = Auth::user()->id;

                    Helper::connection_removed($logged_in_id, $user_id);
                    // @send Notification
                    /*
                    $device_tokens = Helper::getRecipantDeviceTokens($user_id, 'reported');
                    //dd($device_tokens);
                    $message_data = Helper::getMessageByCode('NOT023');

                    $sender_id = Auth::user()->id;
                    if ($request->is_blocked == 1) {
                        $notification_type = 'block_connection';
                        $key1 = Helper::getUserName($sender_id);
                        $key2 = '';
                        $recipant_user = User::find($user_id);
                        //dd($recipant_user->default_language);
                        $prefered_lag = $recipant_user->default_language ? $recipant_user->default_language : 'en';
                        if ($prefered_lag == 'en') {
                            $noti_title = trans('api.common.blocked_reported', ['attribute' => $key1], 'en');
                            $noti_mesage = trans('api.common.blocked_reported', ['attribute' => $key1], 'en');
                        } else {
                            $noti_title = trans('api.common.blocked_reported', ['attribute' => $key1], 'ar');
                            $noti_mesage = trans('api.common.blocked_reported', ['attribute' => $key1], 'ar');
                        }
                        $badge_count = Helper::user_has_unread_notifications();
                        $messgae = array(
                            "title" => $noti_title,
                            "body" => $noti_mesage,
                            'badge' => $badge_count,
                            "key_name" => 'reported',
                            "sound" => "default"
                        );
                        Helper::send_notification_FCM($device_tokens, $messgae, $message_data, $sender_id, $user_id, $key1, $key2, $notification_type);
                    }
                    */
                    break;
                }
        }

        $logged_in_id = Auth::user()->id;
        $user_other_data['request_id'] = $logged_in_id;
        $user_other_data['user_type'] = $user_type;

        if (!empty($user_id)) {
            $member_data_exits = UserLikesHideBlocked::where('user_type', $user_type)->where('request_id', $logged_in_id)->where('user_id', $user_id)->first();
            if ($member_data_exits) {
                UserLikesHideBlocked::where('user_type', $user_type)->where('request_id', $logged_in_id)->where('user_id', $user_id)->update($user_other_data);
            } else {
                $user_other_data['user_id'] = $user_id;
                UserLikesHideBlocked::insert($user_other_data);
            }
        }

        //$result = Self::get_other_avaliable_users($request);
        if ($request->has('is_liked')) {

            $message = $request->is_liked ? trans('api.common.successfully_liked') : trans('api.common.successfully_disliked');
            if ($request->is_liked) {
                $message_data = Helper::getMessageByCode('NOT09');
            } else {
                $message_data = Helper::getMessageByCode('NOT010');
            }

            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }

            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }

        if ($request->has('is_reported')) {

            if ($request->is_reported) {
                $message_data = Helper::getMessageByCode('NOT018');
            } else if ($request->is_blocked == 0) {
                $message_data = Helper::getMessageByCode('NOT022');
            }

            //dd($message_data);

            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }

            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }

        if ($request->has('is_blocked')) {


            if (1) {
                $message_data = Helper::getMessageByCode('NOT022');
            }

            $prefered_lag = Auth::user()->default_language ? Auth::user()->default_language : 'en';
            if ($prefered_lag == 'en') {
                $message_text = $message_data ? $message_data->message_value_en : $message;
            } else {
                $message_text = $message_data ? $message_data->message_value_ar : $message;
            }

            $message = $message_text;
            //$message = trans('api.common.connection_request_sent_successfully',['attribute'=>'Anup'],'en');
        }

        $data['user_likes_hide_blocked'] = Helper::user_likes_hide_blocked_detail($user_id);

        $response = [
            'status' => true,
            'message' => $message,
            'data' => $data,
        ];

        return $response;
        // complete list user send

    }


    public function send_notification_api_FCM(Request $request){
       // @send Notification
        $device_tokens = [];       
        $device_tokens[] = $request->device_token;
        //dd($device_tokens);
        $message_data = Helper::getMessageByCode('NOT023');
        $sender_id = $request->sender_id;
        $recipitant_id = $request->recipitant_id;
       
        $notification_type = $request->notification_type;
        $key1 = Helper::getUserName($sender_id);
        $key2 = '';
        $recipant_user = User::find($recipitant_id);
        //dd($recipant_user->default_language);
        $prefered_lag = 'en';
        if ($prefered_lag == 'en') {
            $noti_title = $request->noti_title;;
            $noti_mesage = $request->noti_mesage;;
        } 
        
        $messgae = array(
            "title" => $noti_title,
            "body" => $noti_mesage,
            'badge' => 0,
            "key_name" => 'reported',
            "sound" => "default"
        );
        $response = Helper::send_notification_test_FCM($device_tokens, $messgae, $message_data, $sender_id, $recipitant_id, $key1, $key2, $notification_type);
        
        die;
                    
    }

    public function delete_user(Request $request)
    {
        $id = Auth::user()->id;
        User::where('id', $id)->update(['deleted_by'=>$id]);
        User::find($id)->delete();
        UserFamily::where('user_id', $id)->update(['deleted_by'=>$id]);
        UserFamily::where('user_id', $id)->delete();

        Connection::where(function ($q) use ($id) {
            $q->where('request_id', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('receiver_id', $id);
        })
            ->delete();

        Message::where(function ($q) use ($id) {
            $q->where('request_id', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('receiver_id', $id);
        })
            ->delete();

        $message_data = Helper::getMessageByCode('NOT09');

        if ($request->hasHeader('X-localization')) {
            $prefered_lag = $request->header('X-localization');
        } else {
            $prefered_lag = 'en';
        }

        if ($prefered_lag == 'en') {
            $message_text = $message_data->message_value_en;
        } else {
            $message_text = $message_data->message_value_ar;
        }

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('success' => true,
            'message' => $message_text)
        ];
        Helper::save_api_logs($logdata);
        
        return [
            'success' => true,
            'message' => $message_text
        ];
    }



    public function user_liked_gallery_image(Request $request, $user_type, $user_id, $image_id)
    {
        $logged_in_id = Auth::user()->id;

        $user_other_data['request_id'] = $logged_in_id;
        $user_other_data['user_type'] = $user_type;
        $user_other_data['profile_image_id'] = $image_id;
        $user_other_data['is_liked'] = $request->is_liked;
        $user_other_data['user_id'] = $user_id;

        if (!empty($user_id)) {
            $member_data_exits = DB::table('user_likes_gallery_images')->where('user_type', $user_type)->where('request_id', $logged_in_id)->where('user_id', $user_id)->where('profile_image_id', $image_id)->first();
            if ($member_data_exits) {
                DB::table('user_likes_gallery_images')->where('user_type', $user_type)->where('request_id', $logged_in_id)->where('user_id', $user_id)->where('profile_image_id', $image_id)->update($user_other_data);
            } else {
                $user_other_data['user_id'] = $user_id;
                DB::table('user_likes_gallery_images')->insert($user_other_data);
            }

            //@ send notifications
            if ($request->is_liked == 1) {
                if($user_type == 'individual') { //
                    $device_tokens = Helper::getRecipantDeviceTokens($user_id, 'liked');
                } else {
                    $device_tokens = Helper::getRecipantFamilyDeviceTokens($user_id, 'liked');
                }
               
                //dd($device_tokens);
                $message_data = Helper::getMessageByCode('NOT05');
                $messgae = array(
                    "title" => $message_data->message_value_en,
                    "body" => $message_data->message_value_en
                );
                $sender_id = Auth::user()->id;
                $notification_type = 'profile_like';
                $key1 = Helper::getUserName($sender_id);
                $key2 = '';
                Helper::send_notification_FCM($device_tokens, $messgae, $message_data, $sender_id, $user_id, $key1, $key2, $notification_type);
                // End send notifications
            }
        }

        $result = Self::get_other_avaliable_users($request);


        $logdata = [
            'request_data' => $request->all(),
            'response_data' => $result
        ];
        Helper::save_api_logs($logdata);

        return $result;
    }


    public function generate_invoice(Request $request, $checkout_id = null, $download = 0)
    {
        if ($request->hasHeader('X-localization')) {
            $localization = $request->header('X-localization');
        } else {
            $localization = 'en';
        }

        $res = Helper::generate_invoice($checkout_id, $download = 0, $localization);

        // $logdata = [
        //     'request_data' => $request->all(),
        //     'response_data' => $res
        // ];
        // Helper::save_api_logs($logdata);
        return $res;
    }

    public function member_extention_payment(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $encrypted_user_id = Crypt::encryptString($user_id);
        $short_payment_url = route('add_member_addon', [$encrypted_user_id]);
        $to = $user->mobile; //$to = '506208358';

        $id = DB::table('payment_url')->insertGetId(
            [
                'payment_url' => $short_payment_url,
                'user_id' => $user_id,
                'payment_type' => 'member_extension',
                'expiry_date' => Carbon::now()->addMinutes(30),
                'created_at' => date('Y-m-d H:i:s')
            ]
        );

        //$payment_link = '<a target="_blank" href="'.$short_payment_url.'">'.trans('api.common.click_here').'</a>';
        $rand = $id . '-' . substr(md5(microtime()), rand(0, 26), 2) . '-' . substr(md5(microtime()), rand(0, 26), 3);
        //$short_payment_url = route('pay', [$rand]);
        //$short_payment_url = 'https://awaser.sa/pay/'.$rand;
        //$short_payment_url = Config::get('app.site_url') . '/pay/' .$rand;
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
        if ($prefered_lag == 'en') {
            $type = 3;
            $message_payment = trans('api.common.message_payment', ['attribute' => $payment_link], 'en');
        } else {
            $type = 4;
            $message_payment = trans('api.common.message_payment', ['attribute' => $payment_link], 'ar');
        }

        //dd($message_payment);
        if ($to) {
            Helper::sendSms($message_payment, $to, $type);
        }

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('status' => true,
            'message' => 'Payment link is sent successfully.',
            'data' => $message_payment)
        ];
        Helper::save_api_logs($logdata);

        return $response = [
            'status' => true,
            'message' => 'Payment link is sent successfully.',
            'data' => $message_payment
        ];
    }


    public function subscription_extention_payment(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $encrypted_user_id = Crypt::encryptString($user_id);
        $short_payment_url = route('get_subscripton', [$encrypted_user_id]);
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
        $rand = $id . '-' . substr(md5(microtime()), rand(0, 26), 2) . '-' . substr(md5(microtime()), rand(0, 26), 3);
        //$short_payment_url = route('pay', [$rand]);
        //$short_payment_url = 'https://awaser.sa/pay/'.$rand;
        //$short_payment_url = Config::get('app.site_url') . '/pay/' .$rand;
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
        if ($prefered_lag == 'en') {
            $type = 3;
            $message_payment = trans('api.common.message_payment', ['attribute' => $payment_link], 'en');
        } else {
            $type = 4;
            $message_payment = trans('api.common.message_payment', ['attribute' => $payment_link], 'ar');
        }

        //dd($message_payment);
        if ($to) { //if($to == '506208358') {
            Helper::sendSms($message_payment, $to, $type);
        }

        $logdata = [
            'request_data' => $request->all(),
            'response_data' => array('status' => true,
            'message' => 'Payment link is sent successfully.',
            'data' => $message_payment)
        ];
        Helper::save_api_logs($logdata);

        return $response = [
            'status' => true,
            'message' => 'Payment link is sent successfully.',
            'data' => $message_payment
        ];
    }
}
