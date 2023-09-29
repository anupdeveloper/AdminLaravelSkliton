<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Excel;

class Lead extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'leads'; 
    protected  $fillable = ['name','address','email','phone','assigned_to'];

    public function import_data($path)
    {
         
        $data = $data = Excel::toArray([],$path);

        //dd( $data );
        if($data[0]) {
            foreach($data[0] as $key=>$row) {
                if($key > 0) {
                    $lead = [
                        'name'=>$row[0],
                        'phone'=>$row[1],
                        'address'=>$row[2]
                    ];
                    self::updateOrCreate($lead);
                }
            }
        }
        return true;
    }


    public function lead_report()
    {
        return $this->belongsTo(LeadReport::class,'id','lead_id');
    }

    public function lead_assign_user_detail()
    {
        return $this->belongsTo(User::class,'assigned_to');
    }

    
    public function lead_assignment()
    {
        return $this->hasOne(LeadAssignment::class,'lead_id','id')->with('user_detail')->latest();
    }
}
