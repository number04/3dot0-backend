<?php

namespace App\Console;

use Illuminate\Console\Command;
use App\Queries\CommandQueries;

class DateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theleague:date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'increment date';

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
        $command->date();
    }
}
