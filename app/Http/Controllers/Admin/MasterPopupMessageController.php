<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterPopupMessage;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MasterPopupMessageController extends Controller
{




    public function index(Request $request)
    {
        //$user=$request->user();

        // get all the master_popup_message
        $master_popup_message = MasterPopupMessage::all();
        //$master_popup_message = MasterPopupMessage::where(['user_id'=>$user->id])->get();

        // load the view and pass the master_popup_message
        return view('admin.master_popup_message.master_popup_message_index', ['master_popup_message_list' => $master_popup_message]);
    }

    public function show(Request $request, $id)
    {
        //$user=$request->user();
        // get the master_popup_message
        //$master_popup_message = MasterPopupMessage::where(['user_id'=>$user->id,'id'=>$id])->first();

        $master_popup_message = MasterPopupMessage::find($id);

        // show the view and pass the master_popup_message to it
        return view('admin.master_popup_message.master_popup_message_show', ['master_popup_message' => $master_popup_message]);
    }

    public function create()
    {

        return view('admin.master_popup_message.master_popup_message_create');
    }

    public function store(Request $request)
    {
        //$user=$request->user();

        $fields = $request->validate(
            [
                'group_name' => 'required',
                'message_value_en' => 'required',
                'message_value_ar' => 'required',
            ],
            [
                "group_name.required" => __("admin_dashboard.admin.MasterPopupMessage.validation_msg.group_name.required"),
                "message_value_en.required" => __("admin_dashboard.admin.MasterPopupMessage.validation_msg.message_value_en.required"),
                "message_value_ar.required" => __("admin_dashboard.admin.MasterPopupMessage.validation_msg.message_value_ar.required"),

            ]
        );

        //if($files=$request->file('img')){

        //$fields['img']=$files->storePublicly('uploads','public');
        //}

        //$fields['user_id']=$user->id;

        $master_popup_message = MasterPopupMessage::create($fields);


        // redirect
        Session::flash('success', __('admin_dashboard.admin.MasterPopupMessage.message.add.success'));
        return Redirect::to(route('admin.master-popup-message.index'));
    }

    public function edit($id)
    {
        // get the shark
        $master_popup_message = MasterPopupMessage::find($id);

        // show the edit form and pass the shark
        return view('admin.master_popup_message.master_popup_message_edit', ['master_popup_message' => $master_popup_message]);
    }

    public function update(Request $request, $id)
    {
        //$user=$request->user();
        //$master_popup_message = MasterPopupMessage::where(['user_id'=>$user->id,'id'=>$id])->first();

        $master_popup_message = MasterPopupMessage::find($id);
        $fields = $request->validate(
            [
                'group_name' => 'required',
                'message_value_en' => 'required',
                'message_value_ar' => 'required',
            ],
            [
                "group_name.required" => __("admin_dashboard.admin.MasterPopupMessage.validation_msg.group_name.required"),
                "message_value_en.required" => __("admin_dashboard.admin.MasterPopupMessage.validation_msg.message_value_en.required"),
                "message_value_ar.required" => __("admin_dashboard.admin.MasterPopupMessage.validation_msg.message_value_ar.required"),

            ]
        );

        //if($files=$request->file('img')){
        //Storage::disk('public')->delete($master_popup_message->img);
        //$fields['img']=$files->storePublicly('uploads','public');
        //}


        $master_popup_message->update($fields);


        // redirect
        Session::flash('success', __('admin_dashboard.admin.MasterPopupMessage.message.add.success'));
        return Redirect::to(route('admin.master-popup-message.index'));
        // return Redirect::to(route('admin.master-popup-message.index'));
    }


    public function destroy(Request $request, $id)
    {

        //$user=$request->user();

        // delete
        //$master_popup_message = MasterPopupMessage::where(['user_id'=>$user->id])->get();

        $master_popup_message = MasterPopupMessage::find($id);


        //Storage::disk('public')->delete($master_popup_message->img);

        $master_popup_message->delete();

        // redirect
        Session::flash('success', __('admin_dashboard.admin.MasterPopupMessage.message.delete.success'));
        return Redirect::to(route('admin.master-popup-message.index'));
    }


    // public function enbDisb($id){
    //     $master_popup_message = MasterPopupMessage::where(['role'=>'master_popup_message','id'=>$id])->first();
    //     if(isset($master_popup_message->is_active)){
    //         if($master_popup_message->is_active==1){
    //             $master_popup_message->update(['is_active'=>0]);
    //             Session::flash('success', 'Successfully de-activated the master_popup_message!');
    //         }else{
    //             $master_popup_message->update(['is_active'=>1]);
    //         }
    //     }

    //     Session::flash('success', 'Successfully activated the master_popup_message!');
    //     return Redirect::to(route('admin.master-popup-message.index'));

    // }



}
