<?php

namespace App\Http\Controllers;

use App\Models\Potongan;
use Illuminate\Http\Request;

class PotonganController extends Controller
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
        $data = Potongan::orderBy('nama')->get();
        // dd($data);
        return view('app.potongan.index',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:50',
            'nominal' => 'required|string'
        ]);
        $data['nominal'] = preg_replace('/\D/', '', $request->nominal);
        Potongan::create($data);
        return back()->with('success','Berhasil menambahkan kategori potongan');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $potongan = Potongan::find($id);
        if(!$potongan){
            return back()->with('error','Gagal memperbarui potongan');
        }
        $data = $request->validate([
            'nama' => 'required|max:50',
            'nominal' => 'required|string'
        ]);
        $data['nominal'] = preg_replace('/\D/', '', $request->nominal);
        $potongan->update($data);
        return back()->with('success','Berhasil memperbarui data potongan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $potongan = Potongan::find($id);
        if(!$potongan) {
            return back()->with('error','Gagal menghapus data potongan.');
        }
        $potongan->delete();
        return back()->with('success','Berhasil menghapus data potongan.');
    }
}
