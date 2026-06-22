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
        'status',
    ];

    public function getVirtualLokasiAttribute()
    {
        if (strtoupper($this->lokasi) === 'SAPA') {
            return 'SAPA';
        }
        return strtoupper($this->lokasi) . ' - ' . strtoupper($this->nama);
    }

    public static function getVirtualLokasiList()
    {
        return self::where('status', 'Aktif')
            ->get()
            ->pluck('virtual_lokasi')
            ->unique()
            ->sort()
            ->values();
    }

    public static function getVirtualKebunList()
    {
        return self::where('status', 'Aktif')
            ->get()
            ->unique('virtual_lokasi')
            ->sortBy('virtual_lokasi')
            ->values();
    }
}
