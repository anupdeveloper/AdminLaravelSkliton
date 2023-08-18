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
    protected  $fillable = ['name','address','email','phone'];

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
}
