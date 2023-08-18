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

use App\Models\{Page,Notification, User, Message};
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

class PageController extends Controller
{

   
    public function index(Request $request)
    {
        
        $page_title = 'Page Management';
        //dd($page_title);

        if ($request->ajax()) {
            $pages = Page::select('*');

           return Datatables::of($pages)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->addColumn('action', function ($row) {

                        $btn = '<a class="btn btn-small btn-info btn-sm"
                        href="' . route("admin.page.edit", ["id" => $row->id]) . '"><i class="fas fa-pencil-alt"></i></a>';


                        $btn .= '<button onclick="delete_row(' . $row->id . ')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>';
                         return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

            
        }

        // load the view and pass the user
        return view('admin.pages.index', [
            'page_title' => $page_title,
        ]);
    }

   
   
    public
    function add()
    {
        $page_title = 'Add Page';
        return view('admin.pages.create', [
            'page_title' => $page_title,
         ]);
    }

    public
    function save(Request $request)
    {
        $fields = $request->validate(
            [ 'page_name' => 'required',
            ],
            [
                //"category_name.required" => "This field is required",
            ]
        );

        Page::create( $fields );

        Session::flash('success', "Page has been added successfully.");
        return Redirect::to(route('admin.page.index'));
    }

    public
    function edit($id)
    {
        $page_title = 'Edit Page';
        $data = Page::select('*')->where('id',$id)->first();
        
        return view('admin.pages.edit', [
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
        $page = Page::find($id);
        $fields = $request->validate(
            [
                //'account_type_id' => 'required',
                'page_name' => 'required',
                'page_heading' => 'nullable',
                'page_content' => 'nullable',
            ],
            [
                //"category_name.required" => "This field is required",
            ]
        );

        $page->update( $fields );

        Session::flash('success', "Page has been updated successfully.");
        return Redirect::to(route('admin.page.index'));
    }

    public
    function destroy(Request $request)
    {

        //$user=$request->user();
        $id = $request->id;
        // delete
        //$user = User::where(['user_id'=>$user->id])->get();

        $model = Page::find($id);
        $model->delete();

        echo json_encode([
            'status' => 'success'
        ]);
        die;

    }

    

}
