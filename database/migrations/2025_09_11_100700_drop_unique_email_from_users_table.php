<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the unique index on the email column if it exists
            try {
                $table->dropUnique('users_email_unique');
            } catch (\Throwable $e) {
                // Fallback for environments where index name resolution differs
                try {
                    $table->dropUnique(['email']);
                } catch (\Throwable $e2) {
                    // Ignore if already dropped
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore the unique index on the email column
            $table->unique('email');
        });
    }
};


