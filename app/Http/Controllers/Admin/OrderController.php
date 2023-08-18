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
use App\Models\{Order,Category,OrderDetail,Product,ProductGallery};
//use DB;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\Base64FileTrait;
//use Auth;

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use PhpOffice\PhpSpreadsheet\Writer\Xls;

class OrderController extends Controller
{

    use  Base64FileTrait;
   
    public function index(Request $request)
    {
        
        $page_title = 'Order Management';
        //dd($page_title);

        if ($request->ajax()) {
            $data = Order::select('orders.*','users.name','users.mobile')
                        ->with('order_detail')
                        ->leftJoin('users', 'users.id', 'orders.user_id')
                        //->orderByRaw('orders.order_status = "pending" desc , orders.order_status = "dispatch"')
                        ->latest();

            //dd($data->get());

           return Datatables::of($data)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->editColumn('created_at', function ($row) {
                        return date('d-m-Y',strtotime($row->created_at));
                    })
                    ->addColumn('order_id', function ($row) {
                        return '<a href="'.route("admin.order.view", ["id" => $row->id]).'">'.$row->order_id.'</a>';
                    })
                    ->addColumn('order_status', function ($row) {
                        if($row->order_status == 'pending') {
                            $badge = '<span class="badge badge-info">'.$row->order_status.'</span>';
                            return $badge;
                        } else if($row->order_status == 'dispatch') {
                            $badge = '<span class="badge badge-success">'.$row->order_status.'</span>';
                            return $badge;
                        } else if($row->order_status == 'denied') {
                            $badge = '<span class="badge badge-danger">'.$row->order_status.'</span>';
                            return $badge;
                        } else if($row->order_status == 'completed') {
                            $badge = '<span class="badge badge-success">'.$row->order_status.'</span>';
                            return $badge;
                        }
                        
                    })
                    ->addColumn('action', function ($row) {

                        $btn = '<a class="btn btn-small btn-info btn-sm"
                        href="' . route("admin.order.edit", ["id" => $row->id]) . '"><i class="fas fa-pencil-alt"></i></a>';


                        $btn .= '<button onclick="delete_row(' . $row->id . ')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>';
                         return $btn;
                    })
                    ->rawColumns(['order_id','order_status','action'])
                    ->make(true);

            
        }

        // load the view and pass the user
        return view('admin.order.index', [
            'page_title' => $page_title,
        ]);
    }

   
   
    public
    function add()
    {
        $page_title = 'Add product';
        $categories = Category::all();
        return view('admin.product.create', [
            'page_title' => $page_title,
            'categories' =>$categories
         ]);
    }

    public
    function save(Request $request)
    {
        $fields = $request->validate(
            [ 
                'category_id' => 'required',
                'product_name' => 'required',
                'actual_price' => 'required',
                'sale_price' => 'nullable',
            ],
            [
                "category_id.required" => "This field is required",
            ]
        );

        
        

        //dd($request->all());
        $product = Product::create( $fields );
        if($product) {
            //dd($product->id);
            if(isset($request->image)) {
                foreach($request->image as $img) {
                    $path = $this->_normalFileUpload($img,'/product');
                    ProductGallery::create(
                        [
                            'product_id' => $product->id,
                            'image' => $path
                        ]
                    );
                }
            }

        }
        

        Session::flash('success', "Product has been added successfully.");
        return Redirect::to(route('admin.product.index'));
    }


    public function view(Request $request,$id)
    {
        $page_title = 'Order Detail';
        $categories = Category::all();
        $data = Order::select('orders.*','users.name','users.mobile','users.address')
                        ->with('order_detail')
                        ->leftJoin('users', 'users.id', 'orders.user_id')
                        ->where('orders.id',$id)->first();
        
        
        // load the view and pass the user
        return view('admin.order.view', [
            'page_title' => $page_title,
            'id'=>$id,
            'categories' =>$categories,
            'data' => $data,
        ]);
    }

    public
    function edit($id)
    {
        $page_title = 'Edit Order';
        $categories = Category::all();
        $data = Order::select('orders.*','users.name','users.mobile','users.address')
                        ->with('order_detail')
                        ->leftJoin('users', 'users.id', 'orders.user_id')
                        ->where('orders.id',$id)->first();
        
        return view('admin.order.edit', [
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
        //dd($request->all());
        $model = Order::find($id);
        $fields = $request->validate(
            [ 
                'order_status' => 'required',
            ],
            [
               
            ]
        );

        $model->update( $fields );
        //dd( $request->all() );

        

        Session::flash('success', "Order has been updated successfully.");
        return Redirect::to(route('admin.order.index'));
    }

    public
    function destroy(Request $request)
    {

        //$user=$request->user();
        $id = $request->id;
        // delete
        //$user = User::where(['user_id'=>$user->id])->get();

        $model = Order::find($id);
        $model->delete();

        echo json_encode([
            'status' => 'success'
        ]);
        die;

    }

    

}
