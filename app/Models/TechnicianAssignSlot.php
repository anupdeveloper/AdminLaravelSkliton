<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicianAssignSlot extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'technian_slot'; 
    protected  $fillable = ['user_id','work_order_id','slot_id','status','date'];

    public function slot_detail()
    {
        return $this->belongsTo(SlotSetting::class,'slot_id','id');
    }

    

    
    public function work_order_deatil()
    {
        return $this->belongsTo(WorkOrder::class,'work_order_id','id')->with('category_detail','customer_detail');
    }

}
