<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataPlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_plants', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('description')->nullable();
            $table->string('cover')->nullable();

            $table->integer('family_id')->unsigned();
            $table->foreign('family_id')->references('id')->on('data_family');

            $table->integer('genus_id')->unsigned();
            $table->foreign('genus_id')->references('id')->on('data_genus');

            $table->integer('species_id')->unsigned();
            $table->foreign('species_id')->references('id')->on('data_species');

            $table->integer('subspecies_id')->unsigned()->nullable();
            $table->foreign('subspecies_id')->references('id')->on('data_subspecies');

            $table->integer('varietas_id')->unsigned()->nullable();
            $table->foreign('varietas_id')->references('id')->on('data_varietas');

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
        Schema::drop('data_plants');
    }
}
