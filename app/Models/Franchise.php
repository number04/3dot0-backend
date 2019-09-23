<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    protected $table = 'franchise';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function player()
    {
        return $this->hasMany(Player::class);
    }

    public function scoreboard()
    {
        return $this->hasMany(Scoreboard::class);
    }

    public function standing()
    {
        return $this->hasMany(Standing::class);
    }

    public function lineup()
    {
        return $this->hasMany(Lineup::class, 'franchise_id', 'id');
    }

    public function need()
    {
        return $this->hasOne(Need::class);
    }
}
