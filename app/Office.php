<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $table = 'offices';

    /*public function hasTicketWindows()
    {
        return $this->hasMany('App\TicketWindow','office_id');
    }*/

    public function getRegion()
    {
        return $this->belongsTo('App\Region','region_id');
    }

    public function getManager()
    {
        return $this->belongsTo('Cartalyst\Sentinel\Users\EloquentUser','manager_id');
    }


}
