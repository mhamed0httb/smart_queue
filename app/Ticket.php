<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';

    public function getOffice()
    {
        return $this->belongsTo('App\Office','office_id');
    }

    public function getTicketWindow()
    {
        return $this->belongsTo('App\TicketWindow','ticket_window_id');
    }
}
