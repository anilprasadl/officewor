<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model

{
    // const STATUS_ACTIVE = "ACTIVE";
    const STATUS_CREATED = "CREATED";
    const STATUS_ASSIGNED = "ASSIGNED";
    const STATUS_UNASSIGNED = "UNASSIGNED";
    const STATUS_COMPLETED = "COMPLETED";
    const STATUS_CANCELLED = "CANCELLED";
    use SoftDeletes;

    protected $fillable = ['title','start_date','end_date'];

    public function user()
    {
        return $this->hasMany('App\User');
    }

}