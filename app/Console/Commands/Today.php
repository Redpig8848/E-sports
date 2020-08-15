<?php

namespace App\Console\Commands;

use App\Http\Controllers\ScheduleController;
use Illuminate\Console\Command;

class Today extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //
        $schedule = new ScheduleController();
        $schedule->today();
    }
}
