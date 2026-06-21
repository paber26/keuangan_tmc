<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanBBMImage extends Model
{
    protected $table = 'pengajuan_b_b_m_images';

    protected $fillable = [
        'pengajuan_bbm_id',
        'image_path',
    ];

    public function pengajuanBBM()
    {
        return $this->belongsTo(PengajuanBBM::class, 'pengajuan_bbm_id');
    }
}
