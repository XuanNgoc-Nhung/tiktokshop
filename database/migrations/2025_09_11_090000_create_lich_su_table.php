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
        Schema::create('lich_su', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('hanh_dong')->comment('1: nạp tiền, 2: rút tiền, 3: hệ thống xử lý, 4: nhận hoa hồng');
            $table->decimal('so_tien', 15, 2)->default(0);
            $table->text('ghi_chu')->nullable();
            $table->tinyInteger('trang_thai')->default(1)->comment('trạng thái');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_su');
    }
};


