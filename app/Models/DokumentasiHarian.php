<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentasiHarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'judul',
        'keterangan',
        'kebun_id',
        'karyawan_id',
    ];

    public function images()
    {
        return $this->hasMany(DokumentasiHarianImage::class);
    }

    public function kebun()
    {
        return $this->belongsTo(Kebun::class, 'kebun_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
