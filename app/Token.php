<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'tokens';

    public function getUser()
    {
        return $this->belongsTo('Cartalyst\Sentinel\Users\EloquentUser','user_id');
    }
}
