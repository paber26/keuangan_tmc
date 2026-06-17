<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'kebun_id',
        'lokasi',
        'jabatan',
        'tanggal',
        'status',
        'volume',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function kebun()
    {
        return $this->belongsTo(Kebun::class);
    }
}
