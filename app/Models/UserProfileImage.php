<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class UserProfileImage extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function getProfileImgAttribute($value){
        //return asset('/storage/'.$value);
        //return Storage::disk('s3')->url($value);
        return env('S3_URL').$value;
    }


}
