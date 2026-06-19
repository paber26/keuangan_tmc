<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'judul_pengajuan',
        'keterangan',
        'status',
        'grand_total'
    ];

    public function items()
    {
        return $this->hasMany(PengajuanItem::class);
    }
}
