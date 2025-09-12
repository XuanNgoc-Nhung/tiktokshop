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
            // Check if column doesn't exist before adding
            if (!Schema::hasColumn('nhan_don', 'san_pham_id')) {
                $table->unsignedBigInteger('san_pham_id')->nullable()->after('user_id');
            }
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
            $table->dropColumn('san_pham_id');
        });
    }
};
