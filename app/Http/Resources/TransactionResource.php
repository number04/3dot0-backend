<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'franchiseId' => (int) $this->franchise_id,
            'transaction' => [
                'date' => Carbon::parse($this->created_at)->subHours($this->timezone())->format('j M'),
                'type' => $this->type($this->type),
                'player' => [
                    'playerName' => $this->player['player_name'],
                    'playerNameShort' => $this->player['player_name_short'],
                    'nhl' => $this->player['nhl'],
                    'position' => $this->player['position'],
                    'positionSecondary' => $this->player['position_secondary'],
                    'isInjured' => (int) $this->player['injury_status'],
                    'href' => route('player', ['date' => $this->date(), 'player' => $this->id])
                ]
            ]
        ];
    }

    private function date()
    {
        return DB::table('config')->where('key', '=', 'date')->first()->value;
    }

    private function timezone()
    {
        return abs((int) DB::table('config')->where('key', '=', 'conversion')->first()->value);
    }

    private function type($value)
    {
        if ($value === 'add') {
            return 'sign';
        }

        return $value;
    }
}
