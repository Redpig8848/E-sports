<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreingTable extends Migration
{
    /**
     * Run the migrations.
     * 比分表 正在进行比赛
     * @return void
     */
    public function up()
    {
        Schema::create('scoreing', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gameimg')->comment('游戏图标');
            $table->string('game')->comment('所属游戏');
            $table->string('events')->comment('所属赛事');
            $table->string('eventsid')->comment('所属赛事id');
            $table->string('tag')->comment('标签BO');
            $table->string('tag1');
            $table->string('tag2');
            $table->string('tag3');
            $table->string('tag4');
            $table->string('tag5');
            $table->string('tag6');
            $table->string('index')->comment('指数');
            $table->text('tv')->comment('直播地址');
            $table->string('now')->comment('当前局数');
            $table->string('nowtime')->comment('当局时间');

            $table->string('team1img')->comment('队伍1图标');
            $table->string('team1')->comment('队伍1');
            $table->integer('team1winnum')->comment('队伍1胜利数');
            $table->string('team1lineup')->comment('队伍1阵容');
            $table->integer('team1killnum')->comment('队伍1击杀');
            $table->string('team1killspecial')->comment('队伍1击杀特殊图标');
            $table->string('team1tag3num')->comment('队伍1标签3内容');
            $table->string('team1tag3special')->comment('队伍1标签3特殊图标');
            $table->string('team1tag4num')->comment('队伍1标签4内容');
            $table->string('team1tag4special')->comment('队伍1标签4特殊图标');
            $table->string('team1tag5num')->comment('队伍1标签5内容');
            $table->string('team1tag5special')->comment('队伍1标签5特殊图标');
            $table->string('team1tag6num')->comment('队伍1标签6内容');
            $table->string('team1indexnum')->comment('队伍1指数值');

            $table->string('team2img')->comment('队伍2图标');
            $table->string('team2')->comment('队伍2');
            $table->integer('team2winnum')->comment('队伍2胜利数');
            $table->string('team2lineup')->comment('队伍2阵容');
            $table->integer('team2killnum')->comment('队伍2击杀');
            $table->string('team2killspecial')->comment('队伍2击杀特殊图标');
            $table->string('team2tag3num')->comment('队伍2标签3内容');
            $table->string('team2tag3special')->comment('队伍2标签3特殊图标');
            $table->string('team2tag4num')->comment('队伍2标签4内容');
            $table->string('team2tag4special')->comment('队伍2标签4特殊图标');
            $table->string('team2tag5num')->comment('队伍2标签5内容');
            $table->string('team2tag5special')->comment('队伍2标签5特殊图标');
            $table->string('team2tag6num')->comment('队伍1标签6内容');
            $table->string('team2indexnum')->comment('队伍1指数值');

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
        Schema::dropIfExists('scoreing');
    }
}
