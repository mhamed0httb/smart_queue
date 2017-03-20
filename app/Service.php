<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //

    public function getCategory()
    {
        return $this->belongsTo('App\Category','category_id');
    }

    public function getCompany()
    {
        return $this->belongsTo('App\Company','company_id');
    }

    public function ticketWindows()
    {
        return $this->hasMany('App\TicketWindow','service_id');
    }
}
