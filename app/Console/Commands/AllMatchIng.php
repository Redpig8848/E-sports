<?php

namespace App\Console\Commands;

use App\Http\Controllers\HomeSpiderController;
use Illuminate\Console\Command;
use Illuminate\Routing\Route;

class AllMatchIng extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:AllMatchIng';

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
        $home = new HomeSpiderController();
        $home->index();
    }
}
