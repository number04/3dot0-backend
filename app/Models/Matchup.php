<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matchup extends Model
{
    protected $table = 'matchup';

    public $timestamps = false;

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }
}
