<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    function service() {
        return $this->hasMany('App\Service','company_id');
    }

    function manager() {
        return $this->hasMany('Cartalyst\Sentinel\Users\EloquentUser','company_id');
    }
}
