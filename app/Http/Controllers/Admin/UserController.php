<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Jobs\UserExportNotify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelClass;
use Rap2hpoutre\FastExcel\FastExcel;

use App\Models\{Notification, User, Message};
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Helper\Helper;

//use DB;
use Yajra\DataTables\Facades\DataTables;

//use Auth;

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use PhpOffice\PhpSpreadsheet\Writer\Xls;

class UserController extends Controller
{

    public function userExport(Request $request)
    {
        if ($request->ajax()) {
            $fileName = "Users-" . str_replace([':', ' '], '', date('Y-m-d h:i:s')) . '.xlsx';

            Notification::create([
                'user_id' => Auth::user()->id,
                'type' => 'user_export',
                'data' => $fileName,
                'status' => 1
            ]);
            dispatch(new UserExportNotify($request->all(), $fileName))->delay(3);

            return response()->json(['status' => 200, 'file' => $fileName]);
        } else {
            return false;
        }
    }

    public function view_reports(Request $request, $user_id)
    {
        // get all the user
        $user_report_list = DB::table('user_likes_hide_blocked')
            ->select('user_likes_hide_blocked.*', 'master_reasons.reason_en', 'master_reasons.reason_ar')
            ->leftJoin('master_reasons', 'master_reasons.id', 'user_likes_hide_blocked.reason_id')
            ->where('user_likes_hide_blocked.user_id', $user_id)
            ->where('user_likes_hide_blocked.is_reported', 1)->get();

        // load the view and pass the user
        return view('admin.user.user_report', [
            'user_report_list' => $user_report_list
        ]);
    }


    public function index(Request $request)
    {
        


        if ($request->ajax()) {
            $user = User::select('*')
                ->where('email', '!=', 'admin@admin.com')
                ->where('is_admin', '0');

            if (1) {
                if (!empty($request->search)) {
                    $user = $user->where('name', $request->search)
                        ->orWhere('username', 'like', '%' . $request->search)
                        ->orWhere('email', $request->search)
                        ->orWhere('mobile', $request->search);
                }
                
                return Datatables::of($user)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->addColumn('name', function ($row) {
                      return $row->name ? $row->name : '--';
                    })
                    ->addColumn('username', function ($row) {
                        return $row->username ? $row->username : '--';
                    })
                    ->addColumn('mobile', function ($row) {
                        return $row->mobile ? $row->mobile : '--';
                    })
                    ->addColumn('email', function ($row) {
                        return $row->email ? $row->email : '--';
                    })
                    ->addColumn('send_notification', function ($row) {
                        return '<a class="btn btn-small btn-info btn-sm"
                        onclick="send_notification(' . $row->id . ')">Send Notification</a>';
                    })
                    ->addColumn('action', function ($row) {

                        $btn = '<a class="btn btn-small btn-info btn-sm"
                        href="' . route("admin.user.edit", ["id" => $row->id]) . '"><i class="fas fa-pencil-alt"></i></a>';


                        $btn .= '<button onclick="delete_user(' . $row->id . ')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>';

                        if (isset($row->account_type->id) && $row->account_type->id == 1) {

                            $btn .= '<a class="btn btn-small btn-warning btn-sm"
                            href="' . route("admin.user-family.index", ["family_head_user_id" => $row->id]) . '"><i class="fa fa-users" aria-hidden="true"></i></a>';
                        }


                        return $btn;
                    })
                    ->rawColumns(['username', 'name', 'mobile' , 'email' , 'send_notification', 'action'])
                    ->make(true);

            }
        }

        // load the view and pass the user
        return view('admin.user.user_index', [
            // //'user_list' => $data,
        ]);
    }

   
   


    public
    function edit($id)
    {
        // get the shark
        $user = User::with('members', 'members.profile_images_list', 'members.skin_detail', 'members.work_detail', 'members.education_detail', 'members.children_detail', 'members.sect_detail', 'members.hijab_detail', 'user_has_active_subscription')
            ->where('users.id', $id)->with('account_type')->first();

        $account_types = AccountType::all();
        $countries = Country::get();
        $regions = MasterRegion::get();
        $family_origins = FamilyOrigin::get();
        $childrens = MasterChildren::get();
        $heights = MasterHeight::get();
        $skin_colors = SkinColor::get();
        $educations = MasterEducational::get();
        $works = MasterWork::get();
        $tribes = MasterTribe::get();
        $hijab_types = HijabType::get();
        $cities = MasterCity::get();

        // return $educations;

        // return $countries;

        // show the edit form and pass the shark
        return view('admin.user.user_edit', [
            'user' => $user,
            'account_types' => $account_types,
            'countries' => $countries,
            'regions' => $regions,
            'family_origins' => $family_origins,
            'childrens' => $childrens,
            'heights' => $heights,
            'skin_colors' => $skin_colors,
            'educations' => $educations,
            'works' => $works,
            'tribes' => $tribes,
            'hijab_types' => $hijab_types,
            'cities' => $cities,
        ]);
    }

    public
    function update(Request $request, $id)
    {
        //$user=$request->user();
        //$user = User::where(['user_id'=>$user->id,'id'=>$id])->first();
        // dd($request->all());
        $user = User::find($id);
        $fields = $request->validate(
            [
                //'account_type_id' => 'required',
                'username' => 'required',
                'email' => 'required',
                'mobile' => 'required',
                'nationality_id' => 'required',
                'resident_country_id' => 'nullable',
                'region_id' => 'nullable',
                'city_id' => 'nullable',
                'family_origin_id' => 'nullable',
                'is_your_family_tribal' => 'nullable',
                'tribe_id' => 'nullable',
                'do_you_care_about_tribalism' => 'nullable',
                'do_you_allow_talking_before_marriage' => 'nullable',
                'about_family' => 'nullable',
            ],
            [

                "username.required" => __("api.admin.User.validation_msg.username.required"),
                "email.required" => __("api.admin.User.validation_msg.email.required"),
                "mobile.required" => __("api.admin.User.validation_msg.mobile.required"),
                "nationality_id.required" => __("api.admin.User.validation_msg.nationality_id.required"),
                "resident_country_id.required" => __("api.admin.User.validation_msg.resident_country_id.required"),
                "region_id.required" => __("api.admin.User.validation_msg.region_id.required"),
                "city_id.required" => __("api.admin.User.validation_msg.city_id.required"),

            ]
        );


        $user_families = [
            'dob' => $request->dob,
            'gender' => $request->gender,
            'married_previously' => $request->married_previously,
            'currently_married' => $request->currently_married,
            'children_id' => $request->children_id,
            'height' => $request->height,
            'skin_color_id' => $request->skin_color_id,
            'education_id' => $request->education_id,
            'work_id' => $request->work_id,
            'smoking' => $request->smoking,
            'bio' => $request->bio,

        ];


        //if($files=$request->file('img')){
        //Storage::disk('public')->delete($user->img);
        //$fields['img']=$files->storePublicly('uploads','public');
        //}

        //dd($fields);
        $user->update($fields);

        $has_entry = UserFamily::where('user_default_id', $user->id)->first();

        if ($has_entry) {
            UserFamily::where('user_default_id', $user->id)->update($user_families);
        }


        // redirect
        Session::flash('success', __('api.admin.User.message.edit.success'));
        return Redirect::to(route('admin.user.index'));
    }

    public
    function destroy(Request $request)
    {

        //$user=$request->user();
        $id = $request->user_id;
        // delete
        //$user = User::where(['user_id'=>$user->id])->get();

        $user = User::find($id);

        User::where('id', $id)->update(['deleted_by' => Auth::user()->id]);
        UserFamily::where('user_id', $id)->update(['deleted_by' => Auth::user()->id]);
        UserFamily::where('user_id', $id)->delete();
        //Storage::disk('public')->delete($user->img);

        $user->delete();

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

        echo json_encode([
            'status' => 'success'
        ]);
        die;

    }

    public
    function user_blocked(Request $request)
    {


        User::where('id', $request->user_id)->update(['account_blocked' => $request->account_blocked]);

        echo json_encode(['status' => 'success']);

    }

    public
    function user_report_list(Request $request)
    {
        $user = User::where('email', '!=', 'admin@admin.com')
            ->with('user_default_info')
            ->has('user_has_report');
        $selected_countries = [];
        if ($request->has('advance_search')) {
            //dd($request->all());
            if (!empty($request->account_type)) {
                $user = $user->where('account_type_id', $request->account_type);
            }
            if (!empty($request->country) && count($request->country) > 0) {
                $selected_countries = $request->country;
                $user = $user->whereIn('nationality_id', $request->country);
            }
            if (!empty($request->residence_country) && count($request->residence_country) > 0) {
                $selected_countries = $request->residence_country;
                $user = $user->whereIn('resident_country_id', $selected_countries);
            }
            if (!empty($request->region)) {
                $user = $user->where('live_in_region_id', $request->region);
            }
            if (!empty($request->city)) {
                $user = $user->where('live_in_city_id', $request->city);
            }
            if (!empty($request->family_origin)) {
                $user = $user->where('family_origin_id', $request->family_origin);
            }
            if (!empty($request->previsously_married)) {
                $previsously_married = $request->previsously_married;
                $user = $user->whereHas('user_default_info', function ($q) use ($previsously_married) {
                    $q->where('married_previously', $previsously_married);
                });
            }
            if (!empty($request->currently_married)) {
                $currently_married = $request->currently_married;
                $user = $user->whereHas('user_default_info', function ($q) use ($currently_married) {
                    $q->where('currently_married', $currently_married);
                });
            }
            if (!empty($request->height)) {
                $height = $request->height;
                $user = $user->whereHas('user_default_info', function ($q) use ($height) {
                    $q->where('height', $height);
                });
            }
            if (!empty($request->age)) {
                $age = $request->age;
                $user = $user->whereHas('user_default_info', function ($q) use ($age) {
                    $q->whereDate('dob', '>=', $age);
                });
            }
            if (!empty($request->gender)) {
                $gender = $request->gender;
                $user = $user->whereHas('user_default_info', function ($q) use ($gender) {
                    $q->where('gender', $gender);
                });
            }
            if (!empty($request->no_of_children)) {
                $no_of_children = $request->no_of_children;
                $user = $user->whereHas('user_default_info', function ($q) use ($no_of_children) {
                    $q->where('children_id', $no_of_children);
                });
            }
            if (!empty($request->skin_color)) {
                $skin_color = $request->skin_color;
                $user = $user->whereHas('user_default_info', function ($q) use ($skin_color) {
                    $q->where('skin_color_id', $skin_color);
                });
            }
            if (!empty($request->occupation)) {
                $occupation = $request->occupation;
                $user = $user->whereHas('user_default_info', function ($q) use ($occupation) {
                    $q->where('work_id', $occupation);
                });
            }
            if (!empty($request->smoking)) {
                $smoking = $request->smoking;
                $user = $user->whereHas('user_default_info', function ($q) use ($smoking) {
                    $q->where('smoking', $smoking);
                });
            }
            if (!empty($request->smoking)) {
                $smoking = $request->smoking;
                $user = $user->whereHas('user_default_info', function ($q) use ($smoking) {
                    $q->where('smoking', $smoking);
                });
            }
            if (!empty($request->education)) {
                $education = $request->education;
                $user = $user->whereHas('user_default_info', function ($q) use ($education) {
                    $q->where('education_id', $education);
                });
            }

        }


        // get all the user
        $user = $user->get();

        $country_list = Country::orderByRaw(" code='SA' DESC, id ")->get();
        $education_list = MasterEducational::all();
        $tribes_list = DB::table('master_tribes')->get();
        $region_list = MasterRegion::get();
        $cities_list = MasterCity::get();
        $sect_list = DB::table('master_sects')->get();
        $family_origin_list = DB::table('family_origins')->get();
        $master_heights = DB::table('master_heights')->first();
        $children_list = DB::table('master_childrens')->get();
        $skin_color = DB::table('master_skin_color')->get();
        $occupation_list = DB::table('master_works')->get();
        // load the view and pass the user
        return view('admin.user.user_report_index', [
            'user_list' => $user,
            'country_list' => $country_list,
            'education_list' => $education_list,
            'tribes_list' => $tribes_list,
            'cities_list' => $cities_list,
            'sect_list' => $sect_list,
            'family_origin_list' => $family_origin_list,
            'region_list' => $region_list,
            'selected_countries' => $selected_countries,
            'master_heights' => $master_heights,
            'children_list' => $children_list,
            'skin_color' => $skin_color,
            'occupation_list' => $occupation_list
        ]);
    }


}
