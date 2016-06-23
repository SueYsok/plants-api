<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogKkSeedsTable extends Migration
{

    protected $connection = 'mysql_v1_seeds';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_kk_seeds', function (Blueprint $table) {
            $table->increments('id');

            $table->string('class_1');
            $table->string('class_2');
            $table->string('title');
            $table->string('number');
            $table->tinyInteger('spec_pkt')->default(0);
            $table->tinyInteger('spec_100')->default(0);
            $table->tinyInteger('spec_1000')->default(0);
            $table->tinyInteger('spec_10000')->default(0);
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
        Schema::drop('log_kk_seeds');
    }
}
