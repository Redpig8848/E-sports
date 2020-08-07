<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoktvlinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goktvlink', function (Blueprint $table) {
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
        Schema::dropIfExists('goktvlink');
    }
}
