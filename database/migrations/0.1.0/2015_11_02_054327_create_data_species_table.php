<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataSpeciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_species', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('genus_id')->unsigned();
            $table->foreign('genus_id')->references('id')->on('data_genus');

            $table->string('title');
            $table->string('chinese_title')->nullable();

            $table->unsignedTinyInteger('sub_process');

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
        Schema::drop('data_species');
    }
}
