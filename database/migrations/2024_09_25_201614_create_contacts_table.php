<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('mobile_number')->nullable();
            $table->string('work_number')->nullable();
            $table->string('organisation_name');
            $table->string('photo')->nullable();
            $table->string('asic_code');
            $table->string('suburb');
            $table->string('post_code');
            $table->string('state');
            $table->string('region');
            $table->string('status')->default('active');
            $table->boolean('indigenous_organization')->nullable();
            $table->string('company_structure');
            $table->string('organisation_type');
            $table->unsignedBigInteger('business_advisor_id')->nullable();
            $table->unsignedBigInteger('program_type_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->string('level_access');
            $table->boolean('referred')->nullable();
            $table->string('refer_name')->nullable();
            $table->string('refer_organisation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
