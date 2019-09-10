<?php

namespace App\Console;

use Illuminate\Console\Command;
use App\Queries\CommandQueries;

class LineupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theleague:lineup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'disable lineup movement after game starts';

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
        $command->lineup();
    }
}
