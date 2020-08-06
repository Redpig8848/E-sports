<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchTable extends Migration
{
    /**
     * Run the migrations.
     * 赛事表  分类
     * @return void
     */
    public function up()
    {
        Schema::create('match', function (Blueprint $table) {
            $table->increments('id');
            $table->string('match')->comment('赛事名称');
            $table->string('matchimg')->comment('赛事图标');
            $table->string('matchtime')->comment('比赛时间');
            $table->string('teams')->comment('参赛队伍');
            $table->integer('money')->comment('赛事奖金');
            $table->string('venue')->comment('举办地点');
            $table->string('organizers')->comment('举办方');
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
        Schema::dropIfExists('match');
    }
}
