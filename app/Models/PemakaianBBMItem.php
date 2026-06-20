<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemakaianBBMItem extends Model
{
    use HasFactory;

    protected $table = 'pemakaian_bbm_items';

    protected $fillable = [
        'pemakaian_bbm_id',
        'keterangan_pemakaian',
        'jumlah_liter',
        'harga_per_liter',
        'total_harga'
    ];

    public function pemakaian()
    {
        return $this->belongsTo(PemakaianBBM::class, 'pemakaian_bbm_id');
    }
}
