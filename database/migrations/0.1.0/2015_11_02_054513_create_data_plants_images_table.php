<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataPlantsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_plants_images', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('plants_id')->unsigned();
            $table->foreign('plants_id')->references('id')->on('data_plants');

            $table->string('image');

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
        Schema::drop('data_plants_images');
    }
}
