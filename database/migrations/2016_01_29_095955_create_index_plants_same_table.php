<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexPlantsSameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('index_plants_same', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('major_plants_id')->unsigned();
            $table->foreign('major_plants_id')->references('id')->on('data_plants');

            $table->integer('plants_id')->unsigned();
            $table->foreign('plants_id')->references('id')->on('data_plants');

            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('index_plants_same');
    }
}
