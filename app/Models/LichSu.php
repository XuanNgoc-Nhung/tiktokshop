<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichSu extends Model
{
    protected $table = 'lich_su';
    protected $fillable = ['user_id', 'hanh_dong', 'so_tien', 'ghi_chu', 'trang_thai'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
