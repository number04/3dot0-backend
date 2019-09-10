<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Need extends Model
{
    protected $table = 'needs';

    public $timestamps = false;

    protected $hidden = ['franchise_id'];
}
