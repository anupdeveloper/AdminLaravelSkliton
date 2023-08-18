<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'tickets'; 
    protected  $fillable = ['ticket_no','user_id','title','description','created_by','image','category_id','status'];

    public function technician_detail()
    {
        return $this->hasOne(WorkOrder::class,'ticket_id','id')->with('technician_detail');
    }

    
    public function customer_detail()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
