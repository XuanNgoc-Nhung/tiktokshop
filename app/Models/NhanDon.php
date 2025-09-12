<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanDon extends Model
{
    protected $table = 'nhan_don';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['user_id', 'san_pham_id', 'ten_san_pham', 'gia_tri', 'hoa_hong'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }

}
