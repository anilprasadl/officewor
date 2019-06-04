<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model

{
    const STATUS_ACTIVE = "ACTIVE";
    const STATUS_COMPLETED = "COMPLETED";
    use SoftDeletes;

    protected $fillable = ['title','start_date','end_date'];

}