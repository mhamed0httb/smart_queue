<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdPlanning extends Model
{
    protected $table = 'ad_planning';

    public function getOffice()
    {
        return $this->belongsTo('App\Office','office_id');
    }

    public function getAd()
    {
        return $this->belongsTo('App\Advertisement','ad_id');
    }

    public function getPlanOffices()
    {
        return $this->hasMany('App\PlanOffices','plan_id');
    }
}
