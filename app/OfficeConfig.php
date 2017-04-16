<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfficeConfig extends Model
{
    protected $table = 'office_config';

    public function getOffice()
    {
        return $this->belongsTo('App\Office','office_id');
    }
}
