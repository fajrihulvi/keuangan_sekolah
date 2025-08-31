<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
    protected $table = 'gaji_pegawai';
    protected $fillable = [
        'id_pegawai',
        'jabatan',
        'kafalah',
        'potongan',
        'total_potongan',
        'total_pemasukan',
        'total_bersih',
        'bulan',
        'tahun'
    ];

    protected $casts = [
        'kafalah' => 'json',
        'potongan' => 'json'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class,'id_pegawai');
    }
}
