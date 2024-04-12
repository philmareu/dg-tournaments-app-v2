<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_requests', function (Blueprint $table) {
            $table->string('token')->index();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('tournament_id');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('token');
            $table->unique(['tournament_id', 'user_id']);
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_requests');
    }
}
