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
        Schema::create('university_application', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_major_id')->constrained('university_major')->onDelete('cascade');
            $table->integer('individual_application_quota')->nullable();
            $table->string('individual_application_required_documents')->nullable();
            $table->integer('individual_application_quota_transfer')->nullable();
            
            $table->integer('united_distribution_quota_total')->nullable();
            $table->integer('united_distribution_quota_total_s1')->nullable();
            $table->integer('united_distribution_quota_total_s2')->nullable();
            $table->integer('united_distribution_quota_total_s3')->nullable();
            $table->integer('united_distribution_quota_total_s4')->nullable();
            $table->integer('united_distribution_quota_total_s5')->nullable();
            
            $table->integer('english_program')->nullable();
            $table->integer('5_graduate_system_can_apply')->nullable();
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
        Schema::dropIfExists('university_application');
    }
};
