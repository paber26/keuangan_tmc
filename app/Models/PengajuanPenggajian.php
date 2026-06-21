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
        'penggajian_id',
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

    public function penggajian()
    {
        return $this->belongsTo(Penggajian::class);
    }

    public function bukti_kas_kebun()
    {
        return $this->hasOne(BuktiKasKebun::class);
    }
}
