<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SanPhamTrangChu;

class SanPhamTrangChuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sanPhamData = [
            [
                'ten_san_pham' => 'iPhone 15 Pro Max 256GB',
                'hinh_anh' => 'products/iphone15.jpg',
                'gia_san_pham' => 29990000,
                'hoa_hong' => 1500000,
                'sao_vote' => 5,
                'da_ban' => 25,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Samsung Galaxy S24 Ultra 512GB',
                'hinh_anh' => 'products/samsung-s24.jpg',
                'gia_san_pham' => 27990000,
                'hoa_hong' => 1400000,
                'sao_vote' => 5,
                'da_ban' => 18,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'MacBook Pro M3 14 inch 512GB',
                'hinh_anh' => 'products/macbook-pro.jpg',
                'gia_san_pham' => 42990000,
                'hoa_hong' => 2150000,
                'sao_vote' => 5,
                'da_ban' => 12,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'iPad Air M2 256GB',
                'hinh_anh' => 'products/ipad-air.jpg',
                'gia_san_pham' => 18990000,
                'hoa_hong' => 950000,
                'sao_vote' => 4,
                'da_ban' => 30,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'AirPods Pro 2nd Gen',
                'hinh_anh' => 'products/airpods-pro.jpg',
                'gia_san_pham' => 5990000,
                'hoa_hong' => 300000,
                'sao_vote' => 5,
                'da_ban' => 45,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Sony WH-1000XM5 Headphones',
                'hinh_anh' => 'products/sony-wh1000xm5.jpg',
                'gia_san_pham' => 8990000,
                'hoa_hong' => 450000,
                'sao_vote' => 5,
                'da_ban' => 22,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Apple Watch Series 9 GPS 45mm',
                'hinh_anh' => 'products/apple-watch-s9.jpg',
                'gia_san_pham' => 10990000,
                'hoa_hong' => 550000,
                'sao_vote' => 4,
                'da_ban' => 35,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Dell XPS 13 Plus 512GB',
                'hinh_anh' => 'products/dell-xps13.jpg',
                'gia_san_pham' => 32990000,
                'hoa_hong' => 1650000,
                'sao_vote' => 4,
                'da_ban' => 8,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Samsung Galaxy Buds2 Pro',
                'hinh_anh' => 'products/samsung-buds2pro.jpg',
                'gia_san_pham' => 4990000,
                'hoa_hong' => 250000,
                'sao_vote' => 4,
                'da_ban' => 28,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Microsoft Surface Pro 9 256GB',
                'hinh_anh' => 'products/surface-pro9.jpg',
                'gia_san_pham' => 25990000,
                'hoa_hong' => 1300000,
                'sao_vote' => 4,
                'da_ban' => 15,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Google Pixel 8 Pro 256GB',
                'hinh_anh' => 'products/pixel8pro.jpg',
                'gia_san_pham' => 22990000,
                'hoa_hong' => 1150000,
                'sao_vote' => 4,
                'da_ban' => 20,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'OnePlus 12 512GB',
                'hinh_anh' => 'products/oneplus12.jpg',
                'gia_san_pham' => 19990000,
                'hoa_hong' => 1000000,
                'sao_vote' => 4,
                'da_ban' => 16,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'iPad Pro M2 11 inch 128GB',
                'hinh_anh' => 'products/ipad-pro11.jpg',
                'gia_san_pham' => 21990000,
                'hoa_hong' => 1100000,
                'sao_vote' => 5,
                'da_ban' => 14,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'MacBook Air M2 13 inch 256GB',
                'hinh_anh' => 'products/macbook-air-m2.jpg',
                'gia_san_pham' => 28990000,
                'hoa_hong' => 1450000,
                'sao_vote' => 5,
                'da_ban' => 19,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Sony PlayStation 5 Digital',
                'hinh_anh' => 'products/ps5-digital.jpg',
                'gia_san_pham' => 11990000,
                'hoa_hong' => 600000,
                'sao_vote' => 5,
                'da_ban' => 32,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Xbox Series X 1TB',
                'hinh_anh' => 'products/xbox-series-x.jpg',
                'gia_san_pham' => 12990000,
                'hoa_hong' => 650000,
                'sao_vote' => 4,
                'da_ban' => 24,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Nintendo Switch OLED 64GB',
                'hinh_anh' => 'products/switch-oled.jpg',
                'gia_san_pham' => 8990000,
                'hoa_hong' => 450000,
                'sao_vote' => 5,
                'da_ban' => 38,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Steam Deck 512GB',
                'hinh_anh' => 'products/steam-deck.jpg',
                'gia_san_pham' => 15990000,
                'hoa_hong' => 800000,
                'sao_vote' => 4,
                'da_ban' => 11,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'DJI Mini 4 Pro Drone',
                'hinh_anh' => 'products/dji-mini4pro.jpg',
                'gia_san_pham' => 17990000,
                'hoa_hong' => 900000,
                'sao_vote' => 5,
                'da_ban' => 7,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'GoPro Hero 12 Black',
                'hinh_anh' => 'products/gopro-hero12.jpg',
                'gia_san_pham' => 9990000,
                'hoa_hong' => 500000,
                'sao_vote' => 4,
                'da_ban' => 26,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Canon EOS R6 Mark II',
                'hinh_anh' => 'products/canon-r6m2.jpg',
                'gia_san_pham' => 45990000,
                'hoa_hong' => 2300000,
                'sao_vote' => 5,
                'da_ban' => 5,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Sony A7 IV Mirrorless Camera',
                'hinh_anh' => 'products/sony-a7iv.jpg',
                'gia_san_pham' => 39990000,
                'hoa_hong' => 2000000,
                'sao_vote' => 5,
                'da_ban' => 9,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Fujifilm X-T5 40MP',
                'hinh_anh' => 'products/fujifilm-xt5.jpg',
                'gia_san_pham' => 27990000,
                'hoa_hong' => 1400000,
                'sao_vote' => 4,
                'da_ban' => 13,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Bose QuietComfort 45',
                'hinh_anh' => 'products/bose-qc45.jpg',
                'gia_san_pham' => 7990000,
                'hoa_hong' => 400000,
                'sao_vote' => 4,
                'da_ban' => 21,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Sennheiser HD 660S',
                'hinh_anh' => 'products/sennheiser-hd660s.jpg',
                'gia_san_pham' => 5990000,
                'hoa_hong' => 300000,
                'sao_vote' => 5,
                'da_ban' => 17,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Audio-Technica ATH-M50x',
                'hinh_anh' => 'products/audio-technica-m50x.jpg',
                'gia_san_pham' => 3990000,
                'hoa_hong' => 200000,
                'sao_vote' => 4,
                'da_ban' => 33,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Logitech MX Master 3S',
                'hinh_anh' => 'products/logitech-mx3s.jpg',
                'gia_san_pham' => 2990000,
                'hoa_hong' => 150000,
                'sao_vote' => 5,
                'da_ban' => 41,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Keychron K8 Pro Wireless',
                'hinh_anh' => 'products/keychron-k8pro.jpg',
                'gia_san_pham' => 3990000,
                'hoa_hong' => 200000,
                'sao_vote' => 4,
                'da_ban' => 29,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'LG UltraGear 27GP950 4K 144Hz',
                'hinh_anh' => 'products/lg-ultragear-27gp950.jpg',
                'gia_san_pham' => 12990000,
                'hoa_hong' => 650000,
                'sao_vote' => 5,
                'da_ban' => 6,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'Samsung Odyssey G9 49 inch',
                'hinh_anh' => 'products/samsung-odyssey-g9.jpg',
                'gia_san_pham' => 19990000,
                'hoa_hong' => 1000000,
                'sao_vote' => 4,
                'da_ban' => 4,
                'trang_thai' => 1
            ],
            [
                'ten_san_pham' => 'ASUS ROG Swift PG32UQX 4K',
                'hinh_anh' => 'products/asus-rog-pg32uqx.jpg',
                'gia_san_pham' => 35990000,
                'hoa_hong' => 1800000,
                'sao_vote' => 5,
                'da_ban' => 3,
                'trang_thai' => 1
            ]
        ];

        foreach ($sanPhamData as $sanPham) {
            SanPhamTrangChu::create($sanPham);
        }
    }
}
