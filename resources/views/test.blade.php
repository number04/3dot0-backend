<div class="container">
    <?php

    use App\Models\PlayerBase;

    // schedule

    // function schedule()
    // {
    //     $json = file_get_contents('https://statsapi.web.nhl.com/api/v1/schedule?startDate=2019-10-02&endDate=2020-04-04&hydrate=team');
    //     $array = json_decode($json, true);
    //     $data = $array["dates"];
    //
    //     foreach($data as $games) {
    //
    //
    //         foreach($games['games'] as $game) {
    //             print($games['date']). ',  ';
    //             print($game['gameDate']. ' , ' .$game['teams']['away']['team']['abbreviation']. ' @' . $game['teams']['home']['team']['abbreviation']);
    //             echo '<br>';
    //         }
    //     };
    // }
    //
    // schedule();

    // goalie

    // function yearGoalie()
    // {
    //     $json = file_get_contents('https://api.nhle.com/stats/rest/goalies?isAggregate=false&reportType=basic&isGame=false&reportName=goaliesummary&cayenneExp=leagueId=133%20and%20gameTypeId=2%20and%20seasonId>=20182019%20and%20seasonId<=20182019');
    //     $array = json_decode($json, true);
    //     $data = $array["data"];
    //
    //     foreach($data as $val) {
    //
    //         PlayerBase::where('last_name', $val['playerLastName'])
    //             ->where('birth_date', $val['playerBirthDate'])
    //             ->where('position', 'g')
    //             ->update([
    //                 'nhl' => $val['playerTeamsPlayedFor'],
    //                 'games_played' => $val['gamesPlayed'],
    //                 'wins' => $val['wins'],
    //                 'losses' => $val['losses'],
    //                 'overtime_losses' => $val['otLosses'],
    //                 'saves' => $val['saves'],
    //                 'goals_against' => $val['goalsAgainst'],
    //                 'time_on_ice' =>$val['timeOnIce']
    //             ]);
    //     };
    //
    //     echo('done');
    // }
    //
    // yearGoalie();

    // skater

    // function yearSkater()
    // {
    //     $json = file_get_contents('https://api.nhle.com/stats/rest/skaters?isAggregate=false&reportType=basic&isGame=false&reportName=skatersummary&cayenneExp=leagueId=133%20and%20gameTypeId=2%20and%20seasonId>=20182019%20and%20seasonId<=20182019');
    //     $array = json_decode($json, true);
    //     $data = $array["data"];
    //
    //     foreach($data as $val) {
    //
    //         PlayerBase::where('last_name', $val['playerLastName'])
    //             ->where('birth_date', $val['playerBirthDate'])
    //             ->whereIn('position', ['C', 'L', 'R', 'D'])
    //             ->update([
    //                 'nhl' => $val['playerTeamsPlayedFor'],
    //                 'games_played' => $val['gamesPlayed'],
    //                 'goals' => $val['goals'],
    //                 'assists' => $val['assists'],
    //
    //             ]);
    //     };
    //
    //     $json = file_get_contents('https://api.nhle.com/stats/rest/skaters?isAggregate=false&reportType=basic&isGame=false&reportName=realtime&cayenneExp=leagueId=133%20and%20gameTypeId=2%20and%20seasonId>=20182019%20and%20seasonId<=20182019');
    //     $array = json_decode($json, true);
    //     $data = $array["data"];
    //
    //     foreach($data as $val) {
    //
    //         PlayerBase::where('last_name', $val['playerLastName'])
    //             ->where('birth_date', $val['playerBirthDate'])
    //             ->whereIn('position', ['c', 'l', 'r', 'd'])
    //             ->update([
    //                 'faceoff_wins' => $val['faceoffsWon'],
    //                 'hits' => $val['hits'],
    //                 'shots' => $val['shots'],
    //                 'blocked_shots' => $val['blockedShots']
    //             ]);
    //     };
    //
    //     echo('done');
    // }
    //
    // yearSkater();

    // team

    // function yearTeam()
    // {
    //     $json = file_get_contents('https://api.nhle.com/stats/rest/team?isAggregate=false&reportType=basic&isGame=false&reportName=teamsummary&cayenneExp=leagueId=133%20and%20gameTypeId=2%20and%20seasonId>=20182019%20and%20seasonId<=20182019');
    //
    //     $array = json_decode($json, true);
    //     $data = $array["data"];
    //
    //     foreach($data as $val) {
    //
    //         PlayerBase::where('nhl', $val['teamAbbrev'])
    //             ->where('position', 't')
    //             ->update([
    //                 'games_played' => $val['gamesPlayed'],
    //                 'wins' => $val['wins'],
    //                 'losses' => $val['losses'],
    //                 'overtime_losses' => $val['otLosses'],
    //                 'goals_for' => $val['goalsFor'],
    //                 'goals_against' => $val['goalsAgainst']
    //             ]);
    //     };
    //
    //     echo('done');
    // }
    //
    // yearTeam();

    // function insertPlayer()
    // {
    //     $json = file_get_contents('https://api.nhle.com/stats/rest/skaters?isAggregate=false&reportType=basic&isGame=false&reportName=skatersummary&cayenneExp=leagueId=133%20and%20gameTypeId=2%20and%20seasonId>=20182019%20and%20seasonId<=20182019');
    //         $array = json_decode($json, true);
    //         $data = $array["data"];
    //
    //         foreach($data as $val) {
    //
    //             DB::statement('
    //                 INSERT INTO player (
    //                     first_name,
    //                     last_name,
    //                     birth_date,
    //                     birth_city,
    //                     birth_province,
    //                     birth_country,
    //                     position,
    //                     nhl
    //                 )
    //                 SELECT * FROM (
    //                     SELECT
    //                     "' . $val['playerFirstName'] . '",
    //                     "' . $val['playerLastName'] . '",
    //                     "' . $val['playerBirthDate'] . '",
    //                     "' . $val['playerBirthCity'] . '",
    //                     "' . $val['playerBirthStateProvince'] . '",
    //                     "' . $val['playerBirthCountry'] . '",
    //                     "' .  strtolower($val['playerPositionCode']) . '",
    //                     "' . $val['playerTeamsPlayedFor'] . '"
    //                 ) AS x
    //                 WHERE NOT EXISTS (
    //                 SELECT last_name, birth_date
    //                 FROM player
    //                 WHERE last_name = "' . $val['playerLastName'] . '"
    //                 AND birth_date = "' . $val['playerBirthDate'] . '"
    //                 ) LIMIT 1
    //             ');
    //         };
    //
    //         $json = file_get_contents('https://api.nhle.com/stats/rest/goalies?isAggregate=false&reportType=basic&isGame=false&reportName=goaliesummary&cayenneExp=leagueId=133%20and%20gameTypeId=2%20and%20seasonId>=20182019%20and%20seasonId<=20182019');
    //             $array = json_decode($json, true);
    //             $data = $array["data"];
    //
    //             foreach($data as $val) {
    //
    //                 DB::statement('
    //                     INSERT INTO player (
    //                         first_name,
    //                         last_name,
    //                         birth_date,
    //                         birth_city,
    //                         birth_province,
    //                         birth_country,
    //                         position,
    //                         nhl
    //                     )
    //                     SELECT * FROM (
    //                         SELECT
    //                         "' . $val['playerFirstName'] . '",
    //                         "' . $val['playerLastName'] . '",
    //                         "' . $val['playerBirthDate'] . '",
    //                         "' . $val['playerBirthCity'] . '",
    //                         "' . $val['playerBirthStateProvince'] . '",
    //                         "' . $val['playerBirthCountry'] . '",
    //                         "' .  strtolower($val['playerPositionCode']) . '",
    //                         "' . $val['playerTeamsPlayedFor'] . '"
    //                     ) AS x
    //                     WHERE NOT EXISTS (
    //                     SELECT last_name, birth_date
    //                     FROM player
    //                     WHERE last_name = "' . $val['playerLastName'] . '"
    //                     AND birth_date = "' . $val['playerBirthDate'] . '"
    //                     ) LIMIT 1
    //                 ');
    //             };
    //
    //         echo('done');
    // }
    //
    // insertPlayer();

    ?>
</div>
