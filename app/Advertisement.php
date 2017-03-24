<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $table = 'advertisements';

    public function getOffice()
    {
        return $this->belongsTo('App\Office','office_id');
    }
}
