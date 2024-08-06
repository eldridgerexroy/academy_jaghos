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
        Schema::create('webinar_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('webinar_id');
            $table->string('days_of_week'); // e.g., 'Monday', 'Tuesday', etc.
            $table->time('start_time'); // start time in WIB
            $table->time('end_time'); // end time in WIB
            $table->string('timezone')->default('WIB'); // fixed timezone

            $table->foreign('webinar_id')->references('id')->on('webinars')->onDelete('cascade');

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
        Schema::dropIfExists('webinar_schedules');
    }
};
