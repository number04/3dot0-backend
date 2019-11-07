<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

}
