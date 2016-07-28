<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataPlantsCoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_plants_covers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('plants_id')->unsigned();
            $table->foreign('plants_id')->references('id')->on('data_plants');

            $table->integer('user_id')->unsigned();

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
        Schema::drop('data_plants_covers');
    }
}
