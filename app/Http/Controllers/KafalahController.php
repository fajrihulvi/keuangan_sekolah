<?php

namespace App\Http\Controllers;

use App\Models\Kafalah;
use Illuminate\Http\Request;

class KafalahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kafalah::orderBy('nama')->get();
        return view('app.kafalah.index',compact('data'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'nominal' => 'required|string'
        ]);
        $request->merge([
            'nominal' => preg_replace('/\D/', '', $request->nominal),
        ]);
        Kafalah::create([
            'nama' => $request['nama'],
            'nominal' => $request['nominal']
        ]);
        return back()->with('success', 'Berhasil menambahkan data.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kafalah $kafalah)
    {
        $req = $request->validate([
            'nama' => 'required|string|max:50',
            'nominal' => 'required|string'
        ]);
        $req['nominal'] = preg_replace('/\D/', '', $request->nominal);
        $kafalah->update([
            'nama' => $req['nama'],
            'nominal' => $req['nominal']
        ]);
        return back()->with('success','Berhasil mempebarui data.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kafalah $kafalah)
    {
        $kafalah->delete();
        return back()->with('success','Berhasil menghapus data.');
    }
}
