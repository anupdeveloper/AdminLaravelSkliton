<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'order_detail'; 
    protected  $fillable = ['order_id','product_id','product_qty','order_date'];

    public function product_detail()
    {
        return $this->hasOne(Product::class,'id','product_id')->with('product_images');
    }

    // public function product_images()
    // {
    //     return $this->hasMany(ProductGallery::class,'product_id','product_id');
    // }

}
