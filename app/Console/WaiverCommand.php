<?php

namespace App\Console;

use Illuminate\Console\Command;
use App\Queries\CommandQueries;

class WaiverCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theleague:waiver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'take player off waivers if no claims';

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
        $command->waiver();
    }
}
