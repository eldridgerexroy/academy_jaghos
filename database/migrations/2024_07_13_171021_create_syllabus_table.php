<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syllabus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('major_id');
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');
            $table->unsignedBigInteger('university_id');
            $table->foreign('university_id')->references('id')->on('universities')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->year('year');
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
        Schema::dropIfExists('syllabus');
    }
};
