<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SanPham;

class SanPhamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'ten' => 'iPhone 15 Pro Max',
                'mo_ta' => 'iPhone 15 Pro Max với chip A17 Pro mạnh mẽ, camera 48MP chuyên nghiệp và thiết kế titan cao cấp.',
                'hinh_anh' => 'products/iphone15.jpg',
                'cap_do' => 5
            ],
            [
                'ten' => 'Samsung Galaxy S24 Ultra',
                'mo_ta' => 'Samsung Galaxy S24 Ultra với S Pen, camera 200MP và màn hình Dynamic AMOLED 2X 6.8 inch.',
                'hinh_anh' => 'products/samsung-s24.jpg',
                'cap_do' => 4
            ],
            [
                'ten' => 'MacBook Pro M3',
                'mo_ta' => 'MacBook Pro M3 với chip Apple M3 Pro, màn hình Liquid Retina XDR 14 inch và hiệu năng vượt trội.',
                'hinh_anh' => 'products/macbook-pro.jpg',
                'cap_do' => 5
            ],
            [
                'ten' => 'AirPods Pro 2',
                'mo_ta' => 'AirPods Pro 2 với chip H2, chống ồi chủ động và âm thanh không gian.',
                'hinh_anh' => 'products/airpods-pro.jpg',
                'cap_do' => 3
            ],
            [
                'ten' => 'iPad Air M2',
                'mo_ta' => 'iPad Air M2 với chip M2 mạnh mẽ, màn hình Liquid Retina 10.9 inch và hỗ trợ Apple Pencil.',
                'hinh_anh' => 'products/ipad-air.jpg',
                'cap_do' => 4
            ],
            [
                'ten' => 'Sony WH-1000XM5',
                'mo_ta' => 'Sony WH-1000XM5 với chống ồi hàng đầu, âm thanh chất lượng cao và pin 30 giờ.',
                'hinh_anh' => 'products/sony-headphones.jpg',
                'cap_do' => 3
            ],
            [
                'ten' => 'Apple Watch Series 9',
                'mo_ta' => 'Apple Watch Series 9 với chip S9, màn hình Always-On Retina và theo dõi sức khỏe toàn diện.',
                'hinh_anh' => 'products/apple-watch.jpg',
                'cap_do' => 3
            ],
            [
                'ten' => 'Dell XPS 13',
                'mo_ta' => 'Dell XPS 13 với Intel Core i7, màn hình 13.4 inch 4K và thiết kế siêu mỏng.',
                'hinh_anh' => 'products/dell-xps.jpg',
                'cap_do' => 4
            ],
            [
                'ten' => 'Nintendo Switch OLED',
                'mo_ta' => 'Nintendo Switch OLED với màn hình OLED 7 inch, Joy-Con và chơi game mọi lúc mọi nơi.',
                'hinh_anh' => 'products/nintendo-switch.jpg',
                'cap_do' => 2
            ],
            [
                'ten' => 'Sony PlayStation 5',
                'mo_ta' => 'Sony PlayStation 5 với SSD siêu nhanh, DualSense controller và trải nghiệm game 4K.',
                'hinh_anh' => 'products/ps5.jpg',
                'cap_do' => 4
            ],
            [
                'ten' => 'Xiaomi 13 Pro',
                'mo_ta' => 'Xiaomi 13 Pro với Snapdragon 8 Gen 2, camera Leica 50MP và sạc nhanh 120W.',
                'hinh_anh' => 'products/xiaomi-13.jpg',
                'cap_do' => 3
            ],
            [
                'ten' => 'OnePlus 11',
                'mo_ta' => 'OnePlus 11 với Snapdragon 8 Gen 2, màn hình AMOLED 120Hz và sạc nhanh 100W.',
                'hinh_anh' => 'products/oneplus-11.jpg',
                'cap_do' => 3
            ],
            [
                'ten' => 'Google Pixel 8 Pro',
                'mo_ta' => 'Google Pixel 8 Pro với Tensor G3, camera AI và Android thuần túy.',
                'hinh_anh' => 'products/pixel-8.jpg',
                'cap_do' => 4
            ],
            [
                'ten' => 'Huawei Mate 60 Pro',
                'mo_ta' => 'Huawei Mate 60 Pro với chip Kirin 9000S, camera XMAGE và thiết kế cao cấp.',
                'hinh_anh' => 'products/huawei-mate60.jpg',
                'cap_do' => 4
            ],
            [
                'ten' => 'Oppo Find X6 Pro',
                'mo_ta' => 'Oppo Find X6 Pro với Snapdragon 8 Gen 2, camera Hasselblad và sạc nhanh 100W.',
                'hinh_anh' => 'products/oppo-findx6.jpg',
                'cap_do' => 3
            ]
        ];

        foreach ($products as $product) {
            // Tạo giá ngẫu nhiên từ 50 đến 5000
            $gia = rand(50, 5000);
            
            // Tạo hoa hồng ngẫu nhiên từ 0.5% đến 2% của giá
            $hoaHongPercent = rand(50, 200) / 10000; // 0.5% đến 2%
            $hoaHong = round($gia * $hoaHongPercent, 2);
            
            // Thêm giá và hoa hồng vào product
            $product['gia'] = $gia;
            $product['hoa_hong'] = $hoaHong;
            
            SanPham::create($product);
        }
    }
}