<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulematchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedulematch', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event')->comment('所属赛事');
            $table->string('eventid')->comment('所属赛事ID');
            $table->string('time')->comment('时间');
            $table->string('team1img')->comment('队伍1图标');
            $table->string('team1')->comment('队伍1');
            $table->string('score')->comment('比分');
            $table->string('team2img')->comment('队伍2图标');
            $table->string('team2')->comment('队伍2');
            $table->string('BO')->comment('BO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedulematch');
    }
}
