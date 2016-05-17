<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataHybridsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_hybrids', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('alias')->nullable();
            $table->string('description')->nullable();
            $table->string('cover')->nullable();

            $table->integer('left_plants_id')->unsigned()->nullable();
            $table->foreign('left_plants_id')->references('id')->on('data_plants');

            $table->integer('right_plants_id')->unsigned()->nullable();
            $table->foreign('right_plants_id')->references('id')->on('data_plants');

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
        Schema::drop('data_hybrids');
    }
}
