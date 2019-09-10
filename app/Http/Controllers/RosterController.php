<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Queries\RosterQueries;

class RosterController extends Controller
{
    public function watch(Request $request, RosterQueries $roster)
    {
        $roster->watch($request->player, $request->franchise, $request->watch);
    }

    public function lineup(Request $request, RosterQueries $roster)
    {
        foreach ($request->players as $player) {
            $roster->lineup(
                $player['playerId'],
                $request->date,
                $player['games']['today']['lineup'],
                $player['franchiseId']
            );
        }

        return response()->json([
            'lineup' => 'lineup set'
        ]);
    }

    public function keeper(Request $request, RosterQueries $roster)
    {
        $roster->keeper($request->player, $request->keeper);
        $roster->cap($request->franchise, $request->keeper, $request->cap);
    }

    public function block(Request $request, RosterQueries $roster)
    {
        $roster->block($request->player, $request->block);
    }

    public function need(Request $request, RosterQueries $roster)
    {
        $roster->need($request->franchise, $request->need);
    }
}
