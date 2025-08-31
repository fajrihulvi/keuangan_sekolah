<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';
    public $timestamps = false;

    protected $fillable = [
        'nama', 'tunjangan'
    ];

    public function pegawai(){
        return $this->hasMany(Pegawai::class,'id_jabatan');
    }
}
