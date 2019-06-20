<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
\Carbon\Carbon::setToStringFormat('d-m-Y');

use Illuminate\Database\Eloquent\Model;

class UserEventLogs extends Model
{   
    // protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // protected $dateFormat = 'U';
    
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
