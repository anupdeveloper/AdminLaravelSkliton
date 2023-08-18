<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrderReportPic extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'work_order_report_pic'; 
    protected  $fillable = ['wo_id','pic','status'];

   
}
