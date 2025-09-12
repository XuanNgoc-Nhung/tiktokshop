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
        Schema::table('nhan_don', function (Blueprint $table) {
            // Drop existing foreign key if exists
            $table->dropForeign(['san_pham_id']);
            
            // Add new foreign key pointing to phan_thuong table
            $table->foreign('san_pham_id')->references('id')->on('phan_thuong')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nhan_don', function (Blueprint $table) {
            $table->dropForeign(['san_pham_id']);
        });
    }
};