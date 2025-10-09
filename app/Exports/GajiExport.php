<?php

namespace App\Exports;

use App\Models\Gaji;
use App\Models\Kafalah;
use App\Models\Potongan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class GajiExport implements FromView
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;
        $data = Gaji::with('pegawai')
            ->where('bulan', $request->input('bulan'))
            ->where('tahun', $request->input('tahun'))
            ->get();

            $kafalah = Kafalah::get();
            $potongan = Potongan::get();
            return view('app.exports.excel-gaji',compact('data','kafalah','potongan'));
    }
}
