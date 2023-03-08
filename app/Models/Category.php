<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'messages'; 
    protected  $fillable = ['request_id', 'receiver_id', 'message_text','message_image','message_audio_video','is_read','message_type','is_member_read'];

    public function profile_images(){
        return $this->hasMany(UserProfileImage::class,'user_id','receiver_id');
    }

    public function user_detail(){
        return $this->hasOne(User::class,'id','receiver_id');
    }

    public function member_detail(){
        return $this->hasMany(UserFamily::class,'user_id','receiver_id');
    }
    
}
