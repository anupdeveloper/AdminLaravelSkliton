<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadAssignment extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'lead_assignment'; 
    protected  $fillable = ['lead_id','follow_up_date','added_by','comment','user_id','assign_date','status'];


    public function lead_detail()
    {
        return $this->belongsTo(Lead::class,'lead_id','id');
    }


    public function user_detail()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
