<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KenaikanKelasController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data_siswa = [];
        $semua_kelas = Kelas::orderBy('nama_kelas','asc')->get();
        if($request->has('kelas_id')){
            $data_siswa = Siswa::select('nama_lengkap','nisn','id','id_kelas','keterangan')->with('kelas')->where('id_kelas',$request->input('kelas_id'))->orderBy('nama_lengkap','asc')->get();
            // dd($data_siswa);
        }
        return view('app.siswa.kenaikan',compact('semua_kelas','data_siswa'));
    }

    public function store(Request $request)
    {
        $request->validate(['kelas_tujuan_id'=>'sometimes']);
        // dd($request->kelas_tujuan_id);
        DB::beginTransaction();
        try {
            $siswaNaikIds = $request->input('siswa_ids',[]);
            $keteranganData = $request->input('keterangan', []);

            if(!empty($siswaNaikIds)){
                if(Str::lower($request->kelas_tujuan_id) == Kelas::where('nama_kelas')->get('id'))
                {
                    Siswa::whereIn('id',$siswaNaikIds)->update([
                        'id_kelas' => $request->kelas_tujuan_id,
                        'keterangan' => 'Telah Lulus pada' . date('Y-m-d'),
                    ]);
                }else{
                    $request->validate(['kelas_tujuan_id'=>'exists:kelas,id']);
                    Siswa::whereIn('id',$siswaNaikIds)->update([
                        'id_kelas' => $request->kelas_tujuan_id,
                        'keterangan' => null,
                    ]);
                }
            }

            foreach($keteranganData as $siswa_id => $keterangan)
            {
                if(!in_array($siswa_id, $siswaNaikIds) && !empty($keterangan))
                {
                    Siswa::where('id',$siswa_id)->update(['keterangan'=>$keterangan]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Proses kenaikan kelas berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }

}
