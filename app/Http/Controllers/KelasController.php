<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
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
        $data = Kelas::all();
        return view('app.kelas.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.kelas.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nama_kelas'=>'required'
        ]);
        Kelas::create($request->all());
        return redirect(route('kelas.index'))->with('success','Berhasil menambahkan data kelas');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Kelas::find($id);
        if(!$data)
        {
            return redirect(route('kelas.index'))->with('error','Data tidak ditemukan');
        }
        return view('app.kelas.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'nama_kelas'=>'required'
        ]);
        $data = Kelas::find($id);
        if(!$data)
        {
            return redirect(route('kelas.index'))->with('error','Data tidak ditemukan');
        }
        $data->update($request->all());
        $data->save();
        return redirect(route('kelas.index'))->with('success','Berhasil merubah data kelas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Kelas::find($id);
        if(!$data)
        {
            return back()->with('error','Data kelas tidak ditemukan');
        }
        $data->delete();
        return back()->with('success','Data kelas berhasil dihapus');
    }
}
