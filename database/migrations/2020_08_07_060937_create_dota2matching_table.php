<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDota2matchingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dota2matching', function (Blueprint $table) {
            $table->increments('id');
            $table->string('eventsimg')->comment('所属赛事图标');
            $table->string('events')->comment('所属赛事');
            $table->integer('eventsid')->comment('所属赛事ID');
            $table->string('tv')->default('已存入TVlink数据表')->comment('直播地址');
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
        Schema::dropIfExists('dota2matching');
    }
}
