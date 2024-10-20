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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Reference to the user who created the campaign
            $table->unsignedBigInteger('account_id'); // Reference to the user who created the campaign
            $table->unsignedBigInteger('contact_group_id'); // Reference to the user who created the campaign
            $table->string('name'); // Name of the campaign
            $table->text('description')->nullable(); // Optional description of the campaign
            $table->enum('status', ['draft', 'active', 'completed'])->default('draft'); // Campaign status
            $table->timestamp('scheduled_at')->nullable(); // Optional field for scheduled campaigns
            $table->timestamps();

            // Foreign key constraint linking the campaign to the user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
