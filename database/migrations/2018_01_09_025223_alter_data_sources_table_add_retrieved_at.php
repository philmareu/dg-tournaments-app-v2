<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDataSourcesTableAddRetrievedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_sources', function (Blueprint $table) {
            $table->dateTime('retrieved_at')->default(NOW());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_sources', function (Blueprint $table) {
            $table->dropColumn('retrieved_at');
        });
    }
}
