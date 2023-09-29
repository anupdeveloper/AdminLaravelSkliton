<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Devinweb\LaravelHyperpay\Traits\ManageUserTransactions;
use Auth;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles, SoftDeletes;
    use ManageUserTransactions;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $guarded=[];
   protected $softDelete = true;
   public $appends = [ 'lat','lng' ];
   

    public function getlatAttribute()
    {
        return floatval($this->attributes['lat']);
    }

    public function getlngAttribute()
    {
        return floatval($this->attributes['lng']);
    }

    //    protected $appends=['about_me_arr'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // modifed obj
    // is_tribal obj
    public function getIsTribalObjAttribute(){
        $common_icon=CommonIcon::where('name','is_tribal')->first();

        return [
            'value'=>$this->is_tribal,
            'icon'=>$common_icon->icon??''
        ];
    }
    // -----------------

    public function customer_detail()
    {
        return $this->belongsTo(CustomerDetail::class,'id','user_id');
    }


}
