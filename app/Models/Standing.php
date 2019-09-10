<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    protected $table = '_standing';

    public $timestamps = false;

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }
}
