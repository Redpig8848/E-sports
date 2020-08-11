<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllscheduleTable extends Migration
{
    /**
     * Run the migrations.
     * 所有赛程日程表
     * @return void
     */
    public function up()
    {
        Schema::create('allschedule', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gameimg')->comment('游戏图标');
            $table->string('gametype')->comment('游戏分类');
            $table->string('matchtime')->comment('比赛时间');
            $table->string('BO')->comment('赛制局数');
            $table->string('team1')->comment('参赛队伍1');
            $table->string('team1img')->comment('队伍1图标');
            $table->string('score')->comment('比分');
            $table->string('team2img')->comment('队伍2图标');
            $table->string('team2')->comment('参赛队伍2');
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
        Schema::dropIfExists('allschedule');
    }
}
