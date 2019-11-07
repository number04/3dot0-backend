<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $table = 'claim';

    public $timestamps = false;

    public function waiver()
    {
        return $this->belongsTo(Waiver::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_drop', 'id');
    }

}
