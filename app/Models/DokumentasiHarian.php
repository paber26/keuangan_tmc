<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentasiHarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'judul',
        'keterangan',
    ];

    public function images()
    {
        return $this->hasMany(DokumentasiHarianImage::class);
    }
}
