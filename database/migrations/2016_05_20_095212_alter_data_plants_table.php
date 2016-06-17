<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDataPlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_plants', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->after('varietas_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_plants', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
