<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\{Transaction, AccountType, User, UserFamily, Country, SkinColor, MasterEducational, MasterWork, MasterSect, MasterTribe, HijabType, PersonalityDimension, UserPersonalityDimension, UserFamilyPersonalityDimension};
use App\Models\UserPurchaseSubscription;
use App\Helper\Helper;
use Devinweb\LaravelHyperpay\Facades\LaravelHyperpay;
use Illuminate\Support\Str;
use App\Billing\HyperPayBilling;
use DB;
use Illuminate\Support\Facades\Crypt;
use Validator;
use Redirect;;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use QrCode;
use App;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use App\Traits\OtpTrait;
use App\Rules\AlphaNumaric;
use App\Rules\StrMaxNumber;

class TestController extends Controller
{
    use OtpTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function update_payment_response_id(Request $request)
    {
        $transactions = DB::table('transactions')
        ->whereNotNull('payment_response')
        ->get();
        
        //dd($transactions_payment_ids);
        //dd($users);
        foreach ($transactions as $t) {
            if(isset($t->payment_response)) {
                $pay_res = json_decode($t->payment_response);
                //dd($pay_res->id);
                if(isset($pay_res->id))
                DB::table('transactions')->where('auto_id', $t->auto_id)->update(['payment_response_id' =>$pay_res->id]);
            }
        }
    }

    public function fix_script(Request $request)
    {
        $transactions_payment_ids = DB::table('transactions')
            ->select('payment_response_id')
            ->whereNotNull('payment_response_id')
            ->get()
            ->pluck('payment_response_id')
            ->toArray();
            //dd($transactions_payment_ids);
        //dd($users);
        // foreach ($transactions as $t) {
        //     if(isset($t->payment_response)) {
        //         $pay_res = json_decode($t->payment_response);
        //         //dd($pay_res->id);
        //         if(isset($pay_res->id))
        //         DB::table('transactions')->where('auto_id', $t->auto_id)->update(['payment_response_id' =>$pay_res->id]);
        //     }
        // }
        $hyper_payment_ids = DB::table('hyper_pay_payment')
                ->select('payment_response_id')
                //->where('payment_response_id',$t->payment_response_id)
                ->get()
                ->pluck('payment_response_id')
                ->toArray();
        // $total_paid = 1;
        // foreach ($transactions as $t) {
        //     if(!empty($t->payment_response_id)) {
                

        //         if(in_array($t->payment_response_id,$hyper_payment_ids)) {
        //             $total_paid++;
        //             echo $t->payment_response_id.'<br />';
        //         }
                
        //     }
           
        // }
        //echo 'Total Paid=>'.$total_paid;
        $total_paid = 1;
        $total_untrack_paid = 1;
        $untrack_payment_ids = [];
        foreach($hyper_payment_ids as $h) {
            if( in_array($h,$transactions_payment_ids) ) {
                $total_paid++;
            } else{
                $total_untrack_paid++;
                $untrack_payment_ids[] = $h; 
            }
        }
        echo 'Total Paid=>'.$total_paid.'<br>';
        echo 'Total Untrack Paid=>'.$total_untrack_paid;
        //dd($untrack_payment_ids);
        $transactions_all_list = DB::table('hyper_pay_payment')
            ->select('users.username','users.id as m_uid','users.mobile','users.email','hyper_pay_payment.payment_response_id as h_payment_response_id','hyper_pay_payment.email as h_email','transactions.*')
            ->leftJoin('users','users.email','hyper_pay_payment.email')
            ->leftJoin('transactions','users.id','transactions.user_id')
            ->whereIn('hyper_pay_payment.payment_response_id',$untrack_payment_ids)
            ->orderBy('hyper_pay_payment.email')
            ->get();
        //dd($transactions_all_list);
        if($transactions_all_list) {
            $table = '<table border="1"><tr>
                            <td>UniquedID</td>
                            <td>UserID</td>
                            <td>Mobile</td>
                            <td>userNmae</td>
                            <td>Email</td>
                            <td>Status</td>
                            <td>Response</td>
                            <td>ID</td>
                            <td>H DATE</td>
                            </tr>';
            $ck_email = false;
            $pre_email = '';
            foreach($transactions_all_list as $t) {

                if(1){ //if($t->mobile == '504782488') {

                    // echo '<br>UNIQUEID=>'.$t->h_payment_response_id.'<br>';
                    // echo 'UserID=>'.$t->m_uid.'<br>';
                    // echo 'Mobile=>'.$t->mobile.'<br>';
                    // echo 'userNmae=>'.$t->username.'<br>';
                    // echo 'Email=>'.$t->email.'<br>';
                    // echo 'H Email=>'.$t->h_email.'<br>';
                    // echo 'Status=>'.$t->status.'<br>';
                    // echo 'Response=>'.$t->payment_response.'<br>';
                    // echo 'ID=>'.$t->auto_id.'<br>';
                    // echo 'H DATE=>'.$t->created_at.'<br>----------- ';
                    if(!empty($pre_email) && $pre_email==$t->email) {
                        // $table .=  '<tr bgcolor="red">
                        // <td>'.$t->h_payment_response_id.'</td>
                        // <td>'.$t->m_uid.'</td>
                        // <td>'.$t->mobile.'</td>
                        // <td>'.$t->username.'</td>
                        // <td>'.$t->email.'</td>
                        // <td>'.$t->status.'</td>
                        // <td>'.$t->payment_response.'</td>
                        // <td>'.$t->auto_id.'</td>
                        // <td>'.$t->created_at.'</td>
                        // </tr>';
                    } else{
                        // $pre_email = $t->email;
                        // $table .=  '<tr bgcolor="white">
                        //     <td>'.$t->h_payment_response_id.'</td>
                        //     <td>'.$t->m_uid.'</td>
                        //     <td>'.$t->mobile.'</td>
                        //     <td>'.$t->username.'</td>
                        //     <td>'.$t->email.'</td>
                        //     <td>'.$t->status.'</td>
                        //     <td>'.$t->payment_response.'</td>
                        //     <td>'.$t->auto_id.'</td>
                        //     <td>'.$t->created_at.'</td>
                        //     </tr>';
                    }

                    $no_accounts = User::where('mobile',$t->mobile)->count();
                    if($no_accounts == 1) {



                    

                        $sub_insert = '';
                        $checkout_id='';
                        $subscription_id='';
                        $trasaction_id = '';

                        $has_trans_detail = DB::table('transactions')
                            ->where('user_id',$t->m_uid)
                            ->count();

                        $trans_detail = DB::table('transactions')
                            ->where('user_id',$t->m_uid)
                            ->orderBy('auto_id','desc')
                            ->limit(1)
                            ->first();
                        //dd($trans_detail);
                        if($trans_detail) {


                            $trasaction_id = $trans_detail->checkout_id;
                            $checkout_id = $trans_detail->checkout_id;
                            $user_id = $trans_detail->user_id;
                            $auto_id = $trans_detail->auto_id;
                            if($trans_detail->status == 'pending') {

                                $table .=  '<tr bgcolor="green">
                                            <td>'.$t->h_payment_response_id.'</td>
                                            <td>'.$t->m_uid.'</td>
                                            <td>'.$t->mobile.'</td>
                                            <td>'.$t->username.'</td>
                                            <td>'.$t->email.'</td>
                                            <td>'.$t->status.'</td>
                                            <td>'.$t->payment_response.'</td>
                                            <td>'.$t->auto_id.'</td>
                                            <td>'.$t->created_at.'</td>
                                            </tr>';
                                
                                $res_data = json_decode($trans_detail->trackable_data);
                                if($res_data) {
                                    $subscription_id = $res_data->product_id;
                                    //dd($subscription_id);
                                } else {
                                    $subscription_id = $res_data->amount == '2298.85' ? 5 : 5;
                                }

                                // Step1
                                $payment_response = [
                                    'id' => $t->h_payment_response_id
                                ];
                                
                                DB::table('transactions')
                                    ->where('checkout_id',$checkout_id)
                                    ->update(
                                        [
                                            'payment_response_id'=> $t->h_payment_response_id,
                                            'payment_response' => json_encode($payment_response),
                                            'status' => 'success'
                                        ]
                                    );
                                

                                // is data in subscription
                                // Setp2
                                $has_any_subscription = DB::table('user_purchase_subscriptions')
                                ->where('user_id', $user_id)
                                ->where('payment_type','subscription')
                                ->count();
                                //echo $has_any_subscription; 
                                //dd($checkout_id);
                                if($has_any_subscription == 0) {

                                    $new_expiry_date = Carbon::now()->addMonths(6);
                                    //dd($new_expiry_date);
                                    
                                    $sub_insert = DB::table('user_purchase_subscriptions')
                                        ->insertGetId(
                                            [
                                                'user_id'=>$user_id,
                                                'payment_type'=>'subscription',
                                                'trans_auto_id'=>$auto_id,
                                                'transaction_id'=>$checkout_id,
                                                'subscription_id'=>$subscription_id,
                                                'status'=>'active',
                                                'expired_date'=>$new_expiry_date,
                                                'member_included'=>0,
                                                'created_at'=>date('Y-m-d H:i:s')
                                            ]
                                        );
                                    
                                    //dd($sub_insert);
                                    if($sub_insert) {
                                        
                                        $sub_insert = DB::table('user_payment_fixing')
                                        ->insertGetId(
                                            [
                                                'user_id'=>$t->m_uid,
                                                'transaction_id'=>$t->auto_id,
                                                'fixing_date'=>date('Y-m-d H:i:s'),
                                                'created_at'=>date('Y-m-d H:i:s'),
                                                'mobile'=>$t->mobile,
                                                'email'=>$t->email
                                            ]
                                        );
                                        
                                    }
                                }

                            } else {
                                // Trans is success
                                // Setp2
                                $has_any_subscription = DB::table('user_purchase_subscriptions')
                                ->where('user_id', $user_id)
                                ->where('payment_type','subscription')
                                ->count();
                                //echo $has_any_subscription; 
                                //dd($checkout_id);
                                if($has_any_subscription == 0) { //no entry in purchase subscription

                                    $new_expiry_date = Carbon::now()->addMonths(6);
                                    //dd($new_expiry_date);
                                    
                                    $sub_insert = DB::table('user_purchase_subscriptions')
                                        ->insertGetId(
                                            [
                                                'user_id'=>$user_id,
                                                'payment_type'=>'subscription',
                                                'trans_auto_id'=>$auto_id,
                                                'transaction_id'=>$checkout_id,
                                                'subscription_id'=>$subscription_id,
                                                'status'=>'active',
                                                'expired_date'=>$new_expiry_date,
                                                'member_included'=>0,
                                                'created_at'=>date('Y-m-d H:i:s')
                                            ]
                                        );
                                    
                                    //dd($sub_insert);
                                    if($sub_insert) {
                                        $user = User::find($user_id);
                                        
                                        $sub_insert = DB::table('user_payment_fixing')
                                        ->insertGetId(
                                            [
                                                'user_id'=>$user_id,
                                                'transaction_id'=>$auto_id,
                                                'fixing_date'=>date('Y-m-d H:i:s'),
                                                'created_at'=>date('Y-m-d H:i:s'),
                                                'mobile'=>$user->mobile,
                                                'email'=>$user->email
                                            ]
                                        );
                                        
                                    }
                                } else { // has one entry in user purchase subscription
                                    $subsctiption_detail = DB::table('user_purchase_subscriptions')
                                        ->where('user_id', $user_id)
                                        ->where('payment_type','subscription')
                                        ->orderBy('id','desc')
                                        ->limit(1)
                                        ->first();
                                    if($subsctiption_detail) {
                                        if( $subsctiption_detail->status == 'active') {
                                            // all good
                                        } else {
                                            $new_expiry_date = Carbon::now()->addMonths(6);
                                            //dd($new_expiry_date);
                                            
                                            $sub_insert = DB::table('user_purchase_subscriptions')
                                                ->insertGetId(
                                                    [
                                                        'user_id'=>$user_id,
                                                        'payment_type'=>'subscription',
                                                        'trans_auto_id'=>$auto_id,
                                                        'transaction_id'=>$checkout_id,
                                                        'subscription_id'=>$subscription_id,
                                                        'status'=>'active',
                                                        'expired_date'=>$new_expiry_date,
                                                        'member_included'=>0,
                                                        'created_at'=>date('Y-m-d H:i:s')
                                                    ]
                                                );
                                            
                                            //dd($sub_insert);
                                            if($sub_insert) {
                                                $user = User::find($user_id);
                                                
                                                $sub_insert = DB::table('user_payment_fixing')
                                                ->insertGetId(
                                                    [
                                                        'user_id'=>$user_id,
                                                        'transaction_id'=>$auto_id,
                                                        'fixing_date'=>date('Y-m-d H:i:s'),
                                                        'created_at'=>date('Y-m-d H:i:s'),
                                                        'mobile'=>$user->mobile,
                                                        'email'=>$user->email
                                                    ]
                                                );
                                                
                                            }
                                        }
                                    }
                                }
                            }
                            
                            
                        } else {
                            // No trans entry

                            if($has_trans_detail == 0) {

                                $users = User::where('mobile',$t->mobile)->get();

                                foreach($users as $user) {
                                    if( !empty($user->email) && !empty($user->username) && !empty($user->account_type_id ) && !empty($user->name ) ) {
                                        //dd($user->id);
                                        $invoice_no = uniqid();
                                        $fix_amt = '2298.85';
                                        $subscription_id = 5;
                                        $checkout_id = 'FIXING-'.$invoice_no;
                                        $trackable = json_encode([
                                            'invoice_no' =>$invoice_no,
                                            'user_id' => $user->id,
                                            'transaction_no' => $checkout_id,
                                            'checkout_id' => $checkout_id,
                                            'brand' => 'MADA',
                                        ]);
                                        $payment_response = [
                                            'id' => $t->h_payment_response_id
                                        ];
                                        //dd($t->h_payment_response_id);
                                        $auto_id = DB::table('transactions')->insertGetId(
                                            [
                                                'id' => $invoice_no,
                                                'user_id' => $user->id,
                                                'transaction_no' => $checkout_id,
                                                'checkout_id' => $checkout_id,
                                                'brand' => 'MADA',
                                                'amount' => $fix_amt,
                                                'currency' => env('CURRENCY'),
                                                'data' => $trackable,
                                                'trackable_data' => $trackable,
                                                'payment_response_id'=> $t->h_payment_response_id,
                                                'payment_response' => json_encode($payment_response),
                                                'status' => 'success',
                                                'created_at' => date('Y-m-d H:i:s')
                                            ]
                                        );
                                        //dd($auto_id);
                                        if($auto_id) {
                                            /// Step 2
                                            $user_id = $user->id;
                                            $has_any_subscription = DB::table('user_purchase_subscriptions')
                                            ->where('user_id', $user_id)
                                            ->where('payment_type','subscription')
                                            ->count();
                                            //echo $has_any_subscription; 
                                            //dd($checkout_id);
                                            if($has_any_subscription == 0) {
            
                                                $new_expiry_date = Carbon::now()->addMonths(6);
                                                //dd($new_expiry_date);
                                                
                                                $sub_insert = DB::table('user_purchase_subscriptions')
                                                    ->insertGetId(
                                                        [
                                                            'user_id'=>$user_id,
                                                            'payment_type'=>'subscription',
                                                            'trans_auto_id'=>$auto_id,
                                                            'transaction_id'=>$checkout_id,
                                                            'subscription_id'=>$subscription_id,
                                                            'status'=>'active',
                                                            'expired_date'=>$new_expiry_date,
                                                            'member_included'=>0,
                                                            'created_at'=>date('Y-m-d H:i:s')
                                                        ]
                                                    );

                                                
                                                
                                                //dd($sub_insert);
                                                if($sub_insert) {
                                                    
                                                    $has_a_entry = DB::table('user_payment_fixing')
                                                    ->where('mobile',$user->mobile)
                                                    ->count();
                                                    if($has_a_entry == 0) {
                                                        $trans_d = DB::table('transactions')
                                                            ->where('user_id',$user->id)
                                                            ->first();
                                                        $auto_id =  $trans_d->auto_id;
                                                        //dd($auto_id);
                                                        if(!empty($auto_id)) {
                                                            $sub_insert = DB::table('user_payment_fixing')
                                                            ->insertGetId(
                                                                [
                                                                    'user_id'=>$user_id,
                                                                    'transaction_id'=>$auto_id,
                                                                    'fixing_date'=>date('Y-m-d H:i:s'),
                                                                    'created_at'=>date('Y-m-d H:i:s'),
                                                                    'mobile'=>$user->mobile,
                                                                    'email'=>$user->email
                                                                ]
                                                            ); 
                                                        }
                                                        
                                                    }
                                                    
                                                }
                                            }

                                            //break;
                                        }

                                        
                                    }
                                    
                                }
                            }

                        }
                        //dd($checkout_id);
                        
                        

                    } else {

                        $table .=  '<tr bgcolor="red">
                        <td>'.$t->h_payment_response_id.'</td>
                        <td>'.$t->m_uid.'</td>
                        <td>'.$t->mobile.'</td>
                        <td>'.$t->username.'</td>
                        <td>'.$t->email.'</td>
                        <td>'.$t->status.'</td>
                        <td>'.$t->payment_response.'</td>
                        <td>'.$t->auto_id.'</td>
                        <td>'.$t->created_at.'</td>
                        </tr>';

                        $users = User::where('mobile',$t->mobile)
                            ->get();
                        
                        
                        $users_ids = User::select('id')
                            ->where('mobile',$t->mobile)
                            ->pluck('id')
                            ->toArray();
                        //dd($users_ids);
                        
                        if(count($users_ids)>1) {
                            $sub_insert = '';
                            $checkout_id='';
                            $subscription_id='';
                            $trasaction_id = '';
                            $ck_flag = 0;
                            $has_trans_detail = DB::table('transactions')
                                ->whereIn('user_id',$users_ids)
                                ->count();
                            //dd($has_trans_detail);
                            if($has_trans_detail > 0) {
                                foreach($users as $u) {
                                    // if any one entry has a record in transtable
                                    //dd($u->id);
                                    $trans_detail = DB::table('transactions')
                                        ->where('user_id',$u->id)
                                        ->first();
                                    //dd($trans_detail);
                                    echo $u->id;
                                       
                                    if($trans_detail) {
                                        $ck_flag = 1;
                                        $trasaction_id = $trans_detail->checkout_id;
                                        $checkout_id = $trans_detail->checkout_id;
                                        $user_id = $trans_detail->user_id;
                                        $auto_id = $trans_detail->auto_id;
                                        if($trans_detail->status == 'pending') {
                                            //dd($user_id);
                                            $res_data = json_decode($trans_detail->trackable_data);
                                            if($res_data) {
                                                $subscription_id = $res_data->product_id;
                                                //dd($subscription_id);
                                            } else {
                                                $subscription_id = $res_data->amount == '2298.85' ? 5 : 5;
                                            }
            
                                            // Step1
                                            $payment_response = [
                                                'id' => $t->h_payment_response_id
                                            ];
                                            
                                            DB::table('transactions')
                                                ->where('checkout_id',$checkout_id)
                                                ->update(
                                                    [
                                                        'payment_response_id'=> $t->h_payment_response_id,
                                                        'payment_response' => json_encode($payment_response),
                                                        'status' => 'success'
                                                    ]
                                                );
                                            
            
                                            // is data in subscription
                                            // Setp2
                                            $has_any_subscription = DB::table('user_purchase_subscriptions')
                                            ->where('user_id', $user_id)
                                            ->where('payment_type','subscription')
                                            ->count();
                                            //echo $has_any_subscription; 
                                            //dd($checkout_id);
                                            if($has_any_subscription == 0) {
            
                                                $new_expiry_date = Carbon::now()->addMonths(6);
                                                //dd($new_expiry_date);
                                                
                                                $sub_insert = DB::table('user_purchase_subscriptions')
                                                    ->insertGetId(
                                                        [
                                                            'user_id'=>$user_id,
                                                            'payment_type'=>'subscription',
                                                            'trans_auto_id'=>$auto_id,
                                                            'transaction_id'=>$checkout_id,
                                                            'subscription_id'=>$subscription_id,
                                                            'status'=>'active',
                                                            'expired_date'=>$new_expiry_date,
                                                            'member_included'=>0,
                                                            'created_at'=>date('Y-m-d H:i:s')
                                                        ]
                                                    );
                                                
                                                //dd($sub_insert);
                                                if($sub_insert) {
                                                    

                                                    $sub_insert = DB::table('user_payment_fixing')
                                                    ->insertGetId(
                                                        [
                                                            'user_id'=>$user_id,
                                                            'transaction_id'=>$auto_id,
                                                            'fixing_date'=>date('Y-m-d H:i:s'),
                                                            'created_at'=>date('Y-m-d H:i:s'),
                                                            'mobile'=>$t->mobile,
                                                            'email'=>$t->email
                                                        ]
                                                    );
                                                    
                                                }
                                            }
            
                                        } else {
                                            //dd('success');
                                            // Trans is success
                                            // Setp2
                                            $has_any_subscription = DB::table('user_purchase_subscriptions')
                                            ->where('user_id', $user_id)
                                            ->where('payment_type','subscription')
                                            ->count();
                                            //echo $has_any_subscription; 
                                            //dd($checkout_id);
                                            if($has_any_subscription == 0) { //no entry in purchase subscription
            
                                                $new_expiry_date = Carbon::now()->addMonths(6);
                                                //dd($new_expiry_date);
                                                
                                                $sub_insert = DB::table('user_purchase_subscriptions')
                                                    ->insertGetId(
                                                        [
                                                            'user_id'=>$user_id,
                                                            'payment_type'=>'subscription',
                                                            'trans_auto_id'=>$auto_id,
                                                            'transaction_id'=>$checkout_id,
                                                            'subscription_id'=>$subscription_id,
                                                            'status'=>'active',
                                                            'expired_date'=>$new_expiry_date,
                                                            'member_included'=>0,
                                                            'created_at'=>date('Y-m-d H:i:s')
                                                        ]
                                                    );
                                                
                                                //dd($sub_insert);
                                                if($sub_insert) {
                                                    $user = User::find($user_id);
                                                    
                                                    $sub_insert = DB::table('user_payment_fixing')
                                                    ->insertGetId(
                                                        [
                                                            'user_id'=>$user_id,
                                                            'transaction_id'=>$auto_id,
                                                            'fixing_date'=>date('Y-m-d H:i:s'),
                                                            'created_at'=>date('Y-m-d H:i:s'),
                                                            'mobile'=>$user->mobile,
                                                            'email'=>$user->email
                                                        ]
                                                    );
                                                    
                                                }
                                            } else { // has one entry in user purchase subscription
                                                $subsctiption_detail = DB::table('user_purchase_subscriptions')
                                                    ->where('user_id', $user_id)
                                                    ->where('payment_type','subscription')
                                                    ->orderBy('id','desc')
                                                    ->limit(1)
                                                    ->first();
                                                if($subsctiption_detail) {
                                                    if( $subsctiption_detail->status == 'active') {
                                                        // all good
                                                    } else {
                                                        $new_expiry_date = Carbon::now()->addMonths(6);
                                                        //dd($new_expiry_date);
                                                        
                                                        $sub_insert = DB::table('user_purchase_subscriptions')
                                                            ->insertGetId(
                                                                [
                                                                    'user_id'=>$user_id,
                                                                    'payment_type'=>'subscription',
                                                                    'trans_auto_id'=>$auto_id,
                                                                    'transaction_id'=>$checkout_id,
                                                                    'subscription_id'=>$subscription_id,
                                                                    'status'=>'active',
                                                                    'expired_date'=>$new_expiry_date,
                                                                    'member_included'=>0,
                                                                    'created_at'=>date('Y-m-d H:i:s')
                                                                ]
                                                            );
                                                        
                                                        //dd($sub_insert);
                                                        if($sub_insert) {
                                                            $user = User::find($user_id);
                                                            
                                                            $trans_d = DB::table('transactions')
                                                                ->where('user_id',$user->id)
                                                                ->first();
                                                            $auto_id =  $trans_d->auto_id;
                                                            //dd($auto_id);
                                                            if(!empty($auto_id)) {
                                                                $sub_insert = DB::table('user_payment_fixing')
                                                                ->insertGetId(
                                                                    [
                                                                        'user_id'=>$user_id,
                                                                        'transaction_id'=>$auto_id,
                                                                        'fixing_date'=>date('Y-m-d H:i:s'),
                                                                        'created_at'=>date('Y-m-d H:i:s'),
                                                                        'mobile'=>$user->mobile,
                                                                        'email'=>$user->email
                                                                    ]
                                                                ); 
                                                            }
                                                            
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    
                                    
                                    
                                }
                            } else {
                                // No entry in trans table
                                //dd($t->mobile);
                                $users_ids = $users_ids; // all entries of user ids
                                $users = User::whereIn('id',$users_ids)->get();
                                $has_trans_detail = DB::table('transactions')
                                ->whereIn('user_id',$users_ids)
                                ->count();
                                //dd($users);
                                if(count($users_ids)>0 && $has_trans_detail == 0) {
                                    foreach($users as $user) {
                                        if( !empty($user->email) && !empty($user->username) && !empty($user->account_type_id ) && !empty($user->name ) ) {
                                            //dd($user->id);
                                            $invoice_no = uniqid();
                                            $fix_amt = '2298.85';
                                            $subscription_id = 5;
                                            $checkout_id = 'FIXING-'.$invoice_no;
                                            $trackable = json_encode([
                                                'invoice_no' =>$invoice_no,
                                                'user_id' => $user->id,
                                                'transaction_no' => $checkout_id,
                                                'checkout_id' => $checkout_id,
                                                'brand' => 'MADA',
                                            ]);
                                            $payment_response = [
                                                'id' => $t->h_payment_response_id
                                            ];
                                            //dd($t->h_payment_response_id);
                                            $auto_id = DB::table('transactions')->insertGetId(
                                                [
                                                    'id' => $invoice_no,
                                                    'user_id' => $user->id,
                                                    'transaction_no' => $checkout_id,
                                                    'checkout_id' => $checkout_id,
                                                    'brand' => 'MADA',
                                                    'amount' => $fix_amt,
                                                    'currency' => env('CURRENCY'),
                                                    'data' => $trackable,
                                                    'trackable_data' => $trackable,
                                                    'payment_response_id'=> $t->h_payment_response_id,
                                                    'payment_response' => json_encode($payment_response),
                                                    'status' => 'success',
                                                    'created_at' => date('Y-m-d H:i:s')
                                                ]
                                            );
                                            //dd($auto_id);
                                            if($auto_id) {
                                                /// Step 2
                                                $user_id = $user->id;
                                                $has_any_subscription = DB::table('user_purchase_subscriptions')
                                                ->where('user_id', $user_id)
                                                ->where('payment_type','subscription')
                                                ->count();
                                                //echo $has_any_subscription; 
                                                //dd($checkout_id);
                                                if($has_any_subscription == 0) {
                
                                                    $new_expiry_date = Carbon::now()->addMonths(6);
                                                    //dd($new_expiry_date);
                                                    
                                                    $sub_insert = DB::table('user_purchase_subscriptions')
                                                        ->insertGetId(
                                                            [
                                                                'user_id'=>$user_id,
                                                                'payment_type'=>'subscription',
                                                                'trans_auto_id'=>$auto_id,
                                                                'transaction_id'=>$checkout_id,
                                                                'subscription_id'=>$subscription_id,
                                                                'status'=>'active',
                                                                'expired_date'=>$new_expiry_date,
                                                                'member_included'=>0,
                                                                'created_at'=>date('Y-m-d H:i:s')
                                                            ]
                                                        );

                                                    
                                                    
                                                    //dd($sub_insert);
                                                    if($sub_insert) {
                                                        
                                                        $has_a_entry = DB::table('user_payment_fixing')
                                                        ->where('mobile',$user->mobile)
                                                        ->count();
                                                        if($has_a_entry == 0) {
                                                            $trans_d = DB::table('transactions')
                                                                ->where('user_id',$user->id)
                                                                ->first();
                                                            $auto_id =  $trans_d->auto_id;
                                                            //dd($auto_id);
                                                            if(!empty($auto_id)) {
                                                                $sub_insert = DB::table('user_payment_fixing')
                                                                ->insertGetId(
                                                                    [
                                                                        'user_id'=>$user_id,
                                                                        'transaction_id'=>$auto_id,
                                                                        'fixing_date'=>date('Y-m-d H:i:s'),
                                                                        'created_at'=>date('Y-m-d H:i:s'),
                                                                        'mobile'=>$user->mobile,
                                                                        'email'=>$user->email
                                                                    ]
                                                                ); 
                                                            }
                                                            
                                                        }
                                                        
                                                    }
                                                }

                                                //break;
                                            }

                                            
                                        }
                                        
                                    }
                                } else {
                                    // No records
                                }
                                
                            }
                            
                            
                        }
                        
                        

                    }

                }
                

            }

            $table .=  '</table>';

            echo $table;
        }
    }

}
