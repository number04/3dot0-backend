<?php

namespace App\Queries;


use App\Models\Stat;
use App\Models\Config;
use App\Models\Date;
use App\Models\PlayerBase;

/**
 *
 */

class StatsQueries
{
    // getters

    public function getDate()
    {
        return (int) Config::where('key', 'date')->pluck('value')->first();
    }

    public function getSeason()
    {
        return (int) Config::where('key', 'season')->pluck('value')->first();
    }

    public function getYMD()
    {
        return Date::where('id', $this->getDate())->pluck('date')->first();
    }

    public function getYear()
    {
        // teams
        $json = file_get_contents('https://api.nhle.com/stats/rest/team?isAggregate=false&reportType=basic&isGame=false&reportName=teamsummary&cayenneExp=gameTypeId=2%20and%20seasonId%3E='.$this->getSeason().'%20and%20seasonId%3C='.$this->getSeason());

        $array = json_decode($json, true);
        $data = $array["data"];

        foreach($data as $val) {

            PlayerBase::where('nhl_id', $val['teamId'])
                ->update([
                    'games_played' => $val['gamesPlayed'],
                    'wins' => $val['wins'],
                    'losses' => $val['losses'],
                    'overtime_losses' => $val['otLosses'],
                    'goals_for' => $val['goalsFor'],
                    'goals_against' => $val['goalsAgainst']
                ]);
        };

        // skaters
        $json = file_get_contents('https://api.nhle.com/stats/rest/skaters?isAggregate=false&reportType=basic&isGame=false&reportName=skatersummary&cayenneExp=gameTypeId=2%20and%20seasonId%3E='.$this->getSeason().'%20and%20seasonId%3C='.$this->getSeason());
        $array = json_decode($json, true);
        $data = $array["data"];

        foreach($data as $val) {

            PlayerBase::where('nhl_id', $val['playerId'])
                ->update([
                    'nhl' => $val['playerTeamsPlayedFor'],
                    'games_played' => $val['gamesPlayed'],
                    'goals' => $val['goals'],
                    'assists' => $val['assists'],
                    'shots' => $val['shots']
                ]);
        };

        $json = file_get_contents('https://api.nhle.com/stats/rest/skaters?isAggregate=false&reportType=basic&isGame=false&reportName=realtime&cayenneExp=gameTypeId=2%20and%20seasonId%3E='.$this->getSeason().'%20and%20seasonId%3C='.$this->getSeason());
        $array = json_decode($json, true);
        $data = $array["data"];

        foreach($data as $val) {

            PlayerBase::where('nhl_id', $val['playerId'])
                ->update([
                    'faceoff_wins' => $val['faceoffsWon'],
                    'hits' => $val['hits'],
                    'blocked_shots' => $val['blockedShots']
                ]);
        };

        // goalies
        $json = file_get_contents('https://api.nhle.com/stats/rest/goalies?isAggregate=false&reportType=goalie_basic&isGame=false&reportName=goaliesummary&cayenneExp=gameTypeId=2%20and%20seasonId%3E='.$this->getSeason().'%20and%20seasonId%3C='.$this->getSeason());
        $array = json_decode($json, true);
        $data = $array["data"];

        foreach($data as $val) {

            PlayerBase::where('nhl_id', $val['playerId'])
                ->update([
                    'games_played' => $val['gamesPlayed'],
                    'wins' => $val['wins'],
                    'losses' => $val['losses'],
                    'overtime_losses' => $val['otLosses'],
                    'goals_against' => $val['goalsAgainst'],
                    'saves' => $val['saves'],
                    'time_on_ice' =>$val['timeOnIce']
                ]);
        };
    }

    public function getDaily()
    {
        // teams
        $json = file_get_contents('https://api.nhle.com/stats/rest/team?isAggregate=false&reportType=basic&isGame=true&reportName=teamsummary&cayenneExp=leagueId=133%20and%20gameDate%3E=%22'.$this->getYMD().'%22%20and%20gameDate%3C=%22'.$this->getYMD().'%2023:59:59%22%20and%20gameTypeId=2');

        $array = json_decode($json, true);
        $data = $array["data"];

        foreach($data as $val) {

            PlayerBase::join('stats', 'player.id', '=', 'stats.player_id')
                ->where('nhl_id', $val['teamId'])
                ->where('stats.date_id', $this->getDate())
                ->update([
                    'stats.games_played' => $val['gamesPlayed'],
                    'stats.wins' => $val['wins'],
                    'stats.losses' => $val['losses'],
                    'stats.overtime_losses' => $val['otLosses'],
                    'stats.goals_for' => $val['goalsFor'],
                    'stats.goals_against' => $val['goalsAgainst']
                ]);
        };

        // skaters
        $json = file_get_contents('https://api.nhle.com/stats/rest/skaters?isAggregate=false&reportType=basic&isGame=true&reportName=skatersummary&cayenneExp=leagueId=133%20and%20gameDate%3E=%222019-10-08%22%20and%20gameDate%3C=%222019-10-08%2023:59:59%22%20and%20gameTypeId=2');

        $array = json_decode($json, true);
        $data = $array["data"];

        foreach($data as $val) {

            PlayerBase::join('stats', 'player.id', '=', 'stats.player_id')
                ->where('nhl_id', $val['playerId'])
                ->where('stats.date_id', '8')
                ->update([
                    'stats.games_played' => $val['gamesPlayed'],
                    'stats.goals' => $val['goals'],
                    'stats.assists' => $val['assists'],
                    'stats.shots' => $val['shots']
                ]);
        };

        $json = file_get_contents('https://api.nhle.com/stats/rest/skaters?isAggregate=false&reportType=basic&isGame=true&reportName=realtime&cayenneExp=leagueId=133%20and%20gameDate%3E=%22'.$this->getYMD().'%22%20and%20gameDate%3C=%22'.$this->getYMD().'%2023:59:59%22%20and%20gameTypeId=2');

        $array = json_decode($json, true);
        $data = $array["data"];

        foreach($data as $val) {

            PlayerBase::join('stats', 'player.id', '=', 'stats.player_id')
                ->where('nhl_id', $val['playerId'])
                ->where('stats.date_id', $this->getDate())
                ->update([
                    'stats.faceoff_wins' => $val['faceoffsWon'],
                    'stats.hits' => $val['hits'],
                    'stats.blocked_shots' => $val['blockedShots']
                ]);
        };

        // goalies
        $json = file_get_contents('https://api.nhle.com/stats/rest/goalies?isAggregate=false&reportType=basic&isGame=true&reportName=goaliesummary&cayenneExp=leagueId=133%20and%20gameDate%3E=%22'.$this->getYMD().'%22%20and%20gameDate%3C=%22'.$this->getYMD().'%2023:59:59%22%20and%20gameTypeId=2');

        $array = json_decode($json, true);
        $data = $array["data"];

        foreach($data as $val) {

            PlayerBase::join('stats', 'player.id', '=', 'stats.player_id')
                ->where('nhl_id', $val['playerId'])
                ->where('stats.date_id', $this->getDate())
                ->update([
                    'stats.games_played' => $val['gamesPlayed'],
                    'stats.wins' => $val['wins'],
                    'stats.losses' => $val['losses'],
                    'stats.overtime_losses' => $val['otLosses'],
                    'stats.saves' => $val['saves'],
                    'stats.goals_against' => $val['goalsAgainst'],
                    'stats.time_on_ice' => $val['timeOnIce']
                ]);
        };
    }
}
