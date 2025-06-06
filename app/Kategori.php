<?php

namespace App;

use App\Models\Jenis;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = "kategori";
    public $timestamps= false;
	protected $fillable = ["kategori",'id_tipe','untuk_siswa'];

	public function transaksi()
	{
		return $this->hasMany(Transaksi::class,'id');
	}
    public function jenis()
    {
        return $this->belongsTo(Jenis::class,'id_tipe');
    }
}
