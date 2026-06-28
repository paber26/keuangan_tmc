<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'tanggal',
        'tipe',
        'kategori',
        'kebun_id',
        'jumlah',
        'keterangan'
    ];

    public function kebun()
    {
        return $this->belongsTo(Kebun::class);
    }
}
