<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerDetail extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'customer_detail'; 
    protected  $fillable = ['user_id','alt_mobile','user_type','product_type','no_services','amc_duration','model_taken'];

}
