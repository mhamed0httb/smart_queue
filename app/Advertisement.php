<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $table = 'advertisements';

    public function getCompany()
    {
        return $this->belongsTo('App\AdCompany','company_id');
    }
}
