<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

class FranchiseResource extends JsonResource
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
            'franchiseId' => $this->id,
            'franchiseName' => $this->franchise_name,
            'franchiseTag' => $this->franchise_tag,
            'cap' => (int) $this->cap_hit,
            'needs' => $this->need,
            'skater' => PlayersResource::collection(
                $this->player->whereIn('position', ['c', 'r', 'l', 'd'])
            ),
            'goalie' => PlayersResource::collection(
                $this->player->whereIn('position', ['g'])
            ),
            'team' => PlayersResource::collection(
                $this->player->whereIn('position', ['t'])
            )
        ];
    }
}
