<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiKasKebun extends Model
{
    protected $fillable = [
        'pengajuan_penggajian_id',
        'no_bukti',
        'tanggal',
    ];

    public function pengajuan_penggajian()
    {
        return $this->belongsTo(PengajuanPenggajian::class);
    }
}
