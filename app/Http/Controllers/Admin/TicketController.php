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
use App\Models\{Product,Category,ProductGallery,Lead,LeadAssignment};
use App\Models\{WorkOrder, Ticket};
use Yajra\DataTables\Facades\DataTables;
use App\Traits\Base64FileTrait;
use App\Traits\GeneralTrait;
//use Auth;


//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use PhpOffice\PhpSpreadsheet\Writer\Xls;

class TicketController extends Controller
{

    use  Base64FileTrait, GeneralTrait;
   
    public function index(Request $request)
    {
        
        $page_title = 'Ticket Management';
        //dd($page_title);

        $technicians = User::where('user_type','technician')->where('status','active')->get();

        // load the view and pass the user
        return view('admin.ticket.index', [
            'page_title' => $page_title,
            'technicians' => $technicians
        ]);
    }

    public function getdata(Request $request)
    {
        if ($request->ajax()) {
            $data = Ticket::with('technician_detail','customer_detail')->latest();
            //dd($data->technician_detail);

           return Datatables::of($data)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->addColumn('customer_detail',function ($row) {
                        $customer_detail =  $row->customer_detail ? ''.$row->customer_detail->username.'/'.$row->customer_detail->mobile.'' : '<p>-</p>';
                        //$row->technician_detail->technician_detail->username;
                        $customer_detail .= '<p><span class="badge badge-info">'.strtoupper(str_replace('_',' ',$row->customer_detail->user_type)).'</span></p>';
                        
                        return $customer_detail;
                    })
                    ->addColumn('status', function ($row) {
                        switch ($row->status) {
                            case 1: 
                                $status = '<span class="badge badge-info">New</span>';
                                break;
                            case 2: 
                                $status = '<span class="badge badge-warning">Assigned</span>';
                                break;
                            case 3: 
                                $status = '<span class="badge badge-success">Completed</span>';
                                break;
                            default:
                                $status = '<span class="badge badge-info">New</span>';
                         }

                        $assigned_to =  $row->technician_detail ? '<p>/ '.$row->technician_detail->technician_detail->username.' ['.$row->technician_detail->technician_detail->mobile.']</p>' : '<p>-</p>';
                        //$row->technician_detail->technician_detail->username;
                        $status .= $assigned_to;
                        
                        return $status;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<div class="nowrap">';
                        if($row->status == 1) {
                            $btn .= '<a class="btn btn-small btn-info btn-sm"
                            href="' . route("admin.workorder.add_work_order", ["id" => $row->id]) . '">Assign Technician</a>';
                        }
                        

                        $btn .= '<button onclick="delete_row(' . $row->id . ')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>';

                        $btn .= '</div>';

                         return $btn;
                    })
                    ->rawColumns(['action','customer_detail','status'])
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
    function add()
    {
        $page_title = 'Add Ticket';
        $categories = Category::all();
        $technicians = User::where('user_type','technician')->get();
        $customers = User::whereIn('user_type',['user','amc_user','normal_user'])->get();
        $tickets = Ticket::where('status',1)->get();
        $statuses = Helper::get_statuses();
        return view('admin.ticket.create', [
            'page_title' => $page_title,
            'categories' =>$categories,
            'tickets' =>$tickets,
            'customers' =>$customers,
            'technicians' =>$technicians,
            'statuses' =>$statuses
         ]);
    }

    public
    function save(Request $request)
    {
        //dd($request->all());
        $fields = $request->validate(
            [ 
                //'category_id' => 'required',
                'user_id' => 'required',
                'category_id' => 'required',
                'title' => 'required',
                //'technician_id' => 'required',
                'description' => 'nullable',
            ],
            [
                
            ]
        );
        //dd(Auth::user()->id);

        try{
            //$fields['ticket_no'] = $this->__getUniqueNo('tickets','id');
            $fields['created_by'] = Auth::user()->id;
            $model = Ticket::create( $fields );
            //dd($model->id);
            $quniue_no = 'T'.date('Ymd').$model->id;
            $model->where('id',$model->id)->update(
                [
                    'ticket_no' => $quniue_no
                ]
            );
            //dd($fields);
        } catch (customException $e)
        {
            Session::flash('success', "Ticket can't be created..");
            return Redirect::to(route('admin.ticket.index'));
        }
        
        
        

        Session::flash('success', "Ticket has been added successfully.");
        return Redirect::to(route('admin.ticket.index'));
    }

    

    public
    function edit($id)
    {
        $page_title = 'Edit Ticket';
        $categories = Category::all();
        $technicians = User::where('user_type','technician')->get();
        $customers = User::whereIn('user_type',['user','amc_user','normal_user'])->get();
        $data = Ticket::where('id',$id)->first();
        $statuses = Helper::get_statuses();
        
        //dd($data);
        return view('admin.ticket.edit', [
            'page_title' => $page_title,
            'categories' =>$categories,
            'customers' =>$customers,
            'data' =>$data,
            'technicians' =>$technicians,
            'statuses' =>$statuses
        ]);
    }

    public
    function update(Request $request, $id)
    {
        //$user=$request->user();
        //$user = User::where(['user_id'=>$user->id,'id'=>$id])->first();
        //dd($request->all());
        $model = Ticket::find($id);
        $fields = $request->validate(
            [ 
                //'category_id' => 'required',
                'user_id' => 'required',
                'category_id' => 'required',
                'title' => 'required',
                //'technician_id' => 'required',
                'description' => 'nullable',
            ],
            [
                
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

        Session::flash('success', "Ticket has been updated successfully.");
        return Redirect::to(route('admin.ticket.index'));
    }

    public
    function destroy(Request $request)
    {

        //$user=$request->user();
        $id = $request->id;
        // delete
        //$user = User::where(['user_id'=>$user->id])->get();

        $model = Ticket::find($id);
        $model->delete();

        echo json_encode([
            'status' => 'success'
        ]);
        die;

    }

    

}
