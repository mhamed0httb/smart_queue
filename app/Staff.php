<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table ='staffs';

    public function getOffice()
    {
        return $this->belongsTo('App\Office','office_id');
    }
}
