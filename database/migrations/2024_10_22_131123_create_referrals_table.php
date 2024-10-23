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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('draft');
            $table->string('title');
            $table->foreignId('client_id')->constrained('users');
            $table->string('organisation');
            $table->string('referral_reason');
            $table->text('referral_description');
            $table->string('expected_outcome');
            $table->foreignId('referred_to_id')->constrained('users');
            $table->integer('max_hours');
            $table->decimal('max_cost', 8, 2);
            $table->foreignId('business_advisor_id')->constrained('users');
            $table->foreignId('approver_id')->constrained('users');
            $table->string('comment');
            $table->string('member_feedback');
            $table->string('total_rating');
            $table->string('rating_average_score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
