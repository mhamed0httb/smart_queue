<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdCompany extends Model
{
    protected $table = 'ad_companies';

    function responsible() {
        return $this->belongsTo('App\AdResponsible','responsible_id');
    }

    function ad() {
        return $this->hasMany('App\Advertisement','company_id');
    }
}
