<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    function offices() {
        return $this->hasMany('App\Office','region_id');
    }
}
