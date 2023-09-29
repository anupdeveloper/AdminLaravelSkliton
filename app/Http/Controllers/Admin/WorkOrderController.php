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

use App\Models\{Status,Notification, User, Message, TechnicianAssignSlot, SlotSetting};
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Helper\Helper;
use App\Models\{Product,Category,ProductGallery,Lead,LeadAssignment};
use App\Models\{WorkOrder, Ticket};
use Yajra\DataTables\Facades\DataTables;
use App\Traits\Base64FileTrait;
//use Auth;


//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use PhpOffice\PhpSpreadsheet\Writer\Xls;

class WorkOrderController extends Controller
{

    use  Base64FileTrait;
   
    public function index(Request $request,$wo_type = null)
    {
        //dd($wo_type);
        $page_title = 'Workorder Management';
        //dd($page_title);

        $technicians = User::where('user_type','technician')->where('status','active')->get();

        // load the view and pass the user
        return view('admin.workorder.index', [
            'page_title' => $page_title,
            'technicians' => $technicians,
            'wo_type' => $wo_type
        ]);
    }

    public function getdata(Request $request,$wo_type = null)
    {
        //dd($wo_type);
        if ($request->ajax()) {
            $data = WorkOrder::select(['work_order.*','users.username'])
            ->with('ticket_detail','customer_detail','technician_detail','technician_assign_detail')
            ->join('users','users.id','work_order.technician_id');
            if(!empty($wo_type)) {
                if($wo_type == 'not-resolved') {
                    $data = $data->where('work_order.status','Not Resolved');
                } 
            } else {
                $data = $data->where('work_order.status','!=','Not Resolved');
            }
            
            $data = $data->latest();
            //dd($data);

           return Datatables::of($data)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->addColumn('work_order_detail', function ($row) {
                        if($row->ticket_detail) 
                        return '<p>'.$row->work_order_no.'</p> <p>'.$row->ticket_detail->ticket_no.'</p>';
                        else
                        return '<p>'.$row->work_order_no.'</p>';
                    })
                    
                    ->addColumn('contact_detail', function ($row) {
                        
                        return 'Techinician Detail: <p>'.$row->technician_detail->username.' ['.$row->technician_detail->mobile.']</p> / Customer Detail: <p>'.$row->customer_detail->username.'  ['.$row->customer_detail->mobile.']</p>';
                        
                        
                    })
                    ->editColumn('technician_id', function ($row) {
                        return $row->username;
                    })
                    ->editColumn('status', function ($row) {
                        return '<p>Status: <span class="badge badge-info">'.$row->status.'</span></p><p>Slot Time: '.$row->technician_assign_detail->slot_detail->slot_time.'</p>';
                    })
                    ->addColumn('datetime',  function ($row) {
                        $datetime = '<p><small>Created At: '.date('d-m-Y',strtotime($row->created_at)).'</small></p>';

                        $datetime .= '<p><small>Updated At: '.date('d-m-Y',strtotime($row->updated_at)).'</small></p>';
                        return $datetime; 
                    })
                    ->addColumn('action', function ($row) {

                        $btn = '<a class="btn btn-small btn-info btn-sm"
                        href="' . route("admin.workorder.edit", ["id" => $row->id]) . '"><i class="fas fa-pencil-alt"></i></a>';


                        $btn .= '<button onclick="delete_row(' . $row->id . ')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>';
                         return $btn;
                    })
                    ->rawColumns(['action','status','datetime','work_order_detail','contact_detail'])
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
                LeadAssignment::create(
                    [
                        'lead_id' => $lead,
                        'user_id' => $request->tele_caller,
                        'assign_date' => date('Y-m-d')
                    ]
                );
            }
        }
        echo json_encode([
            'status' => 'success'
        ]);
        die;
    }


    
    public
    function add_work_order(Request $request)
    {
        $page_title = 'Add Workorder';
        $id = $request->id;
        //dd($id);

        $categories = Category::all();
        $status = Status::all();
        $technicians = User::where('user_type','technician')->get();
        $tickets = Ticket::where('status',1)->get();
        $customers = User::whereIn('user_type',['user','amc_user','normal_user'])->get();
        //$statuses = Helper::get_statuses();
        return view('admin.workorder.assign_work_order', [
            'page_title' => $page_title,
            'categories' =>$categories,
            'tickets' =>$tickets,
            'technicians' =>$technicians,
            'statuses' =>$status,
            'customers' =>$customers,
            'selected_ticket' =>  $id
         ]);
    }
   
    public
    function add(Request $request,$id)
    {
        $page_title = 'Add Workorder';
       
        $categories = Category::all();
        $technicians = User::where('user_type','technician')->get();
        $customers = User::whereIn('user_type',['user','amc_user','normal_user'])->get();
        //dd($customers);
        $tickets = Ticket::where('status',1)->get();
        $statuses = Helper::get_statuses();
        return view('admin.workorder.create', [
            'page_title' => $page_title,
            'categories' =>$categories,
            'tickets' =>$tickets,
            'technicians' =>$technicians,
            'customers' =>$customers,
            'statuses' =>$statuses
         ]);
    }

    public
    function save(Request $request)
    {

        $fields = $request->validate(
            [ 
                'work_order_type' => 'required',
                'user_id' => 'required',
                'ticket_id' => 'nullable',
                'status' => 'required',
                'slot_id' => 'required',
                'category' => 'required',
                'title' => 'required',
                'technician_id' => 'required',
                'description' => 'required',
            ],
            [
                
            ]
        );
        //dd($request->all());

        try{
            $fields['user_id'] = $request->user_id;
            $fields['status'] = $request->status;
            //dd($fields);
            $model = WorkOrder::create( $fields );
            //dd($model);
            Ticket::where('id',$request->ticket_id)->update(
                [
                    'status' => 2
                ]
            );
            $pre_fix = $request->work_order_type === 'complaint' ? 'C' : 'N';
            $work_order_no = $pre_fix.date('Ymd').$model->id;
            $model->update(['work_order_no'=>$work_order_no]);
            // Save Slot
            $slot_data = [
                'user_id' => $request->technician_id,
                'slot_id' => $request->slot_id,
                'status' => $request->status,
                'work_order_id' => $model->id,
                'date' => date('Y-m-d')
            ]; 
            TechnicianAssignSlot::create($slot_data);
            //dd($fields);
        } catch (customException $e)
        {
            Session::flash('success', "Workorder can't be created..");
            return Redirect::to(route('admin.workorder.index'));
        }
        
        
        

        Session::flash('success', "Workorder has been added successfully.");
        return Redirect::to(route('admin.workorder.index'));
    }

    

    public
    function edit($id)
    {
        $page_title = 'Edit Workorder';
        $categories = Category::all();
        $status = Status::all();
        $technicians = User::where('user_type','technician')->get();
        $tickets = Ticket::where('status',1)->get();
        $customers = User::whereIn('user_type',['user','amc_user','normal_user'])->get();
        $data = WorkOrder::select('*')->with('technician_detail','technician_assign_detail')->where('id',$id)->first();
        //dd($data);
        
        return view('admin.workorder.edit_work_order', [
            'page_title' => $page_title,
            'categories' =>$categories,
            'tickets' =>$tickets,
            'technicians' =>$technicians,
            'statuses' =>$status,
            'customers' =>$customers,
            'data' => $data,
        ]);
    }

    public
    function update(Request $request, $id)
    {
        //$user=$request->user();
        //$user = User::where(['user_id'=>$user->id,'id'=>$id])->first();
        //dd($request->all());
        $model = WorkOrder::find($id);
        $fields = $request->validate(
            [ 
                'work_order_type' => 'required',
                'ticket_id' => 'nullable',
                'category' => 'nullable',
                'title' => 'required',
                'technician_id' => 'required',
                'description' => 'nullable',
            ],
            [
               // "category_id.required" => "This field is required",
            ]
        );
        if(!empty($request->ticket_id)) {
            Ticket::where('id',$request->ticket_id)->update(
                [
                    'status' => 2
                ]
            );
        }
        
        // Save Slot
        $slot_data = [
            'user_id' => $request->technician_id,
            'slot_id' => $request->slot_id,
            'status' => $request->status,
            'work_order_id' => $model->id,
            'date' => date('Y-m-d')
        ]; 
        TechnicianAssignSlot::where('work_order_id',$model->id)->update($slot_data);
        $fields['user_id'] = $request->user_id;
        $fields['status'] = $request->status;
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

        Session::flash('success', "Workorder has been updated successfully.");
        return Redirect::to(route('admin.workorder.index'));
    }

    public
    function destroy(Request $request)
    {

        //$user=$request->user();
        $id = $request->id;
        // delete
        //$user = User::where(['user_id'=>$user->id])->get();

        $model = WorkOrder::find($id);
        $model->delete();
        $slot_assign = TechnicianAssignSlot::where('work_order_id',$id)->first();
        $slot_assign->delete();
        echo json_encode([
            'status' => 'success'
        ]);
        die;

    }

    public function getUserslots(Request $request)
    {
        //dd($request->all());
        $user_id = $request->technician_id;
        $slots = SlotSetting::get();
    
        $slots_list = '<ul class="slots">';
        if($slots){
            foreach($slots as $row) {
                $is_slot_booked = Helper::is_slot_booked($row->id, $user_id);
                $row->is_slot_booked = $is_slot_booked > 0 ? true : false; 
                $booked_class =  $is_slot_booked > 0 ? 'booked' : 'avaliable';
                if($is_slot_booked == 0) {
                    $slots_list .= '<li class="'.$booked_class.'">'.$row->slot_name.'('.$row->slot_time.') Avaliable</li>';
                } else {
                    $slots_list .= '<li class="'.$booked_class.'">'.$row->slot_name.'('.$row->slot_time.') Booked</li>';
                }
                
            }
        }
        $slots_list .= '</ul>';
        return json_encode([
            'res' => $slots,
            'list' => $slots_list
        ]);

    }

}
