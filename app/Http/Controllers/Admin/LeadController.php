<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Jobs\UserExportNotify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
//use Maatwebsite\Excel\Excel as ExcelClass;
use Rap2hpoutre\FastExcel\FastExcel;

use App\Models\{Notification, User, Message};
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Helper\Helper;
use App\Models\{Product,Category,ProductGallery,Lead,LeadAssignment};

use Yajra\DataTables\Facades\DataTables;
use App\Traits\Base64FileTrait;
//use Auth;
//use Excel;

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use PhpOffice\PhpSpreadsheet\Writer\Xls;

class LeadController extends Controller
{

    use  Base64FileTrait;
   
    public function index(Request $request)
    {
        
        $page_title = 'Lead Management';
        //dd($page_title);

        $tele_callers = User::where('user_type','tele_caller')->where('status','active')->get();

        // load the view and pass the user
        return view('admin.lead.index', [
            'page_title' => $page_title,
            'tele_callers' => $tele_callers
        ]);
    }
 
    public function getdata(Request $request,$type = null)
    {
        
        //dd($request->all());
        if ($request->ajax()) {
            //($request->lead_type);
            $data = Lead::with('lead_report','lead_assign_user_detail','lead_assignment');
            //->where('leads.id',15);
            //$data = $data->get();
            //dd($data);
            /*
            if (!empty($request->search)) {
                $search = $request->search['value'];
                //dd($search);
                $data = $data->where(
                        function($query) use ($search)  {
                            return $query
                            ->where('leads.name','like', '%'.$search.'%')
                            ->orWhere('leads.phone','like', '%'.$search.'%')
                            ->orWhere('users.mobile','like', '%'.$search.'%')
                            ->orWhere('users.username','like', '%'.$search.'%')
                            ->orWhere('leads.address','like', '%'.$search.'%')
                            ->orWhere('leads.email','like', '%'.$search.'%');
                        }
                    );
            }
            */
            
            if (!empty($request->filter)) {
                $tele_caller = $request->tele_caller;
                if(isset($tele_caller)) {
                    $data = $data->where('leads.assigned_to',$tele_caller);
                }
                if(isset($request->chimney_status)) {
                    $chimney_status = $request->chimney_status;
                    //dd($has_chimney);
                    $data = $data->whereHas('lead_report',
                        function($query) use ($chimney_status)  {
                            return $query
                            ->where('lead_report.chimney_status',$chimney_status);
                        }
                    );
                }
                if(isset($request->waterpurifier_status)) {
                    $waterpurifier_status = $request->waterpurifier_status;
                    //dd($waterpurifier_status);
                    $data = $data->whereHas('lead_report',
                        function($query) use ($waterpurifier_status)  {
                            return $query
                            ->where('lead_report.waterpurifier_status',$waterpurifier_status);
                        }
                    );
                }

                /*
                if(isset($request->has_water_purifier)) {
                    $has_water_purifier = $request->has_water_purifier == 'yes' ? 'true' : 'false';
                    //dd($has_chimney);
                    $data = $data->whereHas('lead_report',
                        function($query) use ($has_water_purifier)  {
                            return $query
                            ->where('lead_report.has_water_purifier',$has_water_purifier);
                        }
                    );
                }
                if(isset($request->in_use_waterpurifier)) {
                    $in_use_waterpurifier = $request->in_use_waterpurifier == 'yes' ? 'true' : 'false';
                    //dd($has_chimney);
                    $data = $data->whereHas('lead_report',
                        function($query) use ($in_use_waterpurifier)  {
                            return $query
                            ->where('lead_report.in_use_water_purifier',$in_use_waterpurifier);
                        }
                    );
                }
                */
            }

            $data->when(request('lead_type') == 'new', function ($q) {
                return $q->whereNull('leads.assigned_to');
            });

            //dd(request('lead_type'));
            $data->when(request('lead_type') == 'followup', function ($q) {
                $product_type = request('product_type');
                $q->whereNotNull('leads.assigned_to');
                $q = $q->whereHas('lead_report',
                        function($query) use ($product_type)  {
                            return $query
                            ->where('lead_report.product_type',1);
                        }
                    );
                return $q;
            });

            
            //Helper::getQueryString( $data );

            //->orderBy('leads.id','desc')
            $data = $data->latest();
            //dd($data);



           return Datatables::of($data)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->addColumn('select_ck_box', function ($row) {
                        return $row->is_assigned == -3 ? '<input type="checkbox" disabled  class="lead-ckbox assigned" id="lead-ckbox-'.$row->id.'" onchange="assign_lead('.$row->id.')" value="'.$row->id.'" name="sel_leads[]" />' : '<input type="checkbox" class="lead-ckbox not-assigned" id="lead-ckbox-'.$row->id.'"onchange="assign_lead('.$row->id.')" value="'.$row->id.'" name="sel_leads[]" />';
                    })
                    ->addColumn('name', function ($row) {
                        return '<p>'.$row->name.'</p>';
                    })
                    ->addColumn('assigned_to', function ($row) {
                        if($row->lead_assign_user_detail) {
                            return '<p>'.$row->lead_assign_user_detail->username.'</p>';
                        }
                        
                    })
                   
                   
                    ->addColumn('address', function ($row) {
                        return $row->address;
                    })
                    ->addColumn('waterpurifier_status', function ($row) {
                        if(isset($row->lead_report))
                        return '<p>'.$row->lead_report->waterpurifier_status.'</p>';
                        else
                        return '--';
                    })
                    ->addColumn('chimney_status', function ($row) {
                        if(isset($row->lead_report->chimney_status))
                        return '<p>'.$row->lead_report->chimney_status.'</p>';
                        else
                        return '--';
                        
                    })
                    ->addColumn('status', function ($row) {
                        return '<p>'.$row->status.'</p>';
                    })
                    ->addColumn('feedback', function ($row) {
                        if(isset($row->lead_assignment)) {
                            return '<p> '.$row->lead_assignment->comment.'</p>';
                        }
                        
                    })
                    ->addColumn('datetime', function ($row) {
                        return '<p>'.date('d-m-Y',strtotime($row->created_at)).'</p></p>'. !empty($row->updated_at) ? date('d-m-Y',strtotime($row->updated_at)) : 'Not updated yet'.'</p>';;
                    })
                    ->addColumn('action', function ($row) {

                        $btn = '<a class="btn btn-small btn-info btn-sm"
                        href="' . route("admin.lead.edit", ["id" => $row->id]) . '"><i class="fas fa-pencil-alt"></i></a>';


                        $btn .= '<button onclick="delete_row(' . $row->id . ')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>'; 
                         return $btn;
                    })
                    ->rawColumns(['select_ck_box','waterpurifier_status','chimney_status','feedback','status','datetime','assigned_to','name','address','action'])
                    ->make(true);

            
        }
    }

    public function filter(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $data = Lead::select(['leads.*','users.username','users.mobile',DB::raw('(SELECT COUNT(*) FROM lead_assignment WHERE lead_assignment.lead_id = leads.id) as is_assigned'),'lead_assignment.status','lead_assignment.assign_date','lead_assignment.comment'])
            ->with('lead_report')
            ->leftJoin('lead_assignment','lead_assignment.lead_id','leads.id')
            ->leftJoin('users','users.id','lead_assignment.user_id');

            

            
            if (!empty($request->filter)) {
                $tele_caller = $request->tele_caller;
                $data = $data->where(
                        function($query) use ($tele_caller)  {
                            return $query
                            ->where('lead_assignment.user_id',$tele_caller );
                        }
                    );
            }
            
            //->orderBy('leads.id','desc')
            $data = $data->latest();
            //dd($data);

           return Datatables::of($data)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->addColumn('select_ck_box', function ($row) {
                        return $row->is_assigned == -3 ? '<input type="checkbox" disabled  class="lead-ckbox assigned" id="lead-ckbox-'.$row->id.'" onchange="assign_lead('.$row->id.')" value="'.$row->id.'" name="sel_leads[]" />' : '<input type="checkbox" class="lead-ckbox not-assigned" id="lead-ckbox-'.$row->id.'"onchange="assign_lead('.$row->id.')" value="'.$row->id.'" name="sel_leads[]" />';
                    })
                    ->addColumn('name', function ($row) {
                        return '<p>'.$row->name.' / '.$row->phone.'</p>'.'<p>'.$row->email.'</p>';
                    })
                    ->addColumn('waterpurifier_status', function ($row) {
                        return '<p>'.$row->lead_report->waterpurifier_status.'</p>';
                    })
                    ->addColumn('chimney_status', function ($row) {
                        return '<p>'.$row->lead_report->chimney_status.'</p>';
                    })
                    ->addColumn('assigned_to', function ($row) {
                        return '<p>'.$row->username.'</p></p>'.$row->mobile.'</p>';
                    })
                    ->addColumn('address', function ($row) {
                        return $row->address;
                    })
                    ->addColumn('status', function ($row) {
                        return '<p>'.$row->status.'</p></p>'.$row->assign_date.'</p>';
                    })
                    ->addColumn('feedback', function ($row) {
                        return '<p> '.$row->lead_report->comment.'</p>';
                    })
                    ->addColumn('datetime', function ($row) {
                        return '<p>'.date('d-m-Y',strtotime($row->created_at)).'</p></p>'. !empty($row->updated_at) ? date('d-m-Y',strtotime($row->updated_at)) : 'Not updated yet'.'</p>';;
                    })
                    ->addColumn('action', function ($row) {

                        $btn = '<a class="btn btn-small btn-info btn-sm"
                        href="' . route("admin.lead.edit", ["id" => $row->id]) . '"><i class="fas fa-pencil-alt"></i></a>';


                        $btn .= '<button onclick="delete_row(' . $row->id . ')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>';
                         return $btn;
                    })
                    ->rawColumns(['select_ck_box','chimney_status','waterpurifier_status','feedback','status','datetime','assigned_to','name','address','action'])
                    ->make(true);

            
        }
    }

    public function assignleads(Request $request)
    {
        $request->validate(
            [ 
              'tele_caller' => 'required',

            ],
            [
                
            ]
        );
        $leads_selected = !empty($request->leads_selected) ? explode(',',$request->leads_selected) : [];
        if(count($leads_selected)) {
            foreach($leads_selected as $lead) {

                
                Lead::where('id',$lead)->update(
                    [
                        'assigned_to' => $request->tele_caller,
                        'assign_date' => date('Y-m-d'),
                    ]
                );
                LeadAssignment::create(
                    [
                        'lead_id' => $lead,
                        'user_id' => $request->tele_caller,
                        'assign_date' => date('Y-m-d'),
                        'status'=>'Assigned'
                    ]
                );
            }
        }
        echo json_encode([
            'status' => 'success'
        ]);
        die;
    }
   
    public function lead_import(Request $request)
    {
        $path1 = $request->leads->store('temp'); 
        $path= storage_path('app').'/'.$path1;  
        //dd($path);
        Lead::import_data($path);
        Session::flash('success', "Leads has been added successfully.");
        return Redirect::to(route('admin.lead.index'));
        /*
        $path = $request->leads;
        Lead::import_data($path->getRealPath());
        Session::flash('success', "Leads has been added successfully.");
        return Redirect::to(route('admin.lead.index'));
        */
    }

    public
    function add()
    {
        $page_title = 'Add Lead';
        $categories = Category::all();
        return view('admin.lead.create', [
            'page_title' => $page_title,
            'categories' =>$categories
         ]);
    }

    public
    function save(Request $request)
    {
        $fields = $request->validate(
            [ 
                //'category_id' => 'required',
                'name' => 'required',
                'phone' => 'required|digits:10',
                'email' => 'nullable|email',
                'address' => 'nullable',
            ],
            [
                "category_id.required" => "This field is required",
            ]
        );

        
        

        //dd($request->all());
        $model = Lead::create( $fields );
        
        

        Session::flash('success', "Lead has been added successfully.");
        return Redirect::to(route('admin.lead.index'));
    }

    

    public
    function edit($id)
    {
        $page_title = 'Edit Lead';
        $categories = Category::all();
        $data = Lead::select('*')->where('id',$id)->first();
        
        return view('admin.lead.edit', [
            'page_title' => $page_title,
            'categories' =>$categories,
            'data' => $data,
        ]);
    }

    public
    function update(Request $request, $id)
    {
        //$user=$request->user();
        //$user = User::where(['user_id'=>$user->id,'id'=>$id])->first();
        // dd($request->all());
        $model = Lead::find($id);
        $fields = $request->validate(
            [ 
                'name' => 'required',
                'phone' => 'required|digits:10',
                'email' => 'nullable|email',
                'address' => 'nullable',
            ],
            [
                "category_id.required" => "This field is required",
            ]
        );

        $model->update( $fields );
        //dd( $request->all() );

        // if($id) {
        //     //dd($product->id);

        //     if(isset($request->image)) {
        //         ProductGallery::where('product_id',$id)->delete();
        //         foreach($request->image as $img) {
        //             $path = $this->_normalFileUpload($img,'/product');
        //             ProductGallery::create(
        //                 [
        //                     'product_id' => $model->id,
        //                     'image' => $path
        //                 ]
        //             );
        //         }
        //     }

        // }

        Session::flash('success', "Lead has been updated successfully.");
        return Redirect::to(route('admin.lead.index'));
    }

    public
    function destroy(Request $request)
    {

        //$user=$request->user();
        $id = $request->id;
        // delete
        //$user = User::where(['user_id'=>$user->id])->get();

        $model = Lead::find($id);
        $model->delete();

        echo json_encode([
            'status' => 'success'
        ]);
        die;

    }

    

}
