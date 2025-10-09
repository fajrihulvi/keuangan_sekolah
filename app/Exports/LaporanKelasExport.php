<?php

namespace App\Exports;

use App\Kategori;
use App\Models\Jenis;
use App\Models\Siswa;
use App\Transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Str;

class LaporanKelasExport implements FromView
{
    protected $year;
    protected $month;
    protected $class;

    public function forYear($year)
    {
        $this->year = $year;
        return $this;
    }
    public function forMonth($month)
    {
        $this->month = $month;
        return $this;
    }

    public function forClass($class)
    {
        $this->class = $class;
        return $this;
    }

    public function view(): View
    {
        $jenis = Jenis::all()->mapWithKeys(function ($item) {
            return [\Illuminate\Support\Str::lower($item->tipe) => $item->id];
        });

        $siswa = Siswa::where('id_kelas', $this->class)
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap']);

        $transaksi = Transaksi::with(['kategori:id,kategori', 'jenis:id,tipe'])
            ->whereIn('id_siswa', $siswa->pluck('id'))
            ->whereMonth('tanggal', $this->month)
            ->whereYear('tanggal', $this->year)
            ->get()
            ->groupBy([
                'id_siswa',
                function ($item) {
                    return $item->kategori->id;
                },
            ]);

        $totals = [];
        foreach ($transaksi as $siswaId => $categories) {
            $totals[$siswaId] = $categories->flatten()->sum('nominal');
        }
        $categoryTotals = [];
        foreach ($transaksi as $siswaId => $categories) {
            foreach ($categories as $categoryId => $transactions) {
                if (!isset($categoryTotals[$categoryId])) {
                    $categoryTotals[$categoryId] = 0;
                }
                $categoryTotals[$categoryId] += $transactions->sum('nominal');
            }
        }
        $grandTotal = collect($totals);
        $kategori = Kategori::where('id_tipe', $jenis['pemasukan'])
            ->get(['id', 'kategori', 'anggaran'])
            ->map(function ($item) use ($categoryTotals) {
                return [
                    'id' => $item->id,
                    'nama' => $item->kategori,
                    'anggaran' => $item->anggaran,
                    'total' => $categoryTotals[$item->id] ?? 0,
                ];
            });
            $totalAnggaran = $kategori->sum('anggaran');
            $totalAnggaranSiswa = $siswa->mapWithKeys(function($data) use($transaksi,$kategori){
                $totalBiaya = 0;
                foreach($kategori as $item){
                    if(isset($transaksi[$data->id][$item['id']])){
                        $totalBiaya+=$transaksi[$data->id][$item['id']][0]->nominal;
                    }
                }
                return [
                    $data->id => [
                        'total_biaya' => $totalBiaya,
                    ]
                ];
            });
            // dd($transaksi,$totalAnggaranSiswa);
        return view('app.exports.laporan-keuangan', compact('siswa', 'transaksi', 'kategori', 'grandTotal','totalAnggaran','totalAnggaranSiswa'));
    }
}
