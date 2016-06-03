<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDataHybridsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_hybrids', function (Blueprint $table) {
            $table->text('content')->nullable()->after('cover');
            $table->integer('user_id')->unsigned()->after('right_plants_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_hybrids', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('user_id');
        });
    }
}
