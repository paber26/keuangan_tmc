<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemakaianBBMImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemakaian_bbm_id',
        'image_path',
        'original_name',
    ];

    public function pemakaianBBM()
    {
        return $this->belongsTo(PemakaianBBM::class, 'pemakaian_bbm_id');
    }
}
