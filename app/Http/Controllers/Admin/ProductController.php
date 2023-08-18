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
use App\Models\{Product,Category,ProductGallery};
//use DB;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\Base64FileTrait;
//use Auth;

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ProductController extends Controller
{

    use  Base64FileTrait;
   
    public function index(Request $request)
    {
        
        $page_title = 'Product Management';
        //dd($page_title);

        if ($request->ajax()) {
            $data = Product::select('products.*','category.category_name')
                        ->leftJoin('category', 'category.id', '=', 'products.category_id')
                        ->with('product_images')
                        ->orderBy('products.id','desc');
            //dd($data->get());

           return Datatables::of($data)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->addColumn('product_image',function ($row) {
                        return count($row->product_images) > 0 ? '<img width="40" src="'.asset($row->product_images[0]->thumbimage).'" />' : '--';
                    })
                    ->addColumn('action', function ($row) {

                        $btn = '<a class="btn btn-small btn-info btn-sm"
                        href="' . route("admin.product.edit", ["id" => $row->id]) . '"><i class="fas fa-pencil-alt"></i></a>';


                        $btn .= '<button onclick="delete_row(' . $row->id . ')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>';
                         return $btn;
                    })
                    ->rawColumns(['product_image','action'])
                    ->make(true);

            
        }

        // load the view and pass the user
        return view('admin.product.index', [
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
                'product_desc' => 'nullable',
                'no_of_service' => 'nullable',
                'price_per_service' => 'nullable',
            ],
            [
                "category_id.required" => "This field is required",
            ]
        );

        
        

        //dd($request->all());
        $product = Product::create( $fields );
        if($product) {
            //dd($product->id);
            /*
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
            */
            
                
                if(isset($request->image1)) {
                    $path = $this->_normalFileUpload($request->image1,'/product',[723,747]);
                    $thumbpath = $this->_normalFileUpload($request->image1,'/product/thumbnail',[100,100]);
                    ProductGallery::create(
                        [
                            'product_id' => $product->id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                }
                if(isset($request->image2)) {
                    $path = $this->_normalFileUpload($request->image2,'/product',[723,747]);
                    $thumbpath = $this->_normalFileUpload($request->image2,'/product/thumbnail',[100,100]);
                    ProductGallery::create(
                        [
                            'product_id' => $product->id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                }
                if(isset($request->image3)) {
                    $path = $this->_normalFileUpload($request->image3,'/product',[723,747]);
                    $thumbpath = $this->_normalFileUpload($request->image3,'/product/thumbnail',[100,100]);
                    ProductGallery::create(
                        [
                            'product_id' => $product->id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                }
                if(isset($request->image4)) {
                    $path = $this->_normalFileUpload($request->image4,'/product',[723,747]);
                    $thumbpath = $this->_normalFileUpload($request->image4,'/product/thumbnail',[100,100]);
                    ProductGallery::create(
                        [
                            'product_id' => $product->id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                }
                if(isset($request->image5)) {
                    $path = $this->_normalFileUpload($request->image5,'/product',[723,747]);
                    $thumbpath = $this->_normalFileUpload($request->image5,'/product/thumbnail',[100,100]);
                    ProductGallery::create(
                        [
                            'product_id' => $product->id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                }
            

        }
        

        Session::flash('success', "Product has been added successfully.");
        return Redirect::to(route('admin.product.index'));
    }

    public
    function edit($id)
    {
        $page_title = 'Edit Product';
        $categories = Category::all();
        $data = Product::select('*')->with('product_images')->where('id',$id)->first();
        
        return view('admin.product.edit', [
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
        $model = Product::find($id);
        $fields = $request->validate(
            [ 
                'category_id' => 'required',
                'product_name' => 'required',
                'actual_price' => 'required',
                'sale_price' => 'nullable',
                'product_desc' => 'nullable',
                'no_of_service' => 'nullable',
                'price_per_service' => 'nullable',
            ],
            [
                "category_id.required" => "This field is required",
            ]
        );

        $model->update( $fields );
        //dd( $request->all() );

        if($id) {
            //dd($product->id);
            ProductGallery::where('product_id',$id)->delete();
                /*
                foreach($request->image as $img) {
                    $path = $this->_normalFileUpload($img,'/product');
                    ProductGallery::create(
                        [
                            'product_id' => $model->id,
                            'image' => $path
                        ]
                    );
                }
                */
                
                if(isset($request->image1)) {
                    $path = $this->_normalFileUpload($request->image1,'/product',[723,747]);
                    $thumbpath = $this->_normalFileUpload($request->image1,'/product/thumbnail',[100,100]);
                    ProductGallery::create(
                        [
                            'product_id' => $id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                } else {
                    $path = $request->old_image1;
                    $thumbpath = $request->old_thumbimage1;
                    ProductGallery::create(
                        [
                            'product_id' => $id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                }
                if(isset($request->image2)) {
                    $path = $this->_normalFileUpload($request->image2,'/product',[723,747]);
                    $thumbpath = $this->_normalFileUpload($request->image2,'/product/thumbnail',[100,100]);
                    ProductGallery::create(
                        [
                            'product_id' => $id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                } else {
                    $path = $request->old_image2;
                    $thumbpath = $request->old_thumbimage2;
                    ProductGallery::create(
                        [
                            'product_id' => $id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                }
                if(isset($request->image3)) {
                    $path = $this->_normalFileUpload($request->image3,'/product',[723,747]);
                    $thumbpath = $this->_normalFileUpload($request->image3,'/product/thumbnail',[100,100]);
                    ProductGallery::create(
                        [
                            'product_id' => $id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                } else {
                    $path = $request->old_image3;
                    $thumbpath = $request->old_thumbimage3;
                    ProductGallery::create(
                        [
                            'product_id' => $id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                }
                if(isset($request->image4)) {
                    $path = $this->_normalFileUpload($request->image4,'/product',[723,747]);
                    $thumbpath = $this->_normalFileUpload($request->image4,'/product/thumbnail',[100,100]);
                    ProductGallery::create(
                        [
                            'product_id' => $id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                } else {
                    $path = $request->old_image4;
                    $thumbpath = $request->old_thumbimage4;
                    ProductGallery::create(
                        [
                            'product_id' => $id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                }
                if(isset($request->image5)) {
                    $path = $this->_normalFileUpload($request->image5,'/product',[723,747]);
                    $thumbpath = $this->_normalFileUpload($request->image5,'/product/thumbnail',[100,100]);
                    ProductGallery::create(
                        [
                            'product_id' => $id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                } else {
                    $path = $request->old_image5;
                    $thumbpath = $request->old_thumbimage5;
                    ProductGallery::create(
                        [
                            'product_id' => $id,
                            'image' => $path,
                            'thumbimage' => $thumbpath
                        ]
                    );
                }
            

        }

        Session::flash('success', "Product has been updated successfully.");
        return Redirect::to(route('admin.product.index'));
    }

    public
    function destroy(Request $request)
    {

        //$user=$request->user();
        $id = $request->id;
        // delete
        //$user = User::where(['user_id'=>$user->id])->get();

        $model = Product::find($id);
        $model->delete();

        echo json_encode([
            'status' => 'success'
        ]);
        die;

    }

    

}
