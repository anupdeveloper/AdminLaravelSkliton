<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\{WorkOrder,WorkOrderReport,TechnicianAssignSlot,User,UserPurchaseSubscription,Transaction};
use Carbon\Carbon;
use App\Helper\Helper;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        $schedule->call(function () {

            
            $previous_day = Carbon::now()->subDays(1);
            $all_wos = WorkOrder::
                            whereDate('created_at', $previous_day)
                            ->where('status','Not Started')
                            //->where('notification_sent','0')
                            ->take(20)->get();
            
            //Log::info($previous_day);
            //Log::info($all_wos);
            if(isset($all_wos)) {
                foreach($all_wos as $row) {
                    
                    //@ send notifications
                    // $device_tokens = Helper::getRecipantDeviceTokens($user->user_id);
                    // $message_data = Helper::getMessageByCode('NOT03');
                    // $messgae = array(
                    //     "title" => isset($message_data->message_value_en) ? $message_data->message_value_en : '' , 
                    //     "body" => isset($message_data->message_value_en) ? $message_data->message_value_en : ''
                    // );
                    // $sender_id = 1;
                    // $notification_type = 'subscrption-renew';
                    // $key1 = Helper::getUserName($sender_id);
                    // $key2 = '';
                    // Helper::send_notification_FCM($device_tokens, $messgae, $message_data, $sender_id,$user->user_id,$key1,$key2,$notification_type);
                    // End send notifications
                    //$now = Carbon::now()->toDateTimeString();
                    //$nextdate= Carbon::now()->addDays(1);
                    //Log::info('Next Day===>'.$nextdate);
                        
                    

                    WorkOrder::where('id',$row->id)->update(['status'=>'Not Resolved']);
                    TechnicianAssignSlot::where('work_order_id',$row->id)->update(['status'=>'Not Resolved']);
                    WorkOrderReport::where('task_id',$row->id)->update(['status'=>'Not Resolved']);
    
                     
                    
                }
            }
            //file_put_contents(storage_path('logs/laravel.log'),'');
        })->everyMinute();


       
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
