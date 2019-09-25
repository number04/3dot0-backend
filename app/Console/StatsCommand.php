<?php

namespace App\Console;

use Illuminate\Console\Command;
use App\Queries\StatsQueries;

class StatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theleague:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update stats';

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
    public function handle(StatsQueries $stats)
    {
        $stats->getYear();
        $stats->getDaily();
    }
}
