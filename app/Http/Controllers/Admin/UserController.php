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
use Illuminate\Support\Facades\Hash;

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
                //->where('email', '!=', 'admin@admin.com')
                ->where('user_type', '!=', 'admin');

            if (1) {
                
                if (!empty($request->search)) {
                    $search = $request->search['value'];
                    $user = $user->where(
                            function($query) use ($search)  {
                                return $query
                                ->where('name','like', '%'.$search.'%')
                                ->orWhere('mobile','like', '%'.$search.'%')
                                ->orWhere('email','like', '%'.$search.'%');
                            }
                        );
                }

                //dd( $user);
                
                return Datatables::of($user)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->addColumn('name', function ($row) {
                      return $row->name ? $row->name : '--';
                    })
                    ->addColumn('username', function ($row) {
                        $u_data = $row->username ? '<p> Username: '.$row->username.'</p>' : '<p>'.'--'.'</p>';
                        $u_data .= $row->email ? '<p>Email: '.$row->email.'</p>' : '<p>'.'--'.'</p>';
                        return $u_data;
                    })
                    ->addColumn('mobile', function ($row) {
                        return $row->mobile ? $row->mobile : '--';
                    })
                    ->addColumn('address', function ($row) {
                        return $row->address ? $row->address : '--';
                    })
                    ->addColumn('user_type', function ($row) {
                        return strtoupper(str_replace('_',' ',$row->user_type));
                    })
                    ->addColumn('action', function ($row) {

                        $btn = '<a class="btn btn-small btn-info btn-sm"
                        href="' . route("admin.user.edit", ["id" => $row->id]) . '"><i class="fas fa-pencil-alt"></i></a>';


                        $btn .= '<button onclick="delete_user(' . $row->id . ')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>';

                        
                        return $btn;
                    })
                    ->rawColumns(['username', 'name', 'mobile' , 'address' , 'user_type', 'action'])
                    ->make(true);

            }
        }

        // load the view and pass the user
        return view('admin.user.user_index', [
            // //'user_list' => $data,
        ]);
    }

   
   public function create()
   {
        $page_title = 'Add User';
        //$categories = Category::all();
        //$data = Product::select('*')->where('id',$id)->first();
        $user_types = [
            'tele_caller','amc_user','technician','normal_user'
        ];
        return view('admin.user.user_create', [
            'page_title' => $page_title,
            'user_types' =>$user_types,
            //'data' => $data,
        ]);
   }


   public
    function store(Request $request)
    {
        $fields = $request->validate(
            [ 
                //'category_id' => 'required',
                'name' => 'required',
                'password' => 'min:6',
                'mobile' => 'required|digits:10',
                'email' => 'nullable|email|unique:users,email',
                'username' => 'required|unique:users,username', 
                'address' => 'nullable',
            ],
            [
                "category_id.required" => "This field is required",
            ]
        );

        
        

        //dd($request->all());
        $fields['password'] = Hash::make($request->password);
        $fields['user_type'] = $request->user_type;
        $model = User::create( $fields );
        
        

        Session::flash('success', "User has been added successfully.");
        return Redirect::to(route('admin.user.index'));
    }


    public
    function edit($id)
    {
        $page_title = 'Edit User';
        $user_types = [
            'tele_caller','amc_user','technician','normal_user'
        ];
        $data = User::select('*')->where('id',$id)->first();
        
        return view('admin.user.user_edit', [
            'page_title' => $page_title,
            'user_types' =>$user_types,
            'data' => $data,
        ]);
        
    }

    public
    function update(Request $request, $id)
    {
        
        //dd($request->all());
        $user = User::find($id);
        $fields = $request->validate(
            [
                'name' => 'required',
                'password' => 'nullable|min:6',
                'mobile' => 'required|digits:10',
                'email' => 'nullable|email|unique:users,email,'.$id,
                'username' => 'required|unique:users,username,'.$id, 
                'address' => 'nullable',
            ],
            [

                
            ]
        );

        if(!empty($request->password)) {
            $fields['password'] = Hash::make($request->password);
        }
        $fields['user_type'] = $request->user_type;
        
        $user->update($fields);
        //dd($user);
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

        
        $user->delete();

        

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
