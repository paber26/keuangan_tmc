<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanKasGantungItem extends Model
{
    protected $table = 'pengajuan_kas_gantung_items';
    
    protected $fillable = [
        'pengajuan_kas_gantung_id',
        'nama_barang',
        'qty',
        'harga_satuan',
        'total_harga',
        'keterangan_pengajuan'
    ];

    public function pengajuanKasGantung()
    {
        return $this->belongsTo(PengajuanKasGantung::class);
    }
}
