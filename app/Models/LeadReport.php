<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadReport extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'lead_report'; 
    protected  $fillable = ['lead_id','product_type','use_status','amc_status','paid_status','comment','has_water_purifier','in_use_water_purifier','has_chimney','in_use_chimney','chimney_status','waterpurifier_status'];

}
