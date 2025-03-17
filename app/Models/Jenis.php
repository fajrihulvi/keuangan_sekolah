<?php

namespace App\Models;

use App\Kategori;
use App\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory;

    protected $table = 'jenis';
    public $timestamps = false;
    protected $fillable = [
        'tipe'
    ];

    public function kategori()
    {
        return $this->hasMany(Kategori::class,"id");
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class,"id");
    }
}
