<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadReport extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'lead_report'; 
    protected  $fillable = ['lead_id','has_water_purifier','in_use_water_purifier','has_chimney','in_use_chimney','chimney_status','waterpurifier_status'];

}
