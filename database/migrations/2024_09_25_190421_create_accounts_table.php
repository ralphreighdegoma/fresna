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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Reference to the user owning the account
            $table->string('channel'); // 'google', 'linkedin', 'facebook', etc.
            $table->string('name'); // 'google', 'linkedin', 'facebook', etc.
            $table->string('email')->nullable(); // The email associated with the account
            $table->string('access_token')->nullable(); // OAuth or API token for the channel
            $table->string('refresh_token')->nullable(); // Token used to refresh access
            $table->timestamp('token_expires_at')->nullable(); // Token expiration date
            $table->timestamps();

            // Foreign key constraint to link to the users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
