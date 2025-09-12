<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NapRut extends Model
{
    protected $table = 'nap_rut';
    protected $fillable = ['user_id', 'so_tien', 'ghi_chu', 'trang_thai','loai_giao_dich'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
