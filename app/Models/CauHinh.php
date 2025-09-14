<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CauHinh extends Model
{
    protected $table = 'cau_hinh';
    protected $fillable = ['id', 'hinh_nen', 'link_zalo', 'link_facebook', 'link_telegram', 'link_whatsapp', 'email', 'hotline', 'vi_btc', 'vi_eth', 'vi_usdt'];
    public $incrementing = false;
    protected $keyType = 'int';
}
