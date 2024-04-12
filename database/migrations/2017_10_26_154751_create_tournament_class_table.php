<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_tournament', function (Blueprint $table) {
            $table->unsignedInteger('tournament_id');
            $table->unsignedInteger('class_id');

            $table->foreign('tournament_id')->references('id')->on('tournaments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_tournament');
    }
}
