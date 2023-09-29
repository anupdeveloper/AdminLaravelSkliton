<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{User,Product,Order,OrderDetail};
use App\Traits\{Base64FileTrait, GeneralTrait};
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Helper\Helper;
use Illuminate\Support\Facades\Storage;


class OrderController extends Controller
{
    use Base64FileTrait, GeneralTrait;
    
    public function create_order(Request $request) {
        $logged_user_id = Auth::user()->id;
        //dd($logged_user_id);
        //($request->all());

        $order_data = [
            'total_amt' => $request->order_price,
            'order_status' => 'pending',
            'user_id' => $logged_user_id
        ];
        $order = Order::create($order_data);

        if($order) {
            if(count($request->order_items) > 0) {
                foreach($request->order_items as $order_item)
                {
                    $order_detail_data = [
                        'order_id' => $order->id,
                        'product_id' => $order_item['id'],
                        'product_qty' => $order_item['quantity'],
                    ];
                    OrderDetail::create($order_detail_data);
                }
                Order::where('id',$order->id)->update([
                    'order_id' => date('dmY').'-'.str_pad($order->id,3,"0",STR_PAD_LEFT)
                ]);
            }
        }

        //dd($products);
        $message = 'Order created successfully.';
        return $this->__sendResponse(200,true,$message);
    }

    
    public function orders_list(Request $request) {
        $logged_user_id = Auth::user()->id;
        //dd($logged_user_id);
        //($request->all());

        
        $order_list = Order::with('order_detail','order_detail.product_detail')->where('user_id',$logged_user_id)->paginate(10);

        //dd($products);
        $message = 'Order fetch successfully.';
        return $this->__sendResponse(200,true,$message,$order_list);
    }

}
