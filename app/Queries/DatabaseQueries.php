<?php

namespace App\Queries;

use App\Models\Lineup;
use App\Models\Config;
use App\Models\Franchise;
use App\Models\Matchup;
use App\Models\Waiver;
use App\Models\PlayerBase;

use DB;



/**
 *
 */

class DatabaseQueries
{
    public function getSeason()
    {
        return (int) Config::where('key', 'season')->pluck('value')->first();
    }

    public function nhlBio()
    {
        // skater

        $json = file_get_contents('https://api.nhle.com/stats/rest/skaters?isAggregate=false&reportType=basic&isGame=false&reportName=bios&cayenneExp=leagueId=133%20and%20gameTypeId=2%20and%20seasonId%3E='.$this->getSeason().'%20and%20seasonId%3C='.$this->getSeason());

        $array = json_decode($json, true);
        $data = $array["data"];

        foreach($data as $val) {
            PlayerBase::where('first_name', $val['playerFirstName'])
                ->where('last_name', $val['playerLastName'])
                ->update([
                    'id_nhl' => $val['playerId'],
                    'birth_date' => $val['playerBirthDate']
                ]);
        };

        // goalie

        $json = file_get_contents('https://api.nhle.com/stats/rest/goalies?isAggregate=false&reportType=goalie_basic&isGame=false&reportName=goaliebios&cayenneExp=leagueId=133%20and%20gameTypeId=2%20and%20seasonId>='.$this->getSeason().'%20and%20seasonId<='.$this->getSeason());

        $array = json_decode($json, true);
        $data = $array["data"];

        foreach($data as $val) {
            PlayerBase::where('first_name', $val['playerFirstName'])
                ->where('last_name', $val['playerLastName'])
                ->update([
                    'id_nhl' => $val['playerId'],
                    'birth_date' => $val['playerBirthDate']
                ]);
        };

        // team

        $json = file_get_contents('https://api.nhle.com/stats/rest/team?isAggregate=false&reportType=basic&isGame=false&reportName=teamsummary&cayenneExp=leagueId=133%20and%20gameTypeId=2%20and%20seasonId%3E='.$this->getSeason().'%20and%20seasonId%3C='.$this->getSeason());

        $array = json_decode($json, true);
        $data = $array["data"];

        foreach($data as $val) {
            PlayerBase::where('nhl', $val['teamAbbrev'])
                ->where('position', 't')
                ->update([
                    'id_nhl' => $val['teamId']
                ]);
        };
    }

    public function rotowireID()
    {
        $json = file_get_contents('https://www.rotowire.com/hockey/tables/stats.php?pos=goalie&season=2018'); // change season

        $data = json_decode($json, true);

        foreach($data as $val) {

            PlayerBase::where('first_name', $val['firstname'])
                ->where('last_name', $val['lastname'])
                ->update([
                    'id_rotowire' => $val['id'],
                ]);
        };
    }
}
