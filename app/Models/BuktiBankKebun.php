<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiBankKebun extends Model
{
    protected $fillable = [
        'no_bukti',
        'tanggal',
        'judul_pengajuan',
        'keterangan',
        'grand_total'
    ];

    public function items()
    {
        return $this->hasMany(BuktiBankKebunItem::class);
    }
}
