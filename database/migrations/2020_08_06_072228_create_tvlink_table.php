<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvlinkTable extends Migration
{
    /**
     * Run the migrations.
     * 首页显示所有正在比赛的视频链接
     * @return void
     */
    public function up()
    {
        Schema::create('tvlink', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('matchid')->comment('所属比赛ID');
            $table->string('addressname')->comment('地址名称');
            $table->string('link')->comment('地址URL');
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
        Schema::dropIfExists('tvlink');
    }
}
