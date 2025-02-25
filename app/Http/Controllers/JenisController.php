<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
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
        $data = Jenis::all();
        return view('app.jenis.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.jenis.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'tipe'=>'required'
        ]);
        Jenis::create($request->all());
        return redirect(route('jenis.index'))->with('success','Berhasil menambahkan tipe baru');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data  = Jenis::find($id);
        if(!$data)
        {
            return redirect(route('jenis.index'))->with('error','Data tidak ditemukan');
        }
        return view('app.jenis.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'tipe'=>'required'
        ]);
        $data = Jenis::find($id);
        if(!$data)
        {
            return redirect(route('jenis.index'))->with('error','Data tidak ditemukan');
        }
        $data->update($request->all());
        $data->save();
        return redirect(route('jenis.index'))->with('success','Berhasil ubah data jenis');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Jenis::find($id);
        if(!$data)
        {
            return back()->with('error','Data jenis tidak ditemukan');
        }
        $data->delete();
        return back()->with('success','Data jenis berhasil dihapus');
    }
}
