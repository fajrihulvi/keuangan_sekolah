@php
Carbon\Carbon::setLocale('id');
@endphp
@extends('app.master')

@section('konten')

<div class="content-body">

  <div class="row page-titles mx-0 mt-2">

    <h3 class="col p-md-0">Pengguna</h3>

    <div class="col p-md-0">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Gaji</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Detail</a></li>
      </ol>
    </div>

  </div>

  <div class="container-fluid">

    <div class="card">

      <div class="card-header pt-4">
        <div>
            <a href="{{ route('gaji.cetak', [
                'pegawai' => $data->id_pegawai,
                'tahun' => $data->tahun,
                'bulan' => $data->bulan,
            ]) }}" class="btn btn-warning float-right text-white ml-2">CETAK</a>
            <a href="{{ route('gaji.index') }}" class="btn btn-primary float-right "><i class="fa fa-arrow-left"></i> &nbsp KEMBALI</a>
        </div>
        <h4>Data Gaji Pegawai</h4>

      </div>
      <div class="card-body pt-0">

        <div class="row">

          <div class="col-lg-12">
            <div class="my-3">
                <table class="">
                    <tr>
                        <td>Nama</td>
                        <td class="px-4">:</td>
                        <td>{{ $data->pegawai->nama }}</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td class="px-4">:</td>
                        <td>{{ $data->pegawai->jabatan->nama }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td class="px-4">:</td>
                        <td>{{ Carbon\Carbon::create()->month($data->bulan)->translatedFormat('F') }} {{ Carbon\Carbon::create()->year($data->tahun)->translatedFormat('Y') }}</td>
                    </tr>
                </table>
            </div>
            <div class="row">
                <div class="table-responsive col-lg-6">
                    <h5 for="">Pemasukan</h5>
                    <table class="table table-bordered table-hover w-100">
                        <thead class="text-center">
                            <th scope="col">NO</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Nominal</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row">1</td>
                                <td>TUNJANGAN JABATAN</td>
                                <td class="text-align-center">{{ isset($data->kafalah['Tunjangan Jabatan']) ? 'Rp' . number_format($data->kafalah['Tunjangan Jabatan'],0,',','.') :'-' }}</td>
                            </tr>
                            @foreach ($pemasukan as $item)
                                @php
                                    $amount = $data->kafalah[$item->nama] ?? null;
                                @endphp
                                <tr>
                                    <td scope="row">{{ $loop->iteration + 1 }}</td>
                                    <td>{{ Str::upper($item->nama) }}</td>
                                    <td class="text-align-center">{{ $amount ? 'Rp' . number_format($amount,0,',','.') :'-' }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" scope="row" >TOTAL</td>
                                <td>{{ $data->total_pemasukan ? 'Rp' . number_format($data->total_pemasukan,0,',','.') :'Rp0' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive col-lg-6">
                    <h5 >Potongan</h5>
                    <table class="table table-bordered table-hover w-100">
                        <thead>
                            <th scope="col">NO</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Nominal</th>
                        </thead>
                        <tbody>
                            @foreach ($potongan as $item)
                                @php
                                    $amount = $data->potongan[$item->nama] ?? null;
                                @endphp
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{ Str::upper($item->nama) }}</td>
                                    <td class="text-align-center">{{ $amount ? 'Rp' . number_format($amount,0,',','.') :'-' }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" scope="row" >TOTAL</td>
                                <td>{{ $data->total_potongan ? 'Rp' . number_format($data->total_potongan,0,',','.') :'Rp0' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="table-responsive col-lg-6">
                <table class="table table-bordered">
                    <tr>
                        <td colspan="2" class="font-bold text-uppercase">Total Bersih</td>
                        <td class="font-bold">{{ $data->total_bersih ? 'Rp' . number_format($data->total_bersih,0,',','.') : "Rp0" }}</td>
                    </tr>
                </table>
            </div>
          </div>


        </div>

      </div>

    </div>

  </div>
  <!-- #/ container -->
</div>

@endsection
