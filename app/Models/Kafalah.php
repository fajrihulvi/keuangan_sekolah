<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kafalah extends Model
{
    use HasFactory;

    protected $table = 'kafalah';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'nominal'
    ];
}
