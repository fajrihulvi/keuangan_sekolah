<?php

namespace App;

use App\Models\Jenis;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
	protected $table = "transaksi";

	protected $fillable = ["tanggal","jenis","kategori_id","id_siswa","nominal","keterangan"];

	public function kategori()
	{
		return $this->belongsTo(Kategori::class,'kategori_id');
	}

    public function siswa()
    {
        return $this->belongsTo(Siswa::class,'id_siswa');
    }

    public function jenis(){
        return $this->belongsTo(Jenis::class,'jenis');
    }
}
