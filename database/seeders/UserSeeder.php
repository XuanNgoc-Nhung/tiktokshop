<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN'); // Sử dụng locale tiếng Việt
        
        for ($i = 0; $i < 50; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->unique()->numerify('09########'),
                'password' => Hash::make('password123'), // Mật khẩu mặc định cho tất cả user
                'referral_code' => strtoupper($faker->bothify('??####')),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);
        }
    }
}
