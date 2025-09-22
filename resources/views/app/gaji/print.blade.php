<div class="kw-nav">
    <img src="{{ asset('gambar/sistem/logo1.png') }}" alt="" class="img-fluid">
    <div class="kw-header">
        <h3><b>YAYASAN ADH-DHUHAA PANGKALPINANG</b></h3>
        <h3><b>SEKOLAH DASAR ISLAM TERPADU QURANI ADH-DHUHAA</b></h3>
        <p>Jl. Melati 1 No. 257 Ke. Taman Bunga Kec. Gerunggang Kota Pangkalpinang Provinsi Kep. Bangka Belitung</p>
    </div>
    <img src="{{ asset('gambar/sistem/logo-jsit-06.png') }}" alt="" class="img-fluid">
</div>

<h3 class="kw-title"><b>SLIP GAJI</b></h3>

<div class="w-100 my-4">
    <div class="col-4">
        <table class="table table-borderless">
            <tr>
                <td>Bulan</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::create()->month(request()->bulan)->translatedFormat('F') . ' ' . request()->tahun }}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $data->pegawai->nama }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $data->pegawai->jabatan->nama }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="row w-100">
    <div class="col-4 font-weight-bold">
        <p>Pemasukan</p>
    </div>
    <div class="col-8">
        <table class="table table-hover table-borderless">
            <colgroup>
                <col style="width: 40%;">  <col style="width: 5%;">   <col style="width: 55%;">
            </colgroup>
            @foreach ($kafalah as $row)
                @php
                    $amount = $data->kafalah[$row->nama] ?? null;
                @endphp
                <tr>
                    <td colspan="3">{{ $row->nama }}</td>
                    <td>:</td>
                    <td>{{ $amount ? 'Rp'.number_format($amount,0,',','.') : 'Rp0' }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<div class="row w-100">
    <div class="col-4 text-red font-weight-bold">
        <p>Potongan</p>
    </div>
    <div class="col-8">
        <table class="table table-hover table-borderless">
            <colgroup>
                <col style="width: 40%;">  <col style="width: 5%;">   <col style="width: 55%;">
            </colgroup>
            @foreach ($potongan as $row)
                @php
                    $amount = $data->potongan[$row->nama] ?? null;
                @endphp
                <tr>
                    <td class="text-red" colspan="3">{{ $row->nama }}</td>
                    <td>:</td>
                    <td>{{ $amount ? 'Rp'.number_format($amount,0,',','.') : 'Rp0' }}</td>
                </tr>
            @endforeach
            <tr class="font-weight-bold table-group-divider line-divider" >
                <td colspan="3">TOTAL</td>
                <td>:</td>
                <td>{{ $data->total_bersih ? 'Rp'.number_format($data->total_bersih,0,',','.') : 'Rp0' }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="d-flex align-items-end flex-column w-100" style="margin-top: 20px;">
    <div class="align-text-center mr-8">
        <table class="w-100">
            <tr>
                <td class="text-center">Pangkalpinang, {{ Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td class="text-center">Yang Mengetahui</td>
            </tr>
            <tr>
                <td class="d-flex justify-content-center" style="height: 60px;">
                    <img src="{{ asset('storage/signatures/ttd-dody.jpeg') }}" alt="{{ Auth::user()->name }}" style="max-height: 100%;">
                </td>
            </tr>
            <tr>
                <td class="text-center"><b>H.Dody Kusdian, S.T., M.H</b></td>
            </tr>
        </table>
    </div>
</div>
