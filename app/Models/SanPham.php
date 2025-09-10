<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'phan_thuong';
    protected $fillable = ['ten','gia','hoa_hong','mo_ta','hinh_anh','cap_do'];

}
