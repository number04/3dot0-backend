<?php

namespace App\Console;

use Illuminate\Console\Command;
use App\Queries\CommandQueries;
use App\Queries\ClaimQueries;

class ClaimCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theleague:claim';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'process waiver claims';

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
    public function handle(CommandQueries $command, ClaimQueries $claim)
    {
        $command->claim($claim);
    }
}
