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
use App\Models\{Category};
//use DB;
use Yajra\DataTables\Facades\DataTables;

//use Auth;

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use PhpOffice\PhpSpreadsheet\Writer\Xls;

class CategoryController extends Controller
{

   
    public function index(Request $request)
    {
        
        $page_title = 'Category Management';
        //dd($page_title);

        if ($request->ajax()) {
            $categories = Category::select('*');

           return Datatables::of($categories)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->addColumn('action', function ($row) {

                        $btn = '<a class="btn btn-small btn-info btn-sm"
                        href="' . route("admin.category.edit", ["id" => $row->id]) . '"><i class="fas fa-pencil-alt"></i></a>';


                        $btn .= '<button onclick="delete_row(' . $row->id . ')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>';
                         return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

            
        }

        // load the view and pass the user
        return view('admin.category.index', [
            'page_title' => $page_title,
        ]);
    }

   
   
    public
    function add()
    {
        $page_title = 'Add Category';
        return view('admin.category.create', [
            'page_title' => $page_title,
         ]);
    }

    public
    function save(Request $request)
    {
        $fields = $request->validate(
            [ 'category_name' => 'required',
            ],
            [
                "category_name.required" => "This field is required",
            ]
        );

        Category::create( $fields );

        Session::flash('success', "Category has been added successfully.");
        return Redirect::to(route('admin.category.index'));
    }

    public
    function edit($id)
    {
        $page_title = 'Edit Category';
        $data = Category::select('*')->where('id',$id)->first();
        
        return view('admin.category.edit', [
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
        $category = Category::find($id);
        $fields = $request->validate(
            [
                //'account_type_id' => 'required',
                'category_name' => 'required',
            ],
            [
                "category_name.required" => "This field is required",
            ]
        );

        $category->update( $fields );

        Session::flash('success', "Category has been updated successfully.");
        return Redirect::to(route('admin.category.index'));
    }

    public
    function destroy(Request $request)
    {

        //$user=$request->user();
        $id = $request->id;
        // delete
        //$user = User::where(['user_id'=>$user->id])->get();

        $model = Category::find($id);
        $model->delete();

        echo json_encode([
            'status' => 'success'
        ]);
        die;

    }

    

}
