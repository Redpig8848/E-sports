<?php

namespace App\Console\Commands;

use App\Http\Controllers\InformationSpiderController;
use Illuminate\Console\Command;

class gok extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:gok';

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
        $information  = new InformationSpiderController();
        $information->gok();
    }
}
