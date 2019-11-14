<?php

namespace App\Console;

use Illuminate\Console\Command;
use App\Queries\CommandQueries;

class MatchupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theleague:matchup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run processes at end of matchup';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CommandQueries $command)
    {
        if ($command->getDate() != 1 && in_array($command->getDate(), $command->getStartDate())) {

            $command->matchup(); // increment matchup_id
            $command->standing(); // update standing table
            $command->adds(); // reset weekly_adds
            $command->award($command->king(), 'king'); // set matchup king
            $command->award($command->turkey(), 'turkey'); // set matchup turkey
        }
    }
}
