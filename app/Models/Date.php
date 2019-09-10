<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $table = 'date';

    public $timestamps = false;

    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }

    public function lineup()
    {
        return $this->hasOne(Lineup::class);
    }
}
