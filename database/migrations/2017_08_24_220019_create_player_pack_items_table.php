<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerPackItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_pack_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('player_pack_id');
            $table->string('title');
            $table->unsignedTinyInteger('ordinal')->default(100);
            $table->timestamps();

            $table->foreign('player_pack_id')->references('id')->on('player_packs')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_pack_items');
    }
}
