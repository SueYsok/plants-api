<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDataVarietasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_varietas', function (Blueprint $table) {
            $table->integer('plants_id')->unsigned()->nullable()->after('subspecies_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_varietas', function (Blueprint $table) {
            $table->dropColumn('plants_id');
        });
    }
}
