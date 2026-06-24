<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_mulai',
        'tanggal_akhir',
        'lokasi_kebun',
        'tarif_harian',
        'tarif_memaras',
        'tarif_kupas',
        'tarif_pemanjat',
        'tarif_pemetik',
        'total_upah_harian',
        'total_upah_kupas',
        'total_upah_pemanjat',
        'total_upah_pemetik',
        'total_keseluruhan',
        'keterangan'
    ];

    public function details()
    {
        return $this->hasMany(PenggajianDetail::class);
    }

    public function pengajuan_penggajians()
    {
        return $this->hasMany(PengajuanPenggajian::class);
    }
}
