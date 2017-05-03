<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanOffices extends Model
{
    protected $table = 'plan_offices';

    public function getOffice()
    {
        return $this->belongsTo('App\Office','office_id');
    }

    public function getPlan()
    {
        return $this->belongsTo('App\AdPlanning','plan_id');
    }
}
