<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
\Carbon\Carbon::setToStringFormat('d-m-Y');

class User extends Authenticatable implements MustVerifyEmail
{
    // protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // protected $dateFormat = 'U';
    
    use SoftDeletes;
    use Notifiable;

    const STATUS_IS_ADMIN = "YES";
    const STATUS_IS_NOT_ADMIN = "NO";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function events()
        {
                return $this->hasMany('App\Event');
        }
}
