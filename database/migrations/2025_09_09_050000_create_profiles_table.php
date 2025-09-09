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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('gioi_tinh')->nullable();
            $table->string('ngay_sinh')->nullable();
            $table->string('dia_chi')->nullable();
            $table->string('so_du')->nullable();
            $table->string('anh_mat_truoc')->nullable();
            $table->string('anh_mat_sau')->nullable();
            $table->string('anh_chan_dung')->nullable();
            $table->string('ngan_hang')->nullable();
            $table->string('so_tai_khoan')->nullable();
            $table->string('chu_tai_khoan')->nullable();
            $table->string('cap_do')->nullable();
            $table->string('giai_thuong_id')->nullable();
            $table->string('luot_trung')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};


