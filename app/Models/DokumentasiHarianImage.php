<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentasiHarianImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokumentasi_harian_id',
        'image_path',
    ];

    public function dokumentasi_harian()
    {
        return $this->belongsTo(DokumentasiHarian::class);
    }
}
