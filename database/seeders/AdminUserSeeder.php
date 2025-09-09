<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo tài khoản admin mẫu
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tiktokshop.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '0123456789',
            'referral_code' => 'ADMIN001',
        ]);

        // Tạo thêm một admin khác
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@tiktokshop.com',
            'password' => Hash::make('superadmin123'),
            'role' => 'admin',
            'phone' => '0987654321',
            'referral_code' => 'SUPER001',
        ]);
    }
}