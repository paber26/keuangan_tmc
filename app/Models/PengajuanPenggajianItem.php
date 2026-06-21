<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPenggajianItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengajuan_penggajian_id',
        'uraian',
        'banyak_unit',
        'harga_satuan',
        'total_harga',
        'keterangan',
    ];

    public function pengajuanPenggajian()
    {
        return $this->belongsTo(PengajuanPenggajian::class);
    }
}
