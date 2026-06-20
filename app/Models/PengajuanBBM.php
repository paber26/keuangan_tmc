<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBBM extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_bbm';

    protected $fillable = [
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
}
