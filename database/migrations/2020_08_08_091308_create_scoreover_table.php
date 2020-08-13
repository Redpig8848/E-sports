<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreoverTable extends Migration
{
    /**
     * Run the migrations.
     * 比分表 完场比赛
     * @return void
     */
    public function up()
    {
        Schema::create('scoreover', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gameimg')->comment('游戏图标');
            $table->string('game')->comment('所属游戏');
            $table->string('time')->comment('开始时间');
            $table->string('BO')->comment('BO数');
            $table->string('team1')->comment('队伍1');
            $table->string('team1img')->comment('队伍1图标');
            $table->string('score')->comment('比分');
            $table->string('team2img')->comment('队伍2图标');
            $table->string('team2')->comment('队伍2');
            $table->string('eventsimg')->comment('赛事图标');
            $table->string('events')->comment('赛事');
            $table->integer('eventsid')->comment('赛事id');
            $table->string('exponent')->comment('指数');

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
        Schema::dropIfExists('scoreover');
    }
}
