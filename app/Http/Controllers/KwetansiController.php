<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Facades\Pdf;

class KwetansiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $kelas = Kelas::get();
        if($request->filled(['tahun','bulan','siswa']))
        {
            $pemasukan = null;
            $jenis = Jenis::get();
            foreach ($jenis as $item) {
                if (str::lower($item->tipe) == 'pemasukan') {
                    $pemasukan = $item->id;
                }
            }

            if($request->filled(['tanggal']))
            {
                $carbonDate = Carbon::create($request->tahun,$request->bulan,$request->tanggal);

                $data = Transaksi::where('id_siswa', $request->siswa)->where('jenis',$pemasukan)->whereMonth('updated_at',$carbonDate->month)->whereYear('updated_at',$carbonDate->year)->whereDay('updated_at',$carbonDate->day)->select('keterangan','nominal','updated_at')->get();
            } else{
                $carbonDate = Carbon::create($request->tahun,$request->bulan);
                $data = Transaksi::where('id_siswa', $request->siswa)->where('jenis',$pemasukan)->whereMonth('updated_at',$carbonDate->month)->whereYear('updated_at',$carbonDate->year)->select('keterangan','nominal','updated_at')->get();
            }

            // dd($request->bulan,$request->tahun);
            $siswa = Siswa::with('kelas')->where('id',$request->siswa)->select('nama_lengkap','nisn','id_kelas')->first();

            return view('app.kwetansi.index', compact('kelas','data','siswa'));
        }
        return view('app.kwetansi.index', compact('kelas'));
    }
    public function print(Request $request)
    {
        $kelas = Kelas::get();
        if($request->filled(['tahun','bulan','siswa']))
        {
            $pemasukan = null;
            $jenis = Jenis::get();
            foreach ($jenis as $item) {
                if (str::lower($item->tipe) == 'pemasukan') {
                    $pemasukan = $item->id;
                }
            }

            if($request->filled(['tanggal']))
            {
                $carbonDate = Carbon::create($request->tahun,$request->bulan,$request->tanggal);

                $data = Transaksi::where('id_siswa', $request->siswa)->where('jenis',$pemasukan)->whereMonth('updated_at',$carbonDate->month)->whereYear('updated_at',$carbonDate->year)->whereDay('updated_at',$carbonDate->day)->select('keterangan','nominal','updated_at')->get();
            } else{
                $carbonDate = Carbon::create($request->tahun,$request->bulan);
                $data = Transaksi::where('id_siswa', $request->siswa)->where('jenis',$pemasukan)->whereMonth('updated_at',$carbonDate->month)->whereYear('updated_at',$carbonDate->year)->select('keterangan','nominal','updated_at')->get();
            }

            // dd($request->bulan,$request->tahun);
            $siswa = Siswa::with('kelas')->where('id',$request->siswa)->select('nama_lengkap','nisn','id_kelas')->first();

            return view('app.kwetansi.print', compact('kelas','data','siswa'));
        }
        return view('app.kwetansi.print', compact('kelas'));
    }
    public function pdf(Request $request)
    {
        $kelas = Kelas::get();
        if($request->filled(['tahun','bulan','siswa']))
        {
            $pemasukan = null;
            $jenis = Jenis::get();
            foreach ($jenis as $item) {
                if (str::lower($item->tipe) == 'pemasukan') {
                    $pemasukan = $item->id;
                }
            }
            $data = Transaksi::where('id_siswa', $request->siswa)->where('jenis',$pemasukan)->select('keterangan','nominal')->get();
            $siswa = Siswa::with('kelas')->where('id',$request->siswa)->select('nama_lengkap','nisn','id_kelas')->first();

            $total = $data->sum('nominal');

            function terbilang($angka) {
                $satuan = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan"];
                $belasan = ["sepuluh", "sebelas", "dua belas", "tiga belas", "empat belas", "lima belas", "enam belas", "tujuh belas", "delapan belas", "sembilan belas"];
                $puluhan = ["", "", "dua puluh", "tiga puluh", "empat puluh", "lima puluh", "enam puluh", "tujuh puluh", "delapan puluh", "sembilan puluh"];

                if ($angka < 10) return $satuan[$angka];
                if ($angka < 20) return $belasan[$angka - 10];
                if ($angka < 100) return $puluhan[floor($angka / 10)] . ($angka % 10 !== 0 ? " " . $satuan[$angka % 10] : "");

                return "";
            }

            $terbilang = terbilang($total) . " rupiah";

            // $pdf = Pdf::loadView('app.kwetansi.pdf', compact('siswa', 'data', 'total', 'terbilang'))->setOptions(['isRemoteEnabled' => true]);
            pdf::view('app.kwetansi.pdf', compact('siswa', 'data', 'total', 'terbilang'))
                // ->format('a4')
                ->save('invoice.pdf');
            // return $pdf->download('kwetansi.pdf');
        }
        return view('app.kwetansi.index', compact('kelas'));
    }
}
