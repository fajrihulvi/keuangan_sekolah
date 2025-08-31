<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\Kelas;
use App\Models\Pegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawais = [
            ["nama"=>"Hasyim Ashari","jabatan"=>"Kepala Sekolah"],
            ["nama"=>"Cempaka","jabatan"=>"MaPel Siroh 4 kelas"],
            ["nama"=>"Kamila, SP","jabatan"=>"MaPel B, Ing 2 kelas"],
            ["nama"=>"Ismail, SH","jabatan"=>"Guru pengganti & Tes Jilid"],
            ["nama"=>"Kessye Arisani, S.Si","jabatan"=>"Bendahara"],
            ["nama"=>"Nadhila Fasya, S.Kom.","jabatan"=>"Staf TU "],
            ["nama"=>"Regas Sahromi","jabatan"=>"HUMAS"],
            ["nama"=>"Khuswatuun Hasanah, S.Pd","jabatan"=>"Wali Kelas 1 (sholihah)"],
            ["nama"=>"Puji Astuti, S.Psi","jabatan"=>"Wali Kelas 1 (sholihah)"],
            ["nama"=>"Sapitri, S.Pd","jabatan"=>"Wali Kelas 1 (sholih)"],
            ["nama"=>"Siti Rahmawati, S.Pd","jabatan"=>"Wali Kelas 1 (sholih)"],
            ["nama"=>"Nia Olivia, S. Pd","jabatan"=>"Wali Kelas 2 sholih)"],
            ["nama"=>"Chika","jabatan"=>"Wali Kelas 2 (sholihah)"],
            ["nama"=>"Siti Maisaroh, S.Sos.I","jabatan"=>"Wali Kelas 2 sholih)"],
            ["nama"=>"Aprisia","jabatan"=>"Wali Kelas 2 (sholihah)"],
            ["nama"=>"Aldo Afuleno, S. Pd","jabatan"=>"Wali Kelas 3 (sholih)"],
            ["nama"=>"Ari Baru","jabatan"=>"Wali Kelas 3 (sholih)"],
            ["nama"=>"Yasa Putri. S.P","jabatan"=>"Wali Kelas 3 (sholihah)"],
            ["nama"=>"Khoirun nisa, S.Pd","jabatan"=>"Wali Kelas 3 (sholihah)"],
            ["nama"=>"Wahyu Aditiya, S.Pd","jabatan"=>"Wali Kelas 4 (sholih)"],
            ["nama"=>"Edwir","jabatan"=>"Wali Kelas 4 (sholih sholihah)"],
            ["nama"=>"Siti Fatonah, S.Pd","jabatan"=>"Wali Kelas 4 (sholihah)"],
            ["nama"=>"Ari Firdaus, A.Ma","jabatan"=>"Wali Kelas 5 (sholih)"],
            ["nama"=>"Sunartik, S.Pd","jabatan"=>"Wali Kelas 5 (sholihah)"],
            ["nama"=>"Iren Prabugma, S.Pd","jabatan"=>"Wali Kelas 5 (sholih)"],
            ["nama"=>"Iis Arika, S.E","jabatan"=>"Wali Kelas 6 (sholih)"],
            ["nama"=>"Ilam Maryam, S. Mat","jabatan"=>"Wali Kelas 6 (sholihah)"],
            ["nama"=>"Faradilla, S.Pd","jabatan"=>"MaPel B. Inggris 14 kelas"],
            ["nama"=>"Romadhon, S.Pd","jabatan"=>"MaPel PJOK 6 Kls & PAI 8 Kls"],
            ["nama"=>"Yusril, S.E.","jabatan"=>"MaPel PJOK 14 kelas"],
            ["nama"=>"Faturahman, S.Pd., M.Pd.","jabatan"=>"MaPel PAI 12 kls & Siroh 2 kls"],
            ["nama"=>"Melizah","jabatan"=>"MaPel Siroh 14 kelas"],
            ["nama"=>"Siti Nur Holis, S.Pd","jabatan"=>"Guru pengganti & Tes Jilid"],
            ["nama"=>"Kurniawan Achiryadi, S.T.","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Wencu Ali Murtopo, A.Md","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Deri Lisnawati, S.Sos","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Musdalifah, S.Pd","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Sudila Wasih, S.Pd.","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Pramuja, S.M","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Ela Tarina, S.E","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Dandy Badrul Zaman","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Nadia Novianti, S.Pd","jabatan"=>"Guru Qur'an 2 sesi"],
            ["nama"=>"Nurkhoirunnisa","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Elni Yufina, S.Pd.","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Marina","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Arina Hananan Taqiyya","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Ilham","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Ani Kinanti, S.T","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Annisa Alawiyah","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Budiono Rahman, S.Pd","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Nurul Hidayati","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Inda","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Lia","jabatan"=>"Guru Qur'an"],
            ["nama"=>"M. Sidik","jabatan"=>"Guru Qur'an"],
            ["nama"=>"Elisa Irmalia","jabatan"=>"UKS & Guru Pengganti Qur'an"],
            ["nama"=>"Biswin","jabatan"=>"Koord. Keamanan & Kebersihan"],
            ["nama"=>"Farel","jabatan"=>"Kebersihan "],
        ];

        foreach ($pegawais as $value) {
            $id_jabatan = Jabatan::where('nama',trim($value['jabatan']))->first()->id;
            // dd($id_jabatan);
            Pegawai::create([
                'nama'=> $value['nama'],
                'id_jabatan' => $id_jabatan
            ]);
        }
    }
}
