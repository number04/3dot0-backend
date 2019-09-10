<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');

Route::group(['middleware' => 'auth:api', ], function () {
    Route::get('me', 'AuthController@me');
    Route::get('config', 'endpoints\ConfigController@index');
    Route::get('claim', 'endpoints\ClaimController@claim');
    Route::get('rank:{matchup}', 'endpoints\RankController@rank');
    Route::get('standing:{matchup}', 'endpoints\StandingController@standing');

    Route::patch('watch', 'RosterController@watch');
    Route::patch('lineup', 'RosterController@lineup');
    Route::patch('keeper', 'RosterController@keeper');
    Route::patch('block', 'RosterController@block');
    Route::patch('need', 'RosterController@need');
    Route::patch('add-drop', 'TransactionController@addDrop');
    Route::patch('remove-claim', 'TransactionController@removeClaim');
    Route::patch('confirm-claim', 'TransactionController@confirmClaim');

    Route::group(['prefix' => '{date}'], function () {
        Route::get('players', 'endpoints\PlayerController@players');
        Route::get('player/{player}', 'endpoints\PlayerController@player')->name('player');

        Route::get('franchises', 'endpoints\FranchiseController@franchises');
        Route::get('scoreboard:{matchup}', 'endpoints\ScoreboardController@scoreboard');
    });

});
