<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waiver extends Model
{
    protected $table = 'waiver';

    public $timestamps = false;

    public function claim()
    {
        return $this->hasMany(Claim::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
