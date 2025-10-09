<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Siswa::with('kelas')->select(['id','nama_lengkap','nisn','id_kelas','nama_orangtua','alamat','keterangan'])->get();
        return view('app.siswa.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('app.siswa.add',compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nama_lengkap'=>'required|min:5',
            'alamat'=>'required|min:5',
            'nisn'=>'required|min:10|max:10',
            'id_kelas'=>'required|exists:kelas,id',
            'nama_orangtua'=>'required|min:5',
            'nohp_orangtua'=>'required|max:14|min:10',
        ]);

        Siswa::create($request->all());
        return redirect(route('siswa.index'))->with('success','Data siswa telah disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Siswa::find($id);
        if(!$data)
        {
            return redirect(route('siswa.index'))->with('error','Data tidak ditemukan');
        }
        $kelas = Kelas::all();
        return view('app.siswa.edit',compact('data','kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'nama_lengkap'=>'required|min:5',
            'nisn'=>'required|min:10|max:10',
            'alamat'=>'required|min:5',
            'id_kelas'=>'required|exists:kelas,id',
            'nama_orangtua'=>'required|min:5',
            'nohp_orangtua'=>'required|max:14|min:10',
        ]);
        $data = Siswa::find($id);
        if(!$data)
        {
            return redirect(route('siswa.index'))->with('error','Data tidak ditemukan');
        }
        $data->update($request->all());
        $data->save();
        return redirect(route('siswa.index'))->with('success','Berhasil ubah data siswa');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Siswa::find($id);
        if(!$data)
        {
            return back()->with('error','Data siswa tidak ditemukan');
        }

        $data->delete();
        return back()->with('success','Berhasil menghapus data siswa');
    }
}
