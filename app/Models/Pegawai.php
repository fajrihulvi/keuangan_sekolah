<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    public $timestamps = false;
    protected $fillable = ['nama','id_jabatan'];

    public function jabatan(){
        return $this->belongsTo(Jabatan::class,'id_jabatan');
    }

    public function gaji(){
        return $this->hasMany(Gaji::class,'id_pegawai');
    }
}
