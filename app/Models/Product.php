<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'products'; 
    protected  $fillable = ['category_id','product_name','no_of_service','price_per_service','product_desc','actual_price','sale_price'];


    public function product_images()
    {
        return $this->hasMany(ProductGallery::class,'product_id','id')->whereNotNull('image');
    }

    public function cetegory()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }

}
