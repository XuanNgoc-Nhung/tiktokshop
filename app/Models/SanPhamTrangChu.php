<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPhamTrangChu extends Model
{
    protected $table = 'san_pham_trang_chu';
    protected $fillable = ['id', 'ten_san_pham', 'hinh_anh', 'gia_san_pham', 'hoa_hong', 'sao_vote', 'da_ban', 'trang_thai'];
    public $timestamps = true;

    public function getSanPhamTrangChu()
    {
        return $this->orderBy('id', 'desc')->get();
    }
}
