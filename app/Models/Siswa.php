<?php

namespace App\Models;

use App\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = "siswa";
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap',
        'id_kelas',
        'alamat',
        'nisn',
        'nohp_orangtua',
        'nama_orangtua',
        'keterangan'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'id_kelas');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class,'id');
    }
}
