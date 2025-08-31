<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nama_jabatan = [
            ["nama"=>"MaPel Siroh 4 kelas ",'tunjangan'=>600000],
            ["nama"=>"MaPel B, Ing 2 kelas",'tunjangan'=>600000],
            ["nama"=>"Guru pengganti & Tes Jilid",'tunjangan'=>200000],
            ["nama"=>"Bendahara",'tunjangan'=>650000],
            ["nama"=>"Staf TU ",'tunjangan'=>200000],
            ["nama"=>"HUMAS",'tunjangan'=>400000],
            ["nama"=>"Wali Kelas 1 (sholihah)",'tunjangan'=>100000],
            ["nama"=>"Wali Kelas 1 (sholih)",'tunjangan'=>100000],
            ["nama"=>"Wali Kelas 2 sholih)",'tunjangan'=>100000],
            ["nama"=>"Wali Kelas 2 (sholihah)",'tunjangan'=>100000],
            ["nama"=>"Wali Kelas 3 (sholih)",'tunjangan'=>200000],
            ["nama"=>"Wali Kelas 3 (sholihah)",'tunjangan'=>200000],
            ["nama"=>"Wali Kelas 4 (sholih)",'tunjangan'=>200000],
            ["nama"=>"Wali Kelas 4 (sholih sholihah)",'tunjangan'=>200000],
            ["nama"=>"Wali Kelas 4 (sholihah)",'tunjangan'=>200000],
            ["nama"=>"Wali Kelas 5 (sholih)",'tunjangan'=>200000],
            ["nama"=>"Wali Kelas 5 (sholihah)",'tunjangan'=>200000],
            ["nama"=>"Wali Kelas 6 (sholih)",'tunjangan'=>200000],
            ["nama"=>"Wali Kelas 6 (sholihah)",'tunjangan'=>200000],
            ["nama"=>"MaPel B. Inggris 14 kelas",'tunjangan'=>100000],
            ["nama"=>"MaPel PJOK 6 Kls & PAI 8 Kls",'tunjangan'=>100000],
            ["nama"=>"MaPel PJOK 14 kelas",'tunjangan'=>100000],
            ["nama"=>"MaPel PAI 12 kls & Siroh 2 kls",'tunjangan'=>100000],
            ["nama"=>"MaPel Siroh 14 kelas",'tunjangan'=>200000],
            ["nama"=>"Guru Qur'an",'tunjangan'=>0],
            ["nama"=>"Guru Qur'an 2 sesi",'tunjangan'=>0],
            ["nama"=>"UKS & Guru Pengganti Qur'an",'tunjangan'=>0],
            ["nama"=>"Kebersihan ",'tunjangan'=>0],
            ["nama"=>"Koord. Keamanan & Kebersihan",'tunjangan'=>0],
            ["nama"=>"Kepala Sekolah",'tunjangan'=>915000],
        ];
        foreach ($nama_jabatan as $value) {
            Jabatan::create([
                'nama' => trim($value['nama']),
                'tunjangan' => $value['tunjangan'],
            ]);
        }
    }
}
