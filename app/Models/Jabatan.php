<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tipe_gaji',
    ];

    public function karyawans()
    {
        return $this->belongsToMany(Karyawan::class, 'jabatan_karyawan');
    }
}
