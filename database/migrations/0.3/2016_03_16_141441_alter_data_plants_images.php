<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDataPlantsImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_plants_images', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->after('plants_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_plants_images', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
