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
        'tarif_kupas',
        'total_upah_harian',
        'total_upah_kupas',
        'total_keseluruhan',
        'keterangan'
    ];

    public function details()
    {
        return $this->hasMany(PenggajianDetail::class);
    }
}
