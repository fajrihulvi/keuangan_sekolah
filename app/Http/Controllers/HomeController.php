<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Kategori;
use App\Transaksi;
use App\User;

use Hash;
use Auth;
use File;
use PDF;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Jenis;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromView;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $kategori = Kategori::all();
        $tanggal = date('Y-m-d');
        $bulan = date('m');
        $tahun = date('Y');
        $jenis = Jenis::all();
        $pemasukan = 0;
        $pengeluaran = 0;
        $bantuan = 0;

        foreach ($jenis as $item) {
            if (Str::lower($item->tipe) == 'pemasukan') {
                $pemasukan = $item->id;
            } elseif (Str::lower($item->tipe) == 'pengeluaran') {
                $pengeluaran = $item->id;
            } else {
                $bantuan = $item->id;
            }
        }

        $pemasukan_hari_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis',$pemasukan)
        ->whereDate('tanggal',$tanggal)
        ->first();

        $pemasukan_bulan_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis',$pemasukan)
        ->whereMonth('tanggal',$bulan)
        ->first();

        $pemasukan_tahun_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis',$pemasukan)
        ->whereYear('tanggal',$tahun)
        ->first();

        $seluruh_pemasukan = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis',$pemasukan)
        ->first();

        $pengeluaran_hari_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis',$pengeluaran)
        ->whereDate('tanggal',$tanggal)
        ->first();

        $pengeluaran_bulan_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis',$pengeluaran)
        ->whereMonth('tanggal',$bulan)
        ->first();

        $pengeluaran_tahun_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis',$pengeluaran)
        ->whereYear('tanggal',$tahun)
        ->first();

        $seluruh_pengeluaran = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis',$pengeluaran)
        ->first();

        $bantuan_hari_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis',$bantuan)
        ->whereDate('tanggal',$tanggal)
        ->first();

        $bantuan_bulan_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis',$bantuan)
        ->whereMonth('tanggal',$bulan)
        ->first();

        $bantuan_tahun_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis',$bantuan)
        ->whereYear('tanggal',$tahun)
        ->first();

        $seluruh_bantuan = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis',$bantuan)
        ->first();

        $kategori_filter = $kategori;
        if(isset($_GET['kategori']))
        {
            $kategori_filter = Kategori::where('id_tipe',$_GET['kategori'])->get();
            if(!$kategori_filter) $kategori_filter = $kategori;
        }


        return view('app.index',
            [
                'pemasukan_hari_ini' => $pemasukan_hari_ini,
                'pemasukan_bulan_ini' => $pemasukan_bulan_ini,
                'pemasukan_tahun_ini' => $pemasukan_tahun_ini,
                'seluruh_pemasukan' => $seluruh_pemasukan,
                'pengeluaran_hari_ini' => $pengeluaran_hari_ini,
                'pengeluaran_bulan_ini' => $pengeluaran_bulan_ini,
                'pengeluaran_tahun_ini' => $pengeluaran_tahun_ini,
                'seluruh_pengeluaran' => $seluruh_pengeluaran,
                'bantuan_hari_ini' => $bantuan_hari_ini,
                'bantuan_bulan_ini' => $bantuan_bulan_ini,
                'bantuan_tahun_ini' => $bantuan_tahun_ini,
                'seluruh_bantuan' => $seluruh_bantuan,
                'kategori' => $kategori,
                'jenis' => $jenis,
                'kategori_filter'=>$kategori_filter
            ]
        );
    }

    public function kategori()
    {
        $kategori = Kategori::with('jenis')->orderBy('kategori','asc')->get();
        $siswa = Siswa::all();
        $kelas = Kelas::all();
        $jenis = Jenis::all();
        return view('app.kategori',compact('kategori','siswa','kelas','jenis'));
    }

    public function kategori_aksi(Request $req)
    {
        $this->validate($req,[
            'kategori' => 'required',
            'id_tipe' => 'required|exists:jenis,id',
            'untuk_siswa'=> 'required|in:N,Y'
        ]);
        // dd($req->all());
        Kategori::create($req->all());
        return redirect('kategori')->with('success','Kategori telah disimpan');
    }

    public function kategori_update($id, Request $req)
    {
        $this->validate($req,[
            'kategori' => 'required',
            'id_tipe' => 'required|exists:jenis,id',
            'untuk_siswa'=> 'required|in:N,Y'
        ]);
        $kategori = Kategori::find($id);
        if(!$kategori)
        {
            return redirect('kategori')->with('error','Kategori tidak ditemukan');
        }
        $kategori->update($req->all());
        // $kategori->save();
        return redirect('kategori')->with('success','Kategori telah diupdate');
    }

    public function kategori_delete($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();

        $tt = Transaksi::where('kategori_id',$id)->get();

        if($tt->count() > 0){
            $transaksi = Transaksi::where('kategori_id',$id)->first();
            $transaksi->kategori_id = "1";
            $transaksi->save();
        }
        return redirect('kategori')->with('success','Kategori telah dihapus');
    }

    public function password()
    {
        return view('app.password');
    }

    public function password_update(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
        // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
        //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success","Password telah diganti!");
    }

    public function transaksi(Request $request)
    {
        // $transaksi = Transaksi::orderBy('id','desc')->get();
        $transaksi = Transaksi::query();
        if($request->filled('jenis'))
        {
            $transaksi->where('jenis',$request->jenis);
        }
        if($request->filled('kategori'))
        {
            $transaksi->where('kategori_id',$request->kategori);
        }
        if($request->filled('bulan'))
        {
            $transaksi->whereMonth('created_at',$request->bulan);
        }
        if($request->filled('tahun'))
        {
            $transaksi->whereYear('created_at',$request->tahun);
        }

        $transaksi=$transaksi->orderBy('id','desc')->get();
        $kategori = Kategori::orderBy('kategori','asc')->get();
        $jenis = Jenis::all();
        $kelas = Kelas::all();
        // $siswa = Siswa::all();
        return view('app.transaksi',compact('transaksi','kategori','jenis','kelas',));
    }

    public function transaksi_aksi(Request $req)
    {
        // dd($req->all());
        $req->validate([
            'tanggal'=>"required",
            'jenis'=>"required",
            'kategori_id'=>"required|exists:kategori,id",
            'nominal'=>'required',
            'keterangan'=>'required',
        ]);
        $req->merge([
            'nominal' => preg_replace('/\D/', '', $req->nominal),
        ]);
        // dd($req->all());
        try {
            foreach ($req->kategori_id as $index => $kategori_id) {
                // $req->nominal = preg_replace('/\D/', '', $req->nominal[$index]);
                Transaksi::create([
                    'tanggal' => $req->tanggal[$index],
                    'jenis' => $req->jenis[$index],
                    'kategori_id' => $kategori_id,
                    'id_siswa' => $req->id_siswa[$index] ?? null,
                    'nominal' => $req->nominal[$index],
                    'keterangan' => $req->keterangan[$index],
                ]);
            }

            DB::commit();

            return redirect()->back()->with("success", "Semua transaksi berhasil disimpan!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", "Gagal menyimpan transaksi: " . $e->getMessage());
        }
    }

    public function transaksi_update($id, Request $req)
    {

        $tanggal = $req->input('tanggal');
        $jenis = $req->input('jenis');
        $kategori = $req->input('kategori');
        $nominal = $req->input('nominal');
        $keterangan = $req->input('keterangan');

        $transaksi = Transaksi::find($id);
        if($tanggal != null){
            $transaksi->tanggal = $tanggal;
        }
        if($jenis != null){
            $transaksi->jenis = $jenis;
        }
        if($kategori != null){
            $transaksi->kategori_id = $kategori;
        }
        if($nominal != null){
            $transaksi->nominal = $nominal;
        }
        if($keterangan != null){
            $transaksi->keterangan = $keterangan;
        }
        $transaksi->save();

        return redirect()->back()->with("success","Transaksi telah diupdate!");
    }

    public function transaksi_delete($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->delete();
        return redirect()->back()->with("success","Transaksi telah dihapus!");
    }

    public function laporan()
    {
        if(isset($_GET['kategori'])){
            $kategori = Kategori::orderBy('kategori','asc')->get();
            $transaksi = "";
            if($_GET['kategori'] == ""){
                $transaksi = Transaksi::whereDate('tanggal','>=',$_GET['dari'])
                ->whereDate('tanggal','<=',$_GET['sampai'])
                ->get();
            }else{
                $transaksi = Transaksi::where('kategori_id',$_GET['kategori'])
                ->whereDate('tanggal','>=',$_GET['dari'])
                ->whereDate('tanggal','<=',$_GET['sampai'])
                ->get();
            }
            // $transaksi = Transaksi::orderBy('id','desc')->get();
            return view('app.laporan',['transaksi' => $transaksi, 'kategori' => $kategori,'jenis'=>Jenis::get()]);
        }else{
            $kategori = Kategori::orderBy('kategori','asc')->get();
            $jenis =Jenis::get();
            return view('app.laporan',['transaksi' => array(), 'kategori' => $kategori,'jenis'=>$jenis]);
        }
    }

    public function laporan_print()
    {
        if(isset($_GET['kategori'])){
            $kategori = Kategori::orderBy('kategori','asc')->get();
            if($_GET['kategori'] == ""){
                $transaksi = Transaksi::whereDate('tanggal','>=',$_GET['dari'])
                ->whereDate('tanggal','<=',$_GET['sampai'])
                ->get();
            }else{
                $transaksi = Transaksi::where('kategori_id',$_GET['kategori'])
                ->whereDate('tanggal','>=',$_GET['dari'])
                ->whereDate('tanggal','<=',$_GET['sampai'])
                ->get();
            }
            // $transaksi = Transaksi::orderBy('id','desc')->get();
            return view('app.laporan_print',['transaksi' => $transaksi, 'kategori' => $kategori,'jenis'=>Jenis::all()]);
        }
    }

    // public function laporan_excel()
    // {
    //     return Excel::download(new LaporanExport, 'Laporan.xlsx');
    // }

    public function laporan_pdf()
    {
        if(isset($_GET['kategori'])){
            $kategori = Kategori::orderBy('kategori','asc')->get();
            if($_GET['kategori'] == ""){
                $transaksi = Transaksi::whereDate('tanggal','>=',$_GET['dari'])
                ->whereDate('tanggal','<=',$_GET['sampai'])
                ->get();
            }else{
                $transaksi = Transaksi::where('kategori_id',$_GET['kategori'])
                ->whereDate('tanggal','>=',$_GET['dari'])
                ->whereDate('tanggal','<=',$_GET['sampai'])
                ->get();
            }
            $pdf = PDF::loadView('app.laporan_pdf', ['transaksi' => $transaksi, 'kategori' => $kategori,'jenis'=>Jenis::all()]);
            return $pdf->download('Laporan Keuangan.pdf');
        }

    }

    public function user()
    {
        $user = User::all();
        return view('app.user',['user' => $user]);
    }

    public function user_add()
    {
        return view('app.user_tambah');
    }

    public function user_aksi(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5',
            'level' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('foto');

        // cek jika gambar kosong
        if($file != ""){
            // menambahkan waktu sebagai pembuat unik nnama file gambar
            $nama_file = time()."_".$file->getClientOriginalName();

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'gambar/user';
            $file->move($tujuan_upload,$nama_file);
        }else{
            $nama_file = "";
        }


        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => $request->level,
            'foto' => $nama_file
        ]);

        return redirect(route('user'))->with('success','User telah disimpan');
    }

    public function user_edit($id)
    {
        $user = User::find($id);
        return view('app.user_edit', ['user' => $user]);
    }

    public function user_update($id, Request $req)
    {
         $this->validate($req, [
            'nama' => 'required',
            'email' => 'required|email',
            'level' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $name = $req->input('nama');
        $email = $req->input('email');
        $password = $req->input('password');
        $level = $req->input('level');


        $user = User::find($id);
        $user->name = $name;
        $user->email = $email;
        if($password != ""){
            $user->password = bcrypt($password);
        }

        // menyimpan data file yang diupload ke variabel $file
        $file = $req->file('foto');

        // cek jika gambar tidak kosong
        if($file != ""){
            // menambahkan waktu sebagai pembuat unik nnama file gambar
            $nama_file = time()."_".$file->getClientOriginalName();

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'gambar/user';
            $file->move($tujuan_upload,$nama_file);

            // hapus file gambar lama
            File::delete('gambar/user/'.$user->foto);

            $user->foto = $nama_file;
        }
        $user->level = $level;
        $user->save();

        return redirect(route('user'))->with("success","User telah diupdate!");
    }

    public function user_delete($id)
    {
        $user = User::find($id);
        // hapus file gambar lama
        File::delete('gambar/user/'.$user->foto);
        $user->delete();

        return redirect(route('user'))->with("success","User telah dihapus!");
    }

    public function getSiswaInKelas(Request $request, Siswa $siswa)
    {
        if($request->filled("kelas")){
            $data=$siswa->where("id_kelas","LIKE",$request->kelas)->get();
            if(!$data){
                return json_encode("Tidak ada siswa");
            }
            return json_encode($data);
        }else{
            return json_encode("Pilih kelas");
        }
    }
    public function getKelas()
    {
        $data = Kelas::get();
        return json_encode($data);
    }

    public function dataCategotyMonth(Request $request){
        $jenis = Jenis::get();
        $kategori = Kategori::get();
        $pemasukan = null;
        $pengeluaran = null;
        $bantuan = null;
        foreach ($jenis as $item) {
            if (Str::lower($item->tipe) == 'pemasukan') {
                $pemasukan = $item->id;
            } elseif (Str::lower($item->tipe) == 'pengeluaran') {
                $pengeluaran = $item->id;
            } else {
                $bantuan = $item->id;
            }
        }
        $totalRevenue = array();
        $dataPengeluaran = array();
        $validate= Validator::make($request->all(),["tipe"=>'exists:jenis,id']);
        if($validate->fails()){
            return response()->json(['message'=>"Tipe tidak ada"],422);
        }

        $bln = date('m');
        if(isset($request->tipe)){
            foreach ($kategori as $k){
                $id_kategori = $k->id;
                if($k->id_tipe == $request->tipe){
                    $pemasukan_perkategori = DB::table('transaksi')->select(DB::raw('SUM(nominal) as total'))->where('jenis', $pemasukan)->where('kategori_id', $id_kategori)->whereMonth('tanggal', $bln)->first();
                    $total = $pemasukan_perkategori->total;

                    if ($pemasukan_perkategori->total == '') {
                        array_push($totalRevenue, ["kategori"=> $k->kategori,"total"=>0]);
                    } else {
                        array_push($totalRevenue, ["kategori"=> $k->kategori,"total"=> $total]);
                    }

                    $pengeluaran_perkategori = DB::table('transaksi')->select(DB::raw('SUM(nominal) as total'))->where('jenis', $pengeluaran)->where('kategori_id', $id_kategori)->whereMonth('tanggal', $bln)->first();
                    $totalPengeluaran = $pengeluaran_perkategori->total;
                    if ($pengeluaran_perkategori->total == '') {
                        array_push($dataPengeluaran,["kategori"=>$k->kategori,"total"=>0]);
                    } else {
                        array_push($dataPengeluaran,["kategori"=>$k->kategori,"total"=>$totalPengeluaran]);
                    }
                }
            }
        }else{
            foreach ($kategori as $k){
            $id_kategori = $k->id;
                $pemasukan_perkategori = DB::table('transaksi')->select(DB::raw('SUM(nominal) as total'))->where('jenis', $pemasukan)->where('kategori_id', $id_kategori)->whereMonth('tanggal', $bln)->first();
                $total = $pemasukan_perkategori->total;

                if ($pemasukan_perkategori->total == null) {
                    array_push($totalRevenue, ["kategori"=> $k->kategori,"total"=>0]);
                    // array_push($totalRevenue, ["kategori"=> $k->kategori,"total"=>'0,']);
                } else {
                    array_push($totalRevenue, ["kategori"=> $k->kategori,"total"=>  $total]);
                }

                $pengeluaran_perkategori = DB::table('transaksi')->select(DB::raw('SUM(nominal) as total'))->where('jenis', $pengeluaran)->where('kategori_id', $id_kategori)->whereMonth('tanggal', $bln)->first();
                $totalPengeluaran = $pengeluaran_perkategori->total;
                if ($pengeluaran_perkategori->total == '') {
                    array_push($dataPengeluaran,["kategori"=>$k->kategori,"total"=>0]);
                    // array_push($dataPengeluaran,["kategori"=>$k->kategori,"total"=>'0,']);
                } else {
                    array_push($dataPengeluaran,["kategori"=>$k->kategori,"total"=>$totalPengeluaran]);
                }
            }
        }
        // dd($totals);
        return response()->json(["pemasukan"=>$totalRevenue,"pengeluaran"=>$dataPengeluaran],200);
    }

    public function importSiswa(Request $request)
    {
        try {
            // dd($request->file('import_siswa'));
            Excel::import(new SiswaImport, $request->file('import_siswa'));
            return redirect()->route('siswa.index')->with('success','Berhasil menambahkan data siswa dari file');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('siswa.index')->with('error','Gagal menambahkan data siswa dari file');
        }
    }

}
