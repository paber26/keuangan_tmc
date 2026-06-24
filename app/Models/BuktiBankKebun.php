<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiBankKebun extends Model
{
    protected $fillable = [
        'pengajuan_id',
        'no_bukti',
        'tanggal',
        'keterangan',
        'judul_pengajuan',
        'grand_total',
        'ditransfer_ke',
        'bank_rek_tujuan'
    ];

    public function items()
    {
        return $this->hasMany(BuktiBankKebunItem::class);
    }
}
