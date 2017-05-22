<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogKkDatesTable extends Migration
{

    protected $connection = 'mysql_v1_seeds';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_v1_seeds')->create('log_kk_dates', function (Blueprint $table) {
            $table->increments('id');

            $table->date('date');

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
        Schema::connection('mysql_v1_seeds')->drop('log_kk_dates');
    }
}
