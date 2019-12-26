<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function vol()
    {
        return $this->belongsTo(Vol::class);
    }
}
