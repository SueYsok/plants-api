<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataVarietasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_varietas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('species_id')->unsigned();
            $table->foreign('species_id')->references('id')->on('data_species');

            $table->integer('subspecies_id')->unsigned()->nullable();
            $table->foreign('subspecies_id')->references('id')->on('data_subspecies');

            $table->string('title');
            $table->string('chinese_title')->nullable();

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
        Schema::drop('data_varietas');
    }
}
