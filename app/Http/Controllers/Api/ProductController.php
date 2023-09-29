<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{User,Product};
use App\Traits\{Base64FileTrait, GeneralTrait};
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Helper\Helper;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    use Base64FileTrait, GeneralTrait;
    
    public function get_all_banners(Request $request) {
        $logged_user_id = Auth::user()->id;
        //dd($logged_user_id);
        $products = Product::with('product_images','cetegory')->paginate(10);
        //dd($products);
        $message = 'Product list';
        return $this->__sendResponse(200,true,$message,$products);
    }

    public function get_all_products(Request $request,$category = null) {
        $logged_user_id = Auth::user()->id;
        //dd($logged_user_id);
        $search = $request->search;
        $category_id = $request->category_id;
        if(!empty($category_id)) {
            $products = Product::with('product_images','cetegory')
                                ->where('category_id',$category_id);
            if(!empty($search)) {
                $products = $products->where(
                        function($query) use ($search)  {
                            return $query
                            ->where('products.product_name','like','%'.$search.'%');
                        }
                    );
            }
            $products =  $products->paginate(10);
        }
        else {
            $products = Product::with('product_images','cetegory');
            if(!empty($search)) {
                $products = $products->where(
                        function($query) use ($search)  {
                            return $query
                            ->where('products.product_name','like','%'.$search.'%');
                        }
                    );
            }
            $products =  $products->paginate(10);
        }
           
        //dd($products);
        $message = 'Product list';
        return $this->__sendResponse(200,true,$message,$products);
    }
}
