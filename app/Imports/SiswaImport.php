<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $kelas = Kelas::where("nama_kelas", $row["kelas"])->first();

        if (!$kelas) {
            // return null;
            // dd($kelas);
            throw new \Exception("Error pada data: Kelas '{$row['kelas']}' tidak ditemui dalam database.");
        }
        $nomor_hp = str_replace("-", "", $row['nomor_orang_tua']);
        $siswa = Siswa::create([
            'nama_lengkap'=> $row['nama_lengkap'],
            'nisn'=> $row['nisn'],
            'alamat'=> $row['alamat'],
            'id_kelas'=> $kelas->id,
            'nama_orangtua' => $row['nama_orang_tua'],
            'nohp_orangtua' => $nomor_hp,
        ]);

        return $siswa;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function rules(): array
    // {
    //     return [
    //         'name' => 'required',
    //         'password' => 'required|min:5',
    //         'email' => 'required|email|unique:users'
    //     ];
    // }
}
