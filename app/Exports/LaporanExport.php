<?php

namespace App\Exports;

use App\Kategori;
use App\Models\Jenis;
use App\Transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;

class LaporanExport implements FromView
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;

        $kategoriId = $request->input('kategori');
        $tanggalDari = $request->input('dari');
        $tanggalSampai = $request->input('sampai');

        // Mengambil transaksi berdasarkan filter
        $query = Transaksi::with('siswa')
                    ->whereDate('tanggal', '>=', $tanggalDari)
                    ->whereDate('tanggal', '<=', $tanggalSampai);

        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        $transaksi = $query->get();

        // Mengambil nama kategori untuk ditampilkan
        $namaKategori = 'SEMUA KATEGORI';
        if ($kategoriId) {
            $kategori = Kategori::find($kategoriId);
            if ($kategori) {
                $namaKategori = $kategori->kategori;
            }
        }

        // Meneruskan semua data yang diperlukan ke view
        return view('app.laporan_excel', [
            'transaksi' => $transaksi,
            'namaKategori' => $namaKategori,
            'tanggalDari' => $tanggalDari,
            'tanggalSampai' => $tanggalSampai,
            // Anda bisa menghapus 'kategori' dan 'jenis' jika tidak diperlukan di view
            'jenis' => Jenis::get(),
        ]);
    }
}
