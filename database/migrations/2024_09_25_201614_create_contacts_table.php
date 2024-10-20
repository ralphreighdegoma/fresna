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
            $table->unsignedBigInteger('user_id'); // Reference to the user who owns the contact
            $table->string('name'); // Contact's name
            $table->string('email'); // Contact's email address
            $table->string('phone')->nullable(); // Contact's phone number (optional)
            $table->string('company')->nullable(); // Company name (optional)
            $table->timestamps();

            // Foreign key constraint linking the contact to the user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
