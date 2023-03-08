<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;
    protected $table = 'user_notifications';

    protected $guarded=[];

    protected  $fillable = [
        'message_ar',
        'message_en',
        'sender_id',
        'receiver_ids',
        'key1',
        'key2',
        'notification_type',
        'is_read',
    ];

    public function user_detail(){
        return $this->belongsTo(User::class,'sender_id','id');
    }

}

