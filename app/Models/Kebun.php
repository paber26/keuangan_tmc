<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kebun extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'lokasi',
        'luas',
        'jumlah_blok',
        'status',
    ];
}
