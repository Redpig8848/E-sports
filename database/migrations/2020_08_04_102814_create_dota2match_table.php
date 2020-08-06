<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDota2matchTable extends Migration
{
    /**
     * Run the migrations.
     * 刀塔2首页展示比赛
     * @return void
     */
    public function up()
    {
        Schema::create('dota2match', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gameimg')->comment('游戏图标');
            $table->string('time')->comment('时间');
            $table->string('BO')->comment('赛制局数');
            $table->string('team1')->comment('参赛队伍1');
            $table->string('team1img')->comment('参赛队1图标');
            $table->string('team2img')->comment('参赛队2图标');
            $table->string('team2')->comment('参赛队2');
            $table->string('eventsimg')->comment('所属赛事图标');
            $table->string('events')->comment('所属赛事');
            $table->integer('eventsid')->comment('所属赛事ID');
            $table->integer('ing')->default(0)->comment('是否正在进行');
            $table->string('TV')->comment('直播地址');
            $table->string('now')->comment('当前局数');
            $table->string('pooreconomy')->comment('经济差');
            $table->integer('team1winnum')->comment('队伍1胜利局数');
            $table->integer('team1killnum')->comment('队伍1杀敌数');
            $table->string('team1special')->comment('队伍1特殊图');
            $table->integer('team2winnum')->comment('队伍2胜利局数');
            $table->integer('team2killnum')->comment('队伍2杀敌数');
            $table->string('team2special')->comment('队伍2特殊图');
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
        Schema::dropIfExists('dota2match');
    }
}
