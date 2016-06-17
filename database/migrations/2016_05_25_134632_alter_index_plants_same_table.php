<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterIndexPlantsSameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('index_plants_same', function (Blueprint $table) {
            $table->unique('plants_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('index_plants_same', function (Blueprint $table) {
            $table->dropUnique(['plants_id']);
        });
    }
}
