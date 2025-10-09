<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Exports\LaporanKelasExport;
use App\Kategori;
use App\Models\Jenis;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Transaksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $kelas = Kelas::all();
        $grandTotal = [];
        $jenis = [];
        $transaksi = [];
        $kategori = [];
        $siswa = [];
        $totalAnggaran = [];
        $totalAnggaranSiswa = [];
        if ($request->filled(['kelas', 'bulan', 'tahun'])) {
            $jenis = Jenis::all()->mapWithKeys(function ($item) {
                return [\Illuminate\Support\Str::lower($item->tipe) => $item->id];
            });

            $siswa = Siswa::where('id_kelas', $request->kelas)
                ->orderBy('nama_lengkap')
                ->get(['id', 'nama_lengkap']);

            $transaksi = Transaksi::with(['kategori:id,kategori', 'jenis:id,tipe'])
                ->whereIn('id_siswa', $siswa->pluck('id'))
                ->whereMonth('tanggal', $request->bulan)
                ->whereYear('tanggal', $request->tahun)
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
            $totalAnggaranSiswa = $siswa->mapWithKeys(function ($data) use ($transaksi, $kategori) {
                $totalBiaya = 0;
                foreach ($kategori as $item) {
                    if (isset($transaksi[$data->id][$item['id']])) {
                        $totalBiaya += $transaksi[$data->id][$item['id']][0]->nominal;
                    }
                }
                return [
                    $data->id => [
                        'total_biaya' => $totalBiaya,
                    ],
                ];
            });
        }
        // return (new LaporanKelasExport())->forClass(13)->forMonth(03)->forYear(2025)->view();
        return view('app.laporan-keuangan.index', compact('kelas','siswa', 'transaksi', 'kategori', 'grandTotal','totalAnggaran','totalAnggaranSiswa'));
        // return view('app.laporan-keuangan.index', compact('kelas', 'siswa', 'transaksi', 'kategori', 'grandTotal'));
        // return (new LaporanKelasExport)->forClass(13)->forMonth(03)->forYear(2025)->view();
        // return Excel::download((new LaporanKelasExport)->forClass(13)->forMonth(03)->forYear(2025), 'invoices.xlsx');
    }

    public function export(Request $request)
    {
        if ($request->filled(['bulan', 'tahun', 'kelas'])) {
            $namaKelas = Kelas::where('id', $request->kelas)->first()->nama_kelas;
            $namaFile = 'laporan-Keuangan-' . $namaKelas . '-' . $request->bulan . '-' . $request->tahun . '.xlsx';
            // dd($namaFile);
            return Excel::download((new LaporanKelasExport())->forClass($request->kelas)->forMonth($request->bulan)->forYear($request->tahun), $namaFile);
        }
        return back();
    }
}
