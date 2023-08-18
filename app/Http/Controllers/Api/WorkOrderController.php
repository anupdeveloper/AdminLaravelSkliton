<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use App\Models\{PersonalityDimension, UserYellowConnections, UserRedConnections, UserFamilyPersonalityDimension};
use App\Models\{TechnicianAssignSlot, WorkOrder, CommonIcon, User, UserPurchaseSubscription, Transaction, Connection, Message,Ticket};
use App\Models\UserProfileImage;
use App\Rules\Base64FileMaxSize;
use App\Rules\Base64FileType;
use App\Traits\Base64FileTrait;
use Carbon\Carbon;
use App\Helper\Helper;
use App\Models\AccountType;
use App\Models\UserPersonalityDimension;
use App\Models\{Status,WorkOrderReportPic,WorkOrderReport, UserFamily, UserLikesHideBlocked, UserFamilyProfileImage};
use App\Rules\AlphaNumaric;
use App\Rules\StrMaxNumber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use DB;
use Session;
use Codedge\Fpdf\Fpdf\Fpdf;
use PDF;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Api\ConnectionController;
use Config;

class WorkOrderController extends Controller
{
    use UserTrait, Base64FileTrait;


    public function get_status()
    {
        $status = Status::all();
        return [
            'success' => count($status) > 0 ? true : false,
            'message' => count($status) > 0 ? 'Data fetch successfully.' : 'No records found.',
            'data' => $status
        ];
    }

    public function task_list(Request $request)
    {
        $user_id = Auth::user()->id;
        //dd($request->all);
        $request->all = 0;
        $date = $request->date;
        if(isset($request->all) && $request->all == 1) {
            $task_list = TechnicianAssignSlot::with('slot_detail','work_order_deatil')
                                    ->where('user_id',$user_id)
                                    ->whereNotIn('status',['Completed','Not Resolved'])
                                    ->orderBy('slot_id')
                                    ->get();
        } else {
            if(1){ //if($date == null) {
                $task_list = TechnicianAssignSlot::with('slot_detail','work_order_deatil')
                                        ->where('user_id',$user_id)
                                        ->whereNotIn('status',['Completed','Not Resolved'])
                                        ->whereDate('date',Carbon::today())
                                        ->orderBy('slot_id')
                                        ->get();
            } else {
                $task_list = TechnicianAssignSlot::with('slot_detail','work_order_deatil')
                                        ->where('user_id',$user_id)
                                        ->whereNotIn('status',['Completed','Not Resolved'])
                                        ->whereDate('date',date('Y-m-d',strtotime($date)))
                                        ->orderBy('slot_id')
                                        ->get();
            }
        }
        
        

        return [
            'success' => count($task_list) > 0 ? true : false,
            'message' => count($task_list) > 0 ? 'Data fetch successfully.' : 'No records found.',
            'data' => $task_list
        ];
    }

    
    public function task_detail(Request $request, $id = null)
    {
        $user_id = Auth::user()->id;
        //dd($request->all);
        $id = $request->id;
        //dd($id);
        if(isset($id) && $id) {
            $task_detail = TechnicianAssignSlot::with('slot_detail','work_order_deatil')
                                    //->where('user_id',$user_id)
                                    ->where('technian_slot.work_order_id',$id)
                                    //->orderBy('slot_id')
                                    ->first();
            return [
                'success' => isset($task_detail) > 0 ? true : false,
                'message' => isset($task_detail) > 0 ? 'Data fetch successfully.' : 'No records found.',
                'data' => $task_detail
            ];
        } else {
            return [
                'success' => false,
                'message' => 'No records found.'
            ];
        }
        
    }


    public function task_update(Request $request)
    {
        //dd($request->all());
        $user_id = Auth::user()->id;
        $id = $request->id;
        $status = $request->status;
        $comment = $request->comment;
        $photos = [];

        try {

            if(count($request->pic)>0) {
                foreach($request->pic as $photo) {
                    $path = $this->_normalFileUpload($photo, '/uploads/work_order',[600,600]);
                    $photos[] = $path;
                    WorkOrderReportPic::create([
                        'wo_id' => $id,
                        'pic' => $path,
                        //'comment' => $comment,
                        //'status' => $status
                    ]);
                }
            }

            WorkOrderReport::create([
                'technician_id' => $user_id,
                'task_id' => $id,
                'comment' => $comment,
                'status' => $status
            ]);

            WorkOrder::where('id',$id)->update([
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);


            $data = [
                'status' => $status,
            ];
            TechnicianAssignSlot::where('work_order_id',$id)->update($data);

        } catch(Error $e) {
            return [
                'success' => false,
                'message' => 'Someting went worng'
            ];
        }
        
        return [
            'success' => true,
            'message' => 'You have successfully updated the task.'
        ];

    }

    
}
