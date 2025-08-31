<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Jabatan::orderByDesc('id')->paginate();
        return view('app.jabatan.index',compact('data'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jabatan = $request->validate([
            'nama' => 'required|string|max:50',
            'tunjangan' => 'required'
        ]);
        $request->merge([
            'tunjangan' => preg_replace('/\D/', '', $request->tunjangan),
        ]);
        Jabatan::create([
            'nama' => $jabatan['nama'],
            'tunjangan' => $request->tunjangan,
        ]);
        return back()->with('success', 'Berhasil menambahkan data.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $req = $request->validate([
            'nama' => 'required|string|max:50',
            'edit_tunjangan' => 'required'
        ]);
        $request->merge([
            'edit_tunjangan' => preg_replace('/\D/', '', $request->edit_tunjangan),
        ]);
        $jabatan->update([
            'nama' => $req['nama'],
            'tunjangan' => $request->edit_tunjangan,
        ]);
        return back()->with('success','Berhasil mempebarui data.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return back()->with('success','Berhasil menghapus data.');
    }
}
