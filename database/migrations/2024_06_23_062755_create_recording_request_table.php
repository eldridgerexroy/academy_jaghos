
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
        Schema::create('recording_request', function (Blueprint $table) {
            $table->id();
            $table->string('requester')->nullable();
            $table->string('reason')->nullable();
            $table->string('email')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('webinar_id')->unsigned();
            $table->date('date');
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
        Schema::dropIfExists('recording_request');
    }
};
