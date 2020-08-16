<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationTable extends Migration
{
    /**
     * Run the migrations.
     * 资讯
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->increments('id');
            $table->string('thumbnail')->comment('缩略图');
            $table->string('title')->comment('标题');
            $table->string('gametype')->comment('游戏分类');
            $table->string('gametypeid')->comment('游戏分类ID');
            $table->string('time')->comment('更新时间');
            $table->string('unix')->comment('Unix时间轴');
            $table->text('body')->comment('正文');
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
        Schema::dropIfExists('information');
    }
}
