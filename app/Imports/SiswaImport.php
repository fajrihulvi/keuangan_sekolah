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
        // dd($row);
        $kelas = Kelas::where("nama_kelas", $row["kelas"])->select('id')->first();
        $siswa = new Siswa([
            'nama_lengkap'=> $row['nama_lengkap'],
            'nisn'=> $row['nisn'],
            'alamat'=> $row['alamat'],
            'id_kelas'=> $kelas->id,
            'nama_orangtua' => $row['nama_orang_tua'],
            'nohp_orangtua' => $row['nomor_orang_tua'],
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
