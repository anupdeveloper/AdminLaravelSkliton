<?php 

namespace App\Traits;

use App\Models\OtpModel;
use App\Models\{User,UserTemp};
use Illuminate\Support\Facades\Hash;
use App\Helper\Helper;
use Illuminate\Support\Facades\Crypt;
use Config;
use DB;

trait GeneralTrait{

    private function __getUniqueNo($table,$column){
        $row = DB::table($table)->select('id')->latest()->first();
        $unique_no = $row->id;
        return 'T'.$unique_no;
    }

    private function __sendResponse($status_code,$status,$message,$data=null){
        //dd($status_code);
       if(!empty($data)) {
        return response()->json( [
                'status' => $status_code,
                'success' => $status,
                'message' => $message,
                'data' => $data
            ]);
       } else {
        return response()->json( [
                'status' => $status_code,
                'success' => $status,
                'message' => $message,
            ] );
       }
       
    }
 
}