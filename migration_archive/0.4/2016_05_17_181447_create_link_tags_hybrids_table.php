<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkTagsHybridsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_tags_hybrids', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tags_id')->unsigned();
            $table->foreign('tags_id')->references('id')->on('data_tags');

            $table->integer('hybrids_id')->unsigned();
            $table->foreign('hybrids_id')->references('id')->on('data_hybrids');

            $table->string('tags_title')->index();

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
        Schema::drop('link_tags_hybrids');
    }
}
