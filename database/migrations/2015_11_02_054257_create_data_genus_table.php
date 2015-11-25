<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataGenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_genus', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('family_id')->unsigned();
            $table->foreign('family_id')->references('id')->on('data_family');

            $table->string('title');
            $table->string('chinese_title')->nullable();

            $table->integer('species_id')->unsigned()->nullable();

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
        Schema::drop('data_genus');
    }
}
