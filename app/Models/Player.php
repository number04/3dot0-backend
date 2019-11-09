<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Player extends Model
{
    protected $table = '_player';

    public $timestamps = false;

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class, 'team', 'nhl');
    }

    public function stat()
    {
        return $this->hasOne(StatBase::class);
    }

    public function lineup()
    {
        return $this->hasOne(Lineup::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function waiver()
    {
        return $this->hasMany(Waiver::class);
    }

    private function onWaivers()
    {
        return Waiver::where('player_id', $this->id)->where('active', 1);
    }

    public function getWaiversAttribute()
    {
        if ($this->onWaivers()->count() >= 1) {
            return Carbon::parse($this->onWaivers()->first()->created_at)->addDays(2)->format('j/m');
        }

        return NULL;
    }

    public function getWatchingAttribute()
    {
        $json = json_decode($this->watch, true);
        $franchise = Franchise::where('user_id', auth()->id())->first()->id;

        if (isset( $json[$franchise] )) {
            return 1;
        }

        return 0;
    }

    public function scopePosition($query, $position = ['C','L','R','D'])
    {
        if ($position === ['C','L','R','D']) {
            return $query->whereIn('position', $position)->orWhereIn('position_secondary', $position);
        }

        return $query->whereIn('position', [$position])->orWhereIn('position_secondary', [$position]);
    }
}
