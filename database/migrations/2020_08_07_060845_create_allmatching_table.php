<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllmatchingTable extends Migration
{
    /**
     * Run the migrations.
     * 首页展示所有正在进行游戏
     * @return void
     */
    public function up()
    {
        Schema::create('allmatching', function (Blueprint $table) {
            $table->increments('id');
            $table->string('eventsimg')->comment('所属赛事图标');
            $table->string('events')->comment('所属赛事');
            $table->string('game')->comment('所属游戏');
            $table->integer('eventsid')->comment('所属赛事ID');
            $table->text('tv')->comment('直播地址');
            $table->string('now')->comment('当前局数');
            $table->string('BO')->comment('赛制局数');
            $table->string('pooreconomy')->comment('经济差');
            $table->string('team1img')->comment('队伍1图标');
            $table->string('team1')->comment('队伍1');
            $table->integer('team1winnum')->comment('队伍1胜利局数');
            $table->integer('team1killnum')->comment('队伍1杀敌数');
            $table->string('team1special')->comment('队伍1特殊图');
            $table->string('team2img')->comment('队伍2图标');
            $table->string('team2')->comment('队伍2');
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
        Schema::dropIfExists('allmatching');
    }
}
