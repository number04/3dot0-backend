<?php

namespace App\Console;

use Illuminate\Console\Command;
use App\Queries\CommandQueries;

class AwardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theleague:award';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'count weekly awards';

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
        $command->award($command->king(), 'king');
        $command->award($command->turkey(), 'turkey');
    }
}
