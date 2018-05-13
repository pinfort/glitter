<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\Glitter\Glitter;
use App\Lib\Glitter\Tweet;

class getGitLabEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gitlab:events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'show gitlab events';

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
    public function handle()
    {
        $glitter = new Glitter();
        $glitter->showEvents();
    }
}
