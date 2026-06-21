<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBBM extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_bbm';

    protected $fillable = [
        'kebun_id',
        'karyawan_id',
        'departemen',
        'perihal',
        'tanggal',
        'judul_pengajuan',
        'keterangan',
        'status',
        'grand_total'
    ];

    public function items()
    {
        return $this->hasMany(PengajuanBBMItem::class, 'pengajuan_bbm_id');
    }

    public function kebun()
    {
        return $this->belongsTo(Kebun::class, 'kebun_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function images()
    {
        return $this->hasMany(PengajuanBBMImage::class, 'pengajuan_bbm_id');
    }
}
