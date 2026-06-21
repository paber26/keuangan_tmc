<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBBMItem extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_bbm_items';

    protected $fillable = [
        'pengajuan_bbm_id',
        'tanggal',
        'tipe_bbm',
        'uraian',
        'keterangan_pengajuan',
        'jumlah_liter',
        'harga_per_liter',
        'total_harga'
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanBBM::class, 'pengajuan_bbm_id');
    }
}
