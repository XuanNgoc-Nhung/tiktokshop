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
        Schema::table('slide_show', function (Blueprint $table) {
            // Change trang_thai from boolean to integer
            $table->integer('trang_thai')->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slide_show', function (Blueprint $table) {
            // Revert back to boolean
            $table->boolean('trang_thai')->default(true)->change();
        });
    }
};
