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
        Schema::create('phan_thuong', function (Blueprint $table) {
            $table->id();
            $table->string('ten')->nullable();
            $table->decimal('gia', 10, 2)->nullable();
            $table->decimal('hoa_hong', 10, 2)->nullable();
            $table->text('mo_ta')->nullable();
            $table->string('hinh_anh')->nullable();
            $table->unsignedInteger('cap_do')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phan_thuong');
    }
};


