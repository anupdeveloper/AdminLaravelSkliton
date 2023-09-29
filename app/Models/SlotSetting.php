<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SlotSetting extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'slots_setiings'; 
    protected  $fillable = ['slot_name','slot_time'];

    public function slot_assigned()
    {
        return $this->hasOne(TechnicianAssignSlot::class,'slot_id','id');
        
    }
}
