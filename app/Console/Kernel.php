<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\{User,UserPurchaseSubscription,Transaction};
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

            $seven_day_after = Carbon::today()->addDay(7);

            $all_users = UserPurchaseSubscription::
                            whereDate('expired_date', $seven_day_after)
                            ->where('status','active')
                            ->where('notification_sent','0')
                            ->get();
            //Log::info('Seven day ago ===>' . $seven_day_after);
            //Log::info($all_users);
            if(isset($all_users)) {
                foreach($all_users as $user) {
                    
                    //@ send notifications
                    $device_tokens = Helper::getRecipantDeviceTokens($user->user_id);
                    $message_data = Helper::getMessageByCode('NOT03');
                    $messgae = array(
                        "title" => isset($message_data->message_value_en) ? $message_data->message_value_en : '' , 
                        "body" => isset($message_data->message_value_en) ? $message_data->message_value_en : ''
                    );
                    $sender_id = 1;
                    $notification_type = 'subscrption-renew';
                    $key1 = Helper::getUserName($sender_id);
                    $key2 = '';
                    Helper::send_notification_FCM($device_tokens, $messgae, $message_data, $sender_id,$user->user_id,$key1,$key2,$notification_type);
                    // End send notifications

                    UserPurchaseSubscription::where('user_id',$user->user_id)
                                            ->where('id',$user->id)
                                            ->update(['notification_sent'=>1]);

                }
            }

            //@ update all users subscription expired
            $today = Carbon::today();
            $all_users_subscription_expired_today = UserPurchaseSubscription::
                            whereDate('expired_date', $today)
                            ->where('status','active')
                            //->where('notification_sent','0')
                            ->get();
            
            //Log::info($all_users_subscription_expired_today);
            if(isset($all_users_subscription_expired_today)) {
                foreach($all_users_subscription_expired_today as $user) {
                    
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

                    UserPurchaseSubscription::where('user_id',$user->user_id)
                                            ->where('id',$user->id)
                                            ->update(['status'=>'expired']);

                }
            }
            //file_put_contents(storage_path('logs/laravel.log'),'');
        })->everyMinute();


        $schedule->call(function () {

            

            $all_transactions = UserPurchaseSubscription::where('invoice_generated',0)->get();
            if(isset($all_transactions)) {
                foreach($all_transactions as $transaction) {
                    
                    //$result = (new UserController)->generate_invoice($transaction->transaction_id);
                    Helper::generate_invoice($transaction->transaction_id,0,'en');
                    UserPurchaseSubscription::where('id',$transaction->id)->update(
                        [
                            'invoice_generated' => 1
                        ]
                    );
                    //file_put_contents(storage_path('logs/laravel.log'),'');
                   
                }
            }
            
        })->everyTwoMinutes();
    
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
