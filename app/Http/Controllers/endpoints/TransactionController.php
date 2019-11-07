<?php

namespace App\Http\Controllers\endpoints;

use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Transaction;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function transaction()
    {
        return TransactionResource::collection($this->query()->orderBy('created_at', 'desc')->limit(10)->get());
    }

    public function query()
    {
        return QueryBuilder::for(Transaction::class)
                ->with([
                    'player'
                ])
                ->allowedFilters([
                    'franchise_id',
                    'type'
                ]);
    }
}
