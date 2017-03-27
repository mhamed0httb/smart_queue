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

    public function getCompany()
    {
        return $this->belongsTo('App\Company','company_id');
    }

    function staff() {
        return $this->hasMany('App\Staff','office_id');
    }

    function ticketWindow() {
        return $this->hasMany('App\TicketWindow','office_id');
    }

    function ticket() {
        return $this->hasMany('App\Ticket','office_id');
    }

    function ad() {
        return $this->hasMany('App\Advertisement','office_id');
    }


}
