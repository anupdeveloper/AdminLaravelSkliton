<?php 

namespace App\Traits;

use App\Models\User;
use App\Models\Connection;
use Carbon\Carbon;

trait UserTrait{

    public function getUsers(){
        $users=User::all();
       
        return $users;
    }

    public function _checkRequiredFields(User $user){
        $required_fields=[
            "name"=>['rules'=>'required'],
            "username"=>['rules'=>'required|unique:users,username'],
            "email"=>['rules'=>'required|unique:users,email'],
            "dob"=>['rules'=>'required|date'],
            "account_type_id"=>['rules'=>'required|exists:account_types,id'],
            "gender"=>['rules'=>'required|in:male,female,other']
            ];
        $flag=true;
        $rules=[];

        foreach ($required_fields as $req_field=>$value) {
            if($user->$req_field=='' || $user->$req_field==null){
                $rules[$req_field]=$value['rules'];
                $flag=false;
            }
            
        }

        return [
            'success'=>$flag,
            'rules'=>$rules
        ];
        

    }

    /* Calculate the age */
    public function _calculate_age($dob = null) {
        if(!empty($dob)) {
            return $years = Carbon::parse($dob)->age;
        } else {
            return '--';
        }
        
    }
    /* check connection status */
    public function _check_connection_status($reciver_id,$logged_user_id) {
        
        $already_connection_exits = Connection::select('request_id','receiver_id','connection_status','id')
                                    ->where('request_id',$logged_user_id)
                                    ->where('receiver_id',$reciver_id)
                                    ->orWhereRaw(" ( request_id = '".$reciver_id."' AND receiver_id = '".$logged_user_id."' ) ");

        //$query = str_replace(array('?'), array('\'%s\''), $already_connection_exits->toSql());
        //$query = vsprintf($query, $already_connection_exits->getBindings());
        //dump($query);
        //die;
        //return $query;
        $already_connection_exits = $already_connection_exits->first();
        //$data['sql'] = $query;
        if($already_connection_exits) {
           $data['connection_detail'] = $already_connection_exits;
           $data['connection_status'] = $already_connection_exits->connection_status;
           $data['connection_id'] = false;
           if($data['connection_status'] == 'approved') {
            $data['connection_id'] = $already_connection_exits->id;
           }
         } else {
            $data['connection_detail'] = false;
            $data['connection_status'] = false;
            $data['connection_id'] = false;
        }
        return $data;
    }

    
    public function _check_is_requested($reciver_id,$logged_user_id) {
        
        $already_connection_exits = Connection::select('connection_status')
                                    ->where('receiver_id',$logged_user_id)
                                    ->where('request_id',$reciver_id)
                                    ->first();
        if($already_connection_exits && $already_connection_exits->connection_status == 'pending') {
            return true;
        } else {
            return false;
        }
    
    }
}


?>