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
            $table->string('description', 1024)->nullable()->after('chinese_title');
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
            $table->dropColumn('description');
        });
    }
}
