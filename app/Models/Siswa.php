<?php

namespace App\Models;

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
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'id_kelas');
    }
}
