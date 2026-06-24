<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiBankKebunItem extends Model
{
    protected $fillable = [
        'bukti_bank_kebun_id',
        'nama_barang',
        'qty',
        'harga_satuan',
        'total_harga'
    ];

    public function buktiBankKebun()
    {
        return $this->belongsTo(BuktiBankKebun::class);
    }
}
