<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'orders'; 
    protected  $fillable = ['order_id','user_id','total_amt','order_status','payment_mode'];

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }

}
