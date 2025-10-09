<?php

namespace App\Exports;

use App\Kategori;
use App\Models\Jenis;
use App\Transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DashboardExport implements FromView
{
    protected $year;
    protected $month;

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

    public function view(): View
    {
        // Get income data
        $incomeReport = $this->generateReport(['pemasukan', 'bantuan'], 'PENDAPATAN');

        // Get expense data
        $expenseReport = $this->generateReport(['pengeluaran'], 'PENGELUARAN');

        return view('app.exports.dashboard', [
            'incomeData' => $incomeReport['data'],
            'incomeTotal' => $incomeReport['total'],
            'expenseData' => $expenseReport['data'],
            'expenseTotal' => $expenseReport['total'],
            'bulan' => $this->month,
            'tahun' => $this->year,
            'namaBulan' => $this->getNamaBulan($this->month)
        ]);
    }

    private function generateReport(array $types, string $prefix)
    {
        $kategori = Kategori::whereHas('jenis', function($query) use ($types) {
            $query->whereIn('tipe', $types);
        })->get();

        $transaksiPerKategori = Transaksi::with(['kategori', 'jenis'])
            ->selectRaw('kategori_id, sum(nominal) as total')
            ->whereMonth('tanggal', $this->month)
            ->whereYear('tanggal', $this->year)
            ->whereIn('kategori_id', $kategori->pluck('id'))
            ->groupBy('kategori_id')
            ->get()
            ->keyBy('kategori_id');

        $reportData = [];
        $total = 0;

        foreach ($kategori as $item) {
            $nominal = $transaksiPerKategori->has($item->id)
                ? $transaksiPerKategori[$item->id]->total
                : 0;

            $reportData[] = [
                'label' => strtoupper($item->kategori),
                'nominal' => $nominal,
                'formatted' => 'Rp' . number_format($nominal, 0, ',', '.')
            ];
            $total += $nominal;
        }

        // Add empty row for Wakaf Bangunan if it's income report
        if ($prefix === 'PENDAPATAN') {
            $reportData[] = [
                'label' => 'WAKAF BANGUNAN',
                'nominal' => 0,
                'formatted' => 'Rp-'
            ];
        }

        return [
            'data' => $reportData,
            'total' => 'Rp' . number_format($total, 0, ',', '.')
        ];
    }

    private function getNamaBulan($bulan)
    {
        $bulanNames = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        return $bulanNames[$bulan] ?? '';
    }
}
