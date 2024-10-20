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
        //remove column
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('refresh_token');
            $table->dropColumn('token_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->string('refresh_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
        });
    }
};
