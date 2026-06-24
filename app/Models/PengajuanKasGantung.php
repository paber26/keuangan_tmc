<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanKasGantung extends Model
{
    protected $table = 'pengajuan_kas_gantungs';
    
    protected $fillable = [
        'tanggal',
        'judul_pengajuan',
        'keterangan',
        'grand_total'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(PengajuanKasGantungItem::class);
    }
}
