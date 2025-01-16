<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = "kategori";
    public $timestamps= false;
	protected $fillable = ["kategori",'id_tipe'];

	public function transaksi()
	{
		return $this->hasMany('App\Transaksi');
	}
}
