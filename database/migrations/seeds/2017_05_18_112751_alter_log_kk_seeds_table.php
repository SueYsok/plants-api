<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLogKkSeedsTable extends Migration
{

    protected $connection = 'mysql_v1_seeds';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_v1_seeds')->table('log_kk_seeds', function (Blueprint $table) {
            $table->string('spec_pkt_price')->after('spec_10000')->nullable();
            $table->string('spec_100_price')->after('spec_pkt_price')->nullable();
            $table->string('spec_1000_price')->after('spec_100_price')->nullable();
            $table->string('spec_10000_price')->after('spec_1000_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_v1_seeds')->table('log_kk_seeds', function (Blueprint $table) {
            $table->dropColumn('spec_pkt_price');
            $table->dropColumn('spec_100_price');
            $table->dropColumn('spec_1000_price');
            $table->dropColumn('spec_10000_price');
        });
    }
}
