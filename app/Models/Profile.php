<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $fillable = ['user_id','gioi_tinh', 'ngay_sinh', 'dia_chi', 'so_du', 'anh_mat_truoc', 'anh_mat_sau', 'anh_chan_dung', 'ngan_hang', 'so_tai_khoan', 'chu_tai_khoan', 'cap_do', 'giai_thuong_id', 'luot_trung'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
