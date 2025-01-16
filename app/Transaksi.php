<?php

namespace App;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
	protected $table = "transaksi";

	protected $fillable = ["tanggal","jenis","kategori_id","nominal","keterangan"];

	public function kategori()
	{
		return $this->belongsTo('App\Kategori');
	}

    public function siswa()
    {
        return $this->belongsTo(Siswa::class,'id_siswa');
    }
}
