<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_businesses', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('web_site')->nullable();
            $table->string('country');
            $table->string('description')->nullable();
            
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
        Schema::drop('data_businesses');
    }
}
