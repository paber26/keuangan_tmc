<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPenggajian extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'no_dokumen',
        'disahkan_tgl',
        'berlaku_tgl',
        'revisi',
        'kebun_id',
        'perihal',
        'grand_total',
        'status',
    ];

    public function kebun()
    {
        return $this->belongsTo(Kebun::class);
    }

    public function items()
    {
        return $this->hasMany(PengajuanPenggajianItem::class);
    }
}
