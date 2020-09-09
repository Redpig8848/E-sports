<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnallmatchingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fnallmatching', function (Blueprint $table) {
            $table->increments('id');
            $table->string('game')->comment('游戏分类');
            $table->string('match')->comment('所属赛事');
            $table->integer('eventsid')->comment('所属赛事ID');
            $table->text('videos');
            $table->integer('time')->comment('比赛开始时间');
            $table->string('team1')->comment('队伍1');
            $table->string('team1logo')->comment('队伍1图标');
            $table->string('team1score')->comment('队伍1比分');
            $table->string('team2score')->comment('队伍2比分');
            $table->string('team2')->comment('队伍2');
            $table->string('team2logo')->comment('队伍2图标');
            $table->string('bo')->comment('BO');

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
        Schema::dropIfExists('fnallmatching');
    }
}
