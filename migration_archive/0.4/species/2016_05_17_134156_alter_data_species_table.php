<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDataSpeciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_species', function (Blueprint $table) {
            $table->integer('plants_id')->unsigned()->nullable()->after('genus_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_species', function (Blueprint $table) {
            $table->dropColumn('plants_id');
        });
    }
}
