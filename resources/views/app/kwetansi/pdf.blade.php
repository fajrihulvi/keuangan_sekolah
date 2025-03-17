<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ public_path('gambar/sistem/pavicon.png') }}">
    <link href="{{ public_path('asset_admin/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ public_path('css/kwentasi.css') }}">
</head>
<body>

<div class="my-2">
    <div class="container">
        <div class="kw-nav">
            <img src="{{ public_path('gambar/sistem/logo1.png') }}" class="img-fluid">
            <div class="kw-header d-flex flex-column align-items-center">
                <h3><b>YAYASAN ADH-DHUHAA PANGKALPINANG</b></h3>
                <h3><b>SEKOLAH DASAR ISLAM TERPADU QURANI ADH-DHUHAA</b></h3>
                <p>Jl. Melati 1 No. 257 Ke. Taman Bunga Kec. Gerunggang Kota Pangkalpinang Provinsi Kep. Bangka Belitung</p>
            </div>
            <img src="{{ public_path('gambar/sistem/logo-jsit-06.png') }}" alt="Logo JSIT" class="img-fluid">
        </div>

        <h3 class="kw-title"><b>BUKTI PEMBAYARAN SISWA</b></h3>

        <div class="d-flex justify-content-between w-100 my-4 px-5">
            <table class="w-full">
                <tr>
                    <td>Nama Siswa</td>
                    <td class="px-3">:</td>
                    <td>{{ $siswa->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td>NISN</td>
                    <td class="px-3">:</td>
                    <td>{{ $siswa->nisn ?? '-' }}</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>Kelas</td>
                    <td class="px-3">:</td>
                    <td>{{ $siswa->kelas->nama_kelas }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td class="px-3">:</td>
                    <td>{{ date('d/m/Y') }}</td>
                </tr>
            </table>
        </div>

        <table class="table kw-table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Keterangan Pembayaran</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $total = 0;
                @endphp
                @foreach ($data as $item)
                    @php
                        $total += $item->nominal;
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td class="d-flex w-100 justify-content-between" style="border: none; border-top: 1px solid black;">
                            <p>Rp.</p>
                            <p>{{ number_format($item->nominal, 0, ',', '.') }},-</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="kw-total">
            <div class="kw-height-terbilang w-100">
                <div>
                    <p class="terbilang">Terbilang :</p>
                    <p id="text-terbilang">{{ $terbilang }}</p>
                </div>
                <div class="kw-catatan">
                    <p class="font-italic">Catatan :</p>
                    <p>- Disimpan sebagai bukti pembayaran SAH</p>
                </div>
            </div>
            <div class="kw-height">
                <table class="table kw-table-bordered">
                    <tr>
                        <td class="kw-text-bold">Total</td>
                        <td class="d-flex w-100 justify-content-between" style="border: none;">
                            <p>Rp.</p>
                            <p>{{ number_format($total, 0, ',', '.') }}</p>
                        </td>
                    </tr>
                </table>
                <div class="kw-ttd">
                    <table class="w-100">
                        <tr>
                            <td class="text-center">Pangkalpinang, <span class="py-3">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-center">Yang Menerima</td>
                        </tr>
                    </table>
                    <p class="text-center"><b>Kessyie Arisani, S.Si</b></p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
