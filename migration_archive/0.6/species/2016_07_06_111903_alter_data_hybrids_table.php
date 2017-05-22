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
            $table->dropColumn('cover');

            $table->integer('covers_id')->unsigned()->after('description')->nullable();
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
            $table->dropColumn('covers_id');
            $table->string('cover')->after('description');
        });
    }
}
