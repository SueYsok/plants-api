<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataBusinessesPlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_businesses_plants', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('businesses_id')->unsigned();
            $table->foreign('businesses_id')->references('id')->on('data_businesses');

            $table->integer('plants_id')->unsigned();
            $table->foreign('plants_id')->references('id')->on('data_plants');

            $table->string('number')->nullable()->index();

            $table->string('description')->nullable();
            $table->string('price')->nullable();

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
        Schema::drop('data_businesses_plants');
    }
}
