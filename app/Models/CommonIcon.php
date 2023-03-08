<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonIcon extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function getIconAttribute($value){
        return asset('/storage/'.$value);
    }
}
