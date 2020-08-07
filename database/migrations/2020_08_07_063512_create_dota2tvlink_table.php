<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDota2tvlinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dota2tvlink', function (Blueprint $table) {
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
        Schema::dropIfExists('dota2tvlink');
    }
}
