<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggajianDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'penggajian_id',
        'karyawan_id',
        'nama_karyawan',
        'tipe_pekerjaan',
        'jumlah_hari_kerja',
        'jumlah_volume',
        'total_upah',
        'rincian_harian'
    ];

    protected $casts = [
        'rincian_harian' => 'array',
    ];

    public function penggajian()
    {
        return $this->belongsTo(Penggajian::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
