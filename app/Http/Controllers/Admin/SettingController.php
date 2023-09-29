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
use App\Models\{WorkOrder, Ticket, SlotSetting};
use Yajra\DataTables\Facades\DataTables;
use App\Traits\Base64FileTrait;
use App\Traits\GeneralTrait;
//use Auth;


//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use PhpOffice\PhpSpreadsheet\Writer\Xls;

class SettingController extends Controller
{

    use  Base64FileTrait, GeneralTrait;
   
    public function index(Request $request)
    {
        
        $page_title = 'Setting Management';
        //dd($page_title);

        $slots = SlotSetting::all();

        // load the view and pass the user
        return view('admin.setting.index', [
            'page_title' => $page_title,
            'slots' => $slots
        ]);
    }

    public function getdata(Request $request)
    {
        if ($request->ajax()) {
            $data = SlotSetting::all();
            //dd($data);

           return Datatables::of($data)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->addColumn('action', function ($row) {

                        $btn = '<a class="btn btn-small btn-info btn-sm"
                        href="' . route("admin.setting.edit", ["id" => $row->id]) . '"><i class="fas fa-pencil-alt"></i></a>';


                        $btn .= '<button onclick="delete_row(' . $row->id . ')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>';
                         return $btn;
                    })
                    ->rawColumns(['action'])
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
        $page_title = 'Add Slot';
       
        return view('admin.setting.create', [
            'page_title' => $page_title,
         ]);
    }

    public
    function save(Request $request)
    {

        $fields = $request->validate(
            [ 
                'slot_name' => 'required',
                'slot_time' => 'required',
            ],
            [
                
            ]
        );
        //dd(Auth::user()->id);

        try{
            //$fields['ticket_no'] = $this->__getUniqueNo('tickets','id');
            
            $model = SlotSetting::create( $fields );
           
            //dd($fields);
        } catch (customException $e)
        {
            Session::flash('success', "Slot can't be created..");
            return Redirect::to(route('admin.setting.index'));
        }
        
        
        

        Session::flash('success', "Slot has been added successfully.");
        return Redirect::to(route('admin.setting.index'));
    }

    

    public
    function edit($id)
    {
        $page_title = 'Edit Slot';
        
        $data = SlotSetting::select('*')->where('id',$id)->first();
        
        return view('admin.setting.edit', [
            'page_title' => $page_title,
            'data' => $data,
        ]);
    }

    public
    function update(Request $request, $id)
    {
        //$user=$request->user();
        //$user = User::where(['user_id'=>$user->id,'id'=>$id])->first();
        // dd($request->all());
        $model = SlotSetting::find($id);
        $fields = $request->validate(
            [ 
                'slot_name' => 'required',
                'slot_time' => 'required',
               
            ],
            [
                //"category_id.required" => "This field is required",
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

        Session::flash('success', "Slot has been updated successfully.");
        return Redirect::to(route('admin.setting.index'));
    }

    public
    function destroy(Request $request)
    {

        //$user=$request->user();
        $id = $request->id;
        // delete
        //$user = User::where(['user_id'=>$user->id])->get();

        $model = SlotSetting::find($id);
        $model->delete();

        echo json_encode([
            'status' => 'success'
        ]);
        die;

    }

    

}
