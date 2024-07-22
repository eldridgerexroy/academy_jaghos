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
            $table->string('title');
            $table->year('year');
            $table->text('course_overview')->nullable();
            $table->text('course_objectives')->nullable();
            $table->text('grading_policy')->nullable();
            $table->text('assignments')->nullable(); 
            $table->text('required_readings')->nullable();

            $table->unsignedBigInteger('university_major_id');
            $table->foreign('university_major_id')->references('id')->on('university_major')->onDelete('cascade');

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