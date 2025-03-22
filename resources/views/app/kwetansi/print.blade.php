<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('gambar/sistem/pavicon.png')}}">
    <link href="{{ asset('asset_admin/plugins/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset_admin/plugins/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_admin/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">
    <link href="{{ asset('asset_admin/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/kwentasi.css')}}">
</head>
<body>

    <div class="my-2">
        <div class="container">
            <div class="kw-nav">
                <img src="{{asset('gambar/sistem/logo1.png')}}" alt="" class="img-fluid">
                <div class="kw-header d-flex flex-column align-items-center " >
                    <h3><b>YAYASAN ADH-DHUHAA PANGKALPINANG</b></h3>
                    <h3><b>SEKOLAH DASAR ISLAM TERPADU QURANI ADH-DHUHAA</b></h3>
                    <p>Jl. Melati 1 No. 257 Ke. Taman Bunga Kec. Gerunggang Kota Pangkalpinang Provinsi Kep. Bangka Belitung</p>
                </div>
                <img src="{{asset('gambar/sistem/logo-jsit-06.png')}}" alt="" class="img-fluid">
            </div>

            <h3 class="kw-title"><b>BUKTI PEMBAYARAN SISWA</b></h3>
            <div class="d-flex justify-content-between w-100 my-4 px-5">
                <table class="w-full">
                    <tr>
                        <td >Nama Siswa</td>
                        <td class="px-3">:</td>
                        <td>{{$siswa->nama_lengkap}}</td>
                    </tr>
                    <tr>
                        <td>NISN</td>
                        <td class="px-3">:</td>
                        <td>{{$siswa->nisn && ''}}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>Kelas</td>
                        <td class="px-3">:</td>
                        <td>{{$siswa->kelas->nama_kelas}}</td>
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
                        <th>Tanggal</th>
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
                        $total +=$item->nominal;
                    @endphp
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d-m-Y') }}
                        </td>
                        <td>{{$item->keterangan}}</td>
                        <td class="d-flex w-100 justify-content-between" style="border: none;outline-offset: 0;border-top: 1px solid black;">
                            <p class="">Rp.</p>
                            <p>{{number_format($item->nominal).',-'}}</p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="kw-total">
                <div class="kw-height-terbilang w-100">
                    <div>
                        <p class="terbilang">Terbilang :</p>
                        <p id="text-terbilang">-</p>
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
                            <td class="d-flex w-100 justify-content-between" style="border: none;outline-offset: 0;">
                                <p >Rp.</p>
                                <p>{{number_format($total).',-'}}</p>
                            </td>
                        </tr>
                    </table>
                    <div class="kw-ttd">
                        <table class="w-100">
                            <tr>
                                <td class="text-center">Pangkalpinang, <span class="py-3">{{Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y')}}</span></td>
                            </tr>
                            <tr>
                                <td class="text-center">Yang Menerima</td>
                            </tr>
                        </table>
                        {{-- <p class="text-center">Kessyie Arisani, S.Si</p> --}}
                        <p class="text-center">{{Auth::user()->name}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="{{ asset('asset_admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/common/common.min.js') }}"></script>
<script src="{{ asset('asset_admin/js/custom.min.js') }}"></script>
<script src="{{ asset('asset_admin/js/settings.js') }}"></script>
<script src="{{ asset('asset_admin/js/gleek.js') }}"></script>
<script src="{{ asset('asset_admin/js/styleSwitcher.js') }}"></script>

<script src="{{ asset('asset_admin/plugins/circle-progress/circle-progress.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/d3v3/index.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/topojson/topojson.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('asset_admin/plugins/pg-calendar/js/pignose.calendar.min.js') }}"></script>
<!-- <script src="{{ asset('asset_admin/plugins/chartist/js/chartist.min.js') }}"></script> -->
<!-- <script src="{{ asset('asset_admin/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') }}"></script> -->

<script src="{{ asset('asset_admin/js/dashboard/dashboard-1.js') }}"></script>

<script>
    function terbilang(angka){
        const satuan = ["","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan"];

        const belasan = ["sepuluh","sebelah","dua belas","tiga belas","empat belas","lima belas","enam belas","tujuh belas","delapan belas","sembilan belas"];

        const puluhan = ["","","dua puluh","tiga puluh","empat puluh","lima puluh","enam puluh","tujuh puluh","delapan puluh","sembilan puluh"];

        const ribuan = ["","ribu","juta","miliar","triliun"];

        if(angka === 0) return "nol";

        function convertToWords(num){
            if(num < 10) return satuan[num];
            if(num < 20) return belasan[num - 10];
            if(num < 100) return puluhan[Math.floor(num/10)] + (num % 10 !== 0 ? " " + satuan[num%10] : "");
            if(num < 1000) return (num < 200 ? "seratus" : satuan[Math.floor(num/100)] +" ratus") + (num % 100 !== 0 ? " " + convertToWords(num%100) : "");
            return "";
        }

        let result = "";
        let i = 0;

        while(angka > 0){
            let chunk = angka %1000;
            if(chunk !== 0){
                let chunkText = convertToWords(chunk) + (ribuan[i] ? " " +ribuan[i] : "");
                result = chunkText + (result ? " " + result : "");
            }
            angka = Math.floor(angka/1000);
            i++;
        }
        result += " rupiah"
        return result.trim();
    }
    $(document).ready(() => {
        let $terbilang = $('#text-terbilang');
        let nominal = @json($total);
        let raw = terbilang(nominal);
        let textTerbilang = raw.charAt(0).toUpperCase() + raw.slice(1);
        console.log(nominal);
        $terbilang.text(textTerbilang);

        window.print();
    })
</script>
</body>
</html>
