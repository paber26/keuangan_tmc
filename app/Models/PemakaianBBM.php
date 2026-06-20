<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemakaianBBM extends Model
{
    use HasFactory;

    protected $table = 'pemakaian_bbm';

    protected $fillable = [
        'tanggal',
        'judul_laporan',
        'keterangan',
        'grand_total'
    ];

    public function items()
    {
        return $this->hasMany(PemakaianBBMItem::class, 'pemakaian_bbm_id');
    }
}
