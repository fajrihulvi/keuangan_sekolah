<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pegawai::orderByDesc('id')->get();
        $jabatan = Jabatan::all();
        return view('app.pegawai.index',compact('data','jabatan'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:50',
            'id_jabatan' => 'required|exists:jabatan,id'
        ]);
        Pegawai::create($data);
        return back()->with('success', 'Berhasil menambahkan data.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'id_jabatan' => 'required|exists:jabatan,id'
        ]);
        $pegawai = Pegawai::find($id);
        $pegawai->update($request->all());

        $pegawai = Pegawai::find($id);
        return back()->with('success','Berhasil mempebarui data.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pegawai::find($id)->delete();
        return back()->with('success','Berhasil menghapus data.');
    }
}
