<?php

namespace App\Http\Controllers;

use App\Exports\GajiExport;
use App\Models\Gaji;
use App\Models\Jabatan;
use App\Models\Kafalah;
use App\Models\Pegawai;
use App\Models\Potongan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GajiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Gaji::with(['pegawai'])
            // ->select(['gaji_pegawai.id','gaji_pegawai.id_pegawai','gaji_pegawai.bulan','gaji_pegawai.tahun','gaji_pegawai.total_bersih'])
            ->latest()
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->orderBy(Pegawai::select('nama')->whereColumn('pegawai.id', 'gaji_pegawai.id_pegawai'))
            ->get();
        $pegawai = Pegawai::with('jabatan')->get();
        $kafalah = Kafalah::all();
        $potongan = Potongan::all();
        // dd($data[3]->potongan['Menikah']);
        $jabatan = Jabatan::get();
        return view('app.gaji.index', compact('data', 'pegawai', 'kafalah', 'potongan','jabatan'));
    }

    public function store(Request $request)
    {
        $req = $request->validate([
            'pegawai' => 'required|exists:pegawai,id',
            'pemasukan' => 'sometimes|array',
            // 'pemasukan.*' => 'exists:kafalah,id',
            'pemasukan-nominal' => 'sometimes|array',
            // 'pemasukan-nominal.*' => 'string',
            'potongan' => 'sometimes|array',
            // 'potongan.*' => 'exists:potongan,id',
            'potongan-nominal' => 'sometimes|array',
            // 'potongan-nominal.*' => 'string',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);
        // dd($req);
        DB::beginTransaction();
        try {
            $employee = Pegawai::select('id', 'id_jabatan')->findOrFail($req['pegawai']);
            $position = Jabatan::findOrFail($employee->id_jabatan);
            $grossSalaryNominal = 0;
            $dedictionsNominal = 0;
            $grossSalary = array();
            $deductions = array();
            foreach ($req['pemasukan'] as $index => $data) {
                if($data == null ){
                    continue;
                }
                $income = Kafalah::find($data);
                $nominal = (int) preg_replace('/\D/', '', $req['pemasukan-nominal'][$index]);
                $grossSalary[$income->nama] = $nominal;
                $grossSalaryNominal += $nominal;
            }
            foreach ($req['potongan'] as $index => $data) {
                if($data == null ){
                    continue;
                }
                $deduction = Potongan::find($data);
                $nominal = preg_replace('/\D/', '', $req['potongan-nominal'][$index]);
                $deductions[$deduction->nama] = $nominal;
                $dedictionsNominal += $nominal;
            }
            $grossSalary['Tunjangan Jabatan'] = $position->tunjangan;
            $grossSalaryNominal += $position->tunjangan;
            $cleanedAmount =  $grossSalaryNominal - $dedictionsNominal;

            Gaji::create([
                'id_pegawai' => $employee->id,
                'jabatan' => $position->nama,
                'kafalah' => $grossSalary,
                'potongan' => $deductions,
                'bulan' => $req['bulan'],
                'tahun' => $req['tahun'],
                'total_potongan' => $dedictionsNominal,
                'total_pemasukan' => $grossSalaryNominal,
                'total_bersih' => $cleanedAmount,
            ]);
            DB::commit();

            return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data gaji: ' . $e->getMessage());
        }
    }


    public function show(string $id){
        $data = Gaji::findOrFail($id);
        $pemasukan = Kafalah::all();
        $potongan = Potongan::all();
        return view('app.gaji.show',compact('data','pemasukan','potongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $req = $request->validate([
            'pegawai' => 'required|exists:pegawai,id',
            'pemasukan' => 'sometimes|array',
            // 'pemasukan.*' => 'exists:kafalah,id',
            'pemasukan_nominal' => 'sometimes|array',
            // 'pemasukan-nominal.*' => 'string',
            'potongan' => 'sometimes|array',
            // 'potongan.*' => 'exists:potongan,id',
            'potongan_nominal' => 'sometimes|array',
            // 'potongan-nominal.*' => 'string',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'jabatan' => 'required|exists:jabatan,id',
            'nominal-jabatan'=>'required',
        ]);
        DB::beginTransaction();
        // dd($request->all());
        try {
            $employee = Pegawai::select('id', 'id_jabatan')->findOrFail($req['pegawai']);
            $position = Jabatan::findOrFail($req['jabatan']);
            // dd($position);
            $gaji = Gaji::findOrFail($id);
            $grossSalaryNominal = 0;
            $dedictionsNominal = 0;
            $grossSalary = array();
            $deductions = array();
            foreach ($req['pemasukan'] as $index => $data) {
                if($data == null ){
                    continue;
                }
                $income = Kafalah::find($data);
                $nominal = $req['pemasukan_nominal'][$index];
                $nominal = (int) preg_replace('/\D/', '', $nominal);
                // if(str_contains($nominal,'Rp.')){
                // }
                $grossSalary[$income->nama] = $nominal;
                $grossSalaryNominal += $nominal;
            }
            foreach ($req['potongan'] as $index => $data) {
                if($data == null ){
                    continue;
                }
                $deduction = Potongan::find($data);
                $nominal = preg_replace('/\D/', '', $req['potongan_nominal'][$index]);
                $deductions[$deduction->nama] = $nominal;
                $dedictionsNominal += $nominal;
            }
            $grossSalary['Tunjangan Jabatan'] = (int) preg_replace('/\D/', '', $req['nominal-jabatan']);;
            $grossSalaryNominal += $position->tunjangan;
            $cleanedAmount =  $grossSalaryNominal - $dedictionsNominal;

            $gaji->update([
                'id_pegawai' => $employee->id,
                'jabatan' => $position->nama,
                'kafalah' => $grossSalary,
                'potongan' => $deductions,
                'bulan' => $req['bulan'],
                'tahun' => $req['tahun'],
                'total_potongan' => $dedictionsNominal,
                'total_pemasukan' => $grossSalaryNominal,
                'total_bersih' => $cleanedAmount,
            ]);
            DB::commit();

            return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data gaji: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Gaji::findOrFail($id);
        $data->delete();
        return back()->with('success', 'Berhasil menghapus data.');
    }

    public function cetakGaji(Request $request)
    {
        $pegawai = Pegawai::all();
        if(!$request->has(['pegawai','tahun','bulan'])){
            return view('app.gaji.rekap',compact('pegawai'));
        }
        $data = Gaji::query();
        if($request->has('pegawai')){
            $data->where('id_pegawai',$request->pegawai);
        }
        if($request->has('tahun')){
            $data->where('tahun',$request->tahun);
        }
        if($request->has('bulan')){
            $data->where('bulan',$request->bulan);
        }
        $data = $data->first();
        $kafalah = Kafalah::all();
        $potongan = Potongan::all();
        return view('app.gaji.rekap',compact('pegawai','data','kafalah','potongan'));
    }

    public function printGaji(Request $request){
        $data = Gaji::find($request->id);
        $kafalah = Kafalah::all();
        $potongan = Potongan::all();
        return view('app.gaji.cetak',compact('data','kafalah','potongan'));
    }

    public function laporanGaji(Request $request){
        if($request->has(['bulan','tahun'])){
            $data = Gaji::with('pegawai')
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->get();

            $kafalah = Kafalah::get();
            $potongan = Potongan::get();
            // dd($data[29]);
            return view('app.laporan-gaji',compact('data','kafalah','potongan'));
        }
        return view('app.laporan-gaji');
    }

    public function exportGaji(Request $request){
        $bulan = Carbon::createFromDate(null,$request->input('bulan'),null)->getTranslatedMonthName();
        return Excel::download(new GajiExport($request), "Laporan Gaji ". $bulan." ". $request->input('tahun') .".xlsx");
    }
}

