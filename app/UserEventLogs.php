<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class UserEventLogs extends Model
{   
    use SoftDeletes;
    use Notifiable;


    public function events()
        {
                return $this->hasMany('App\Event');
        }

    public function user()
        {
            return $this->hasMany('App\User');
        }
}
