<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ClaimResource extends JsonResource
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
            'claimId' => $this->id,
            'isProcessed' => (int) $this->process,
            'isConfirmed' => (int) $this->confirm,
            'isSuccessfull' => (int) $this->success,
            'franchiseId' => (int) $this->franchise_id,
            'processDate' => Carbon::parse($this->waiver->created_at)->addDays(2)->format('D, j M'),
            'add' => [
                'playerId' => $this->waiver->player['id'],
                'playerName' => $this->waiver->player['player_name'],
                'playerNameShort' => $this->waiver->player['player_name_short'],
            ],

            'drop' => [
                'playerId' => $this->player['id'],
                'playerName' => $this->player['player_name'],
                'playerNameShort' => $this->player['player_name_short'],
            ]
        ];
    }
}
