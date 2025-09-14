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
        Schema::create('cau_hinh', function (Blueprint $table) {
            $table->id();
            $table->string('hinh_nen')->nullable();
            $table->string('link_zalo')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('link_telegram')->nullable();
            $table->string('link_whatapp')->nullable();
            $table->string('email')->nullable();
            $table->string('hotline')->nullable();
            $table->string('vi_btc')->nullable();
            $table->string('vi_eth')->nullable();
            $table->string('vi_usdt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cau_hinh');
    }
};
