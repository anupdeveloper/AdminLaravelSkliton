<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrder extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'work_order'; 
    protected  $fillable = ['work_order_no','ticket_id','work_order_type','category','title','description','technician_id','user_id','status'];

    public function customer_detail()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    
    public function technician_detail()
    {
        return $this->belongsTo('App\Models\User','technician_id','id');
    }

    public function category_detail()
    {
        return $this->belongsTo('App\Models\Category','category','id');
    }

    
    public function ticket_detail()
    {
        return $this->belongsTo('App\Models\Ticket','ticket_id','id');
    }
    
    public function slot_detail()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function technician_assign_detail()
    {
        return $this->hasOne('App\Models\TechnicianAssignSlot','work_order_id','id')->with('slot_detail');
    }
    
    
}
