<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataHybridsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_hybrids_images', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('hybrids_id')->unsigned();
            $table->foreign('hybrids_id')->references('id')->on('data_hybrids');

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
        Schema::drop('data_hybrids_images');
    }
}
