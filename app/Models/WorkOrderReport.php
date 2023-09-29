<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrderReport extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'work_order_report'; 
    protected  $fillable = ['technician_id','task_id','comment','status'];

   
}
