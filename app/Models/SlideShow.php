<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlideShow extends Model
{
    protected $table = 'slide_show';
    protected $fillable = [
        'hinh_anh',
        'tieu_de',
        'vi_tri',
        'trang_thai'
    ];

    protected $casts = [
        'trang_thai' => 'integer',
        'vi_tri' => 'integer'
    ];
}
