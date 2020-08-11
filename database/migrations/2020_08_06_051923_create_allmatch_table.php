<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllmatchTable extends Migration
{
    /**
     * Run the migrations.
     * 首页所有比赛展示未开始
     * @return void
     */
    public function up()
    {
        Schema::create('allmatch', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gameimg')->comment('游戏图标');
            $table->string('game')->comment('所属游戏');
            $table->string('time')->comment('时间');
            $table->string('BO')->comment('赛制局数');
            $table->string('team1')->comment('参赛队伍1');
            $table->string('team1img')->comment('参赛队1图标');
            $table->string('team2img')->comment('参赛队2图标');
            $table->string('team2')->comment('参赛队2');
            $table->string('eventsimg')->comment('所属赛事图标');
            $table->string('events')->comment('所属赛事');
            $table->integer('eventsid')->comment('所属赛事ID');
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
        Schema::dropIfExists('allmatch');
    }
}
