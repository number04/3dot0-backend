<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Queries\TransactionQueries;
use App\Models\Player;

class TransactionController extends Controller
{
    public function playerName($request)
    {
        return Player::where('id', $request)->pluck('player_name_short')->first();
    }

    public function addDrop(Request $request, TransactionQueries $transaction)
    {

        if ($transaction->countWaiver($request->add) > 0) {

            return $transaction->createClaim($request->add, $request->franchise, $request->waiver, $request->drop, $request->matchup);
        }

        if ($request->add) {

            if ($request->count === 4) {
                return;
            }

            $transaction->add($request->add, $request->franchise);
            $transaction->lineup($request->add, $request->franchise, $request->date, 'b');
            $transaction->transaction($request->add, $request->franchise, 'add');
        }

        if ($request->drop) {

            if ($request->keeper) {

                $transaction->cap($request->franchise, $request->cap);
            }

            $transaction->drop($request->drop);
            $transaction->lineup($request->drop, 0, $request->date, 0);
            $transaction->waiver($request->drop);
            $transaction->transaction($request->drop, $request->franchise, 'drop');
        }

        return response()->json([
            'added' => $this->playerName($request->add),
            'dropped' => $this->playerName($request->drop)
        ]);
    }

    public function removeClaim(Request $request, TransactionQueries $transaction)
    {
        $transaction->removeClaim($request->claim, $request->franchise);
    }

    public function confirmClaim(Request $request, TransactionQueries $transaction)
    {
        $transaction->confirmClaim($request->claim);
    }
}
