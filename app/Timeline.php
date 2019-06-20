<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;
// \Carbon\Carbon::setToStringFormat('d-m-Y');
class Timeline extends Model
{
    // protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // protected $dateFormat = 'U';
    
    public function getMyDateFormat()
    {
        return \Carbon\Carbon::createFromFormat($this->attributes['updated_at'], 'd/m/Y')->toDateTimeString();
    }
}
