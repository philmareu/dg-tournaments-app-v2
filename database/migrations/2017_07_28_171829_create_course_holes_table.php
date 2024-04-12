<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseHolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_course_holes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tournament_course_id');
            $table->unsignedTinyInteger('hole');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['tournament_course_id', 'hole']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournament_course_holes');
    }
}
