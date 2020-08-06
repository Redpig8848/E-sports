<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsgomatchTable extends Migration
{
    /**
     * Run the migrations.
     * CS-GO首页展示比赛
     * @return void
     */
    public function up()
    {
        Schema::create('csgomatch', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gameimg')->comment('游戏图标');
            $table->string('time')->comment('时间');
            $table->string('BO')->comment('赛制局数');
            $table->string('teamone')->comment('参赛队伍1');
            $table->string('teamoneimg')->comment('参赛队1图标');
            $table->string('team2img')->comment('参赛队2图标');
            $table->string('team2')->comment('参赛队2');
            $table->string('eventsimg')->comment('所属赛事图标');
            $table->string('events')->comment('所属赛事');
            $table->integer('eventsid')->comment('所属赛事ID');
            $table->integer('ing')->default(0)->comment('是否正在进行');
            $table->string('TV')->comment('直播地址');
            $table->string('now')->comment('当前局数');
            $table->string('pooreconomy')->comment('经济差');
            $table->integer('teamonewinnum')->comment('队伍1胜利局数');
            $table->integer('teamkillnum')->comment('队伍1杀敌数');
            $table->string('teamonespecial')->comment('队伍1特殊图');
            $table->integer('teamonewinnum')->comment('队伍2胜利局数');
            $table->integer('teamkillnum')->comment('队伍2杀敌数');
            $table->string('teamspecial')->comment('队伍2特殊图');
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
        Schema::dropIfExists('csgomatch');
    }
}
