<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matchdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('matchid')->comment('所属比赛ID');
            $table->string('team1img')->comment('队伍1图标');
            $table->string('team1')->comment('队伍1');
            $table->text('team1special')->comment('队伍1特殊图');
            $table->string('team1score')->comment('队伍1比分');
            $table->string('team1tags');
            $table->text('team1ban')->comment('队伍1BAN');
            $table->text('team1pick')->comment('队伍2PICK');
            $table->string('status')->comment('比赛状态');
            $table->string('matchtime')->comment('比赛局内时间');
            $table->string('team2score')->comment('队伍2比分');
            $table->text('team2special')->comment('队伍2特殊图');
            $table->string('team2')->comment('队伍2');
            $table->string('team2img')->comment('队伍2图标');
            $table->string('team2tags');
            $table->text('team2ban')->comment('队伍2BAN');
            $table->text('team2pick')->comment('队伍2PICK');
            $table->string('team1camp')->comment('队伍1阵营');
            $table->string('camp1tag1');
            $table->string('camp1tag2');
            $table->string('camp1tag3');
            $table->string('camp1tag4');
            $table->string('camp1tag5');
            $table->string('camp1tag6');
            $table->string('camp1tag7');
            $table->text('camp1hero1')->comment('阵营1英雄1');
            $table->text('camp1hero2')->comment('阵营1英雄2');
            $table->text('camp1hero3')->comment('阵营1英雄3');
            $table->text('camp1hero4')->comment('阵营1英雄4');
            $table->text('camp1hero5')->comment('阵营1英雄5');
            $table->string('team2camp')->comment('队伍2阵营');
            $table->string('camp2tag1');
            $table->string('camp2tag2');
            $table->string('camp2tag3');
            $table->string('camp2tag4');
            $table->string('camp2tag5');
            $table->string('camp2tag6');
            $table->string('camp2tag7');
            $table->text('camp2hero1')->comment('阵营2英雄1');
            $table->text('camp2hero2')->comment('阵营2英雄2');
            $table->text('camp2hero3')->comment('阵营2英雄3');
            $table->text('camp2hero4')->comment('阵营2英雄4');
            $table->text('camp2hero5')->comment('阵营2英雄5');
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
        Schema::dropIfExists('matchdetails');
    }
}
