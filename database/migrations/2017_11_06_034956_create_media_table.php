<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->unsignedInteger('tournament_id');
            $table->unsignedInteger('upload_id');
            $table->timestamps();

            $table->primary(['tournament_id', 'upload_id']);

            $table->foreign('tournament_id')->references('id')->on('tournaments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('upload_id')->references('id')->on('uploads')->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
