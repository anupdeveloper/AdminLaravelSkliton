<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\UserTrait;
use App\View\Components\DataView\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\{MasterRegion,User,Connection,UserPurchaseSubscription,EducationalContent,Country,MasterReligion,MasterCity,MasterTribe};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use DataTables;


class AdminController extends Controller
{
    use UserTrait;

    public function reset_password(Request $request){
        //dd(Auth::user()->id);

        return view('admin.user.reset_password');
    }

    public function save_reset_password(Request $request)
    {
        //dd($request->password);
        $user_id = Auth::user()->id;
        User::where('id',$user_id)->update(['password'=>Hash::make($request->password)]);
        Session::flash('success',  __('api.admin.Status.message.edit.success'));
        return Redirect::to(route('admin.resetpassword'));
    }

    public function dashboard(){
        //
        //return Redirect::to(route('admin.user.index'));
        return view('admin.dashboard');
    }

    

}
