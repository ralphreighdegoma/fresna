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
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); // Unique identifier for each message
            $table->unsignedBigInteger('sender_id'); // ID of the user who sent the message
            $table->unsignedBigInteger('receiver_id'); // ID of the user who receives the message
            $table->unsignedBigInteger('thread_id')->nullable(); // ID of the thread this message belongs to
            $table->text('body'); // Content of the message
            $table->timestamps(); // Created and updated timestamps

            // Foreign keys for sender and receiver
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('thread_id')->references('id')->on('thread')->onDelete('cascade'); // For threading
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
