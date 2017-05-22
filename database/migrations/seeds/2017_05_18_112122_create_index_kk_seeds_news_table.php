<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexKkSeedsNewsTable extends Migration
{

    protected $connection = 'mysql_v1_seeds';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_v1_seeds')->create('index_kk_seeds_news', function (Blueprint $table) {
            $table->increments('id');

            $table->date('new_date');
            $table->date('old_date');

            $table->json('news_seeds_ids');
            $table->json('sold_out_seeds_ids');
            $table->json('changes_seeds_ids');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_v1_seeds')->drop('index_kk_seeds_news');
    }
}
