<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    public function getTicketWindow()
    {
        return $this->belongsTo('App\TicketWindow','ticket_window_id');
        //return $this->hasOne('Office','office_id');
    }

    public function getTicket()
    {
        return $this->belongsTo('App\Ticket','ticket_id');
        //return $this->hasOne('Office','office_id');
    }

    public function getService()
    {
        return $this->belongsTo('App\Service','service_id');
        //return $this->hasOne('Office','office_id');
    }

    public function getOffice()
    {
        return $this->belongsTo('App\Office','office_id');
        //return $this->hasOne('Office','office_id');
    }

    public function getStaff()
    {
        return $this->belongsTo('App\Staff','staff_id');
        //return $this->hasOne('Office','office_id');
    }
}
