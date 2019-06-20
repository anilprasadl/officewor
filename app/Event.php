<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
\Carbon\Carbon::setToStringFormat('d-m-Y');

class Event extends Model

{
    // protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // protected $dateFormat = 'U';
    
    // const STATUS_ACTIVE = "ACTIVE";
    const STATUS_CREATED = "CREATED";
    const STATUS_ASSIGNED = "ASSIGNED";
    const STATUS_UNASSIGNED = "UNASSIGNED";
    const STATUS_REASSIGNED = "REASSIGNED";
    const STATUS_COMPLETED = "COMPLETED";
    const STATUS_CANCELLED = "CANCELLED";
    const USER_STATE_RU = 'Resource Unavailable';
    const USER_STATE_RS = 'Rescheduled';
    const USER_STATE_CW = 'Code Withdrawal';
    const USER_STATE_OTHER = 'Other';
    const ADMIN_STATE_COMPLETED = 'Completed';
    const ADMIN_STATE_RS = 'Rescheduled';
    const ADMIN_STATE_DE = 'Deployment Error';
    const ADMIN_STATE_OTHER = 'Other';

    use SoftDeletes;

    protected $fillable = ['title','start_date','end_date'];

    public function user()
    {
        return $this->hasMany('App\User');
    }

}