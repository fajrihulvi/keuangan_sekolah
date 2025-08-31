@extends('app.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/kwentasi.css') }}">
@endsection

@section('konten')
    <div class="content-body">
        <div class="row page-titles mx-0 mt-2">
            <h3 class="col p-md-0">Kwitansi</h3>
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Kwitansi</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card">
                <div class="card-header pt-4">
                    <h3 class="card-tit">Filter Kwitansi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('kwetansi.index') }}" method="GET">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-lg-2">
                                <label>Kelas</label>
                                <select id="kelas-select" class="form-control">
                                    <option value="">--- Pilih Kelas ---</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label>Siswa</label>
                                <select name="siswa" id="siswa-select" class="form-control">
                                    <option value="">--- Pilih Siswa ---</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Bulan</label>
                                <select class="form-control" name="bulan" id="bulan">
                                    <option value="">Semua</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">
                                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Tahun</label>
                                <select class="form-control" name="tahun" id="tahun">
                                    <option value="">Semua</option>
                                    @foreach (range(date('Y'), date('Y') - 10) as $tahun)
                                        <option value="{{ $tahun }}">
                                            {{ $tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Tanggal (Opsional)</label>
                                <select class="form-control" name="tanggal" id="tanggal">
                                    <option value="">Semua</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Tampilkan"
                                        style="margin-top: 25px">
                                </div>
                            </div>
                        </div>
                        @if (request()->has(['siswa', 'bulan', 'tahun']))
                            <div class="row" style="gap: 8px; margin-bottom: 16px;">
                                <a target="_BLANK"
                                    href="{{ route('kwetansi.print', [
                                        'siswa' => request('siswa'),
                                        'bulan' => request('bulan'),
                                        'tahun' => request('tahun'),
                                    ]) }}"
                                    class="btn btn-outline-secondary col-md-2">
                                    <i class="fa fa-print"></i> &nbsp; CETAK PRINT
                                </a>
                            </div>
                        @endif
                    </form>

                </div>
            </div>
            @isset($data)
                <div class="my-2">
                    <div class="container">
                        <div class="row" style="gap: 8px; margin-bottom: 16px;">
                            {{-- <a target="_BLANK"
                            href="{{ route('kwetansi.pdf', ['siswa' => $_GET['siswa'], 'bulan' => $_GET['bulan'], 'tahun' => $_GET['tahun']]) }}"
                            class="btn btn-outline-secondary"><i class="fa fa-file-pdf-o "></i> &nbsp; CETAK PDF</a> --}}
                        </div>
                        <div class="kw-nav">
                            <img src="{{ asset('gambar/sistem/logo1.png') }}" alt="" class="img-fluid">
                            <div class="kw-header d-flex flex-column align-items-center ">
                                <h3><b>YAYASAN ADH-DHUHAA PANGKALPINANG</b></h3>
                                <h3><b>SEKOLAH DASAR ISLAM TERPADU QURANI ADH-DHUHAA</b></h3>
                                <p>Jl. Melati 1 No. 257 Ke. Taman Bunga Kec. Gerunggang Kota Pangkalpinang Provinsi Kep. Bangka
                                    Belitung</p>
                            </div>
                            <img src="{{ asset('gambar/sistem/logo-jsit-06.png') }}" alt="" class="img-fluid">
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
                                    <td>{{ $siswa->nisn && '' }}</td>
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
                                        $total += $item->nominal;
                                    @endphp
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d-m-Y') }}
                                        </td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td class="d-flex w-100 justify-content-between"
                                            style="border: none;outline-offset: 0;border-top: 1px solid black;">
                                            <p class="">Rp.</p>
                                            <p>{{ number_format($item->nominal) . ',-' }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- <div class="table-summary d-flex justify-content-between w-100">
                    335px padding
                    <p class="w-80">Terbilang</p>
                    <table class="table kw-table-bordered">
                        <tr>
                            <td>Total</td>
                            <td class="d-flex w-100 justify-content-between" style="border: none;outline-offset: 0;">
                                <p >Rp.</p>
                                <p>{{number_format($total).',-'}}</p>
                            </td>
                        </tr>
                    </table>
                </div> --}}

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
                                        <td class="d-flex w-100 justify-content-between"
                                            style="border: none;outline-offset: 0;">
                                            <p>Rp.</p>
                                            <p>{{ number_format($total) . ',-' }}</p>
                                        </td>
                                    </tr>
                                </table>
                                <div class="kw-ttd">
                                    <table class="w-100">
                                        <tr>
                                            <td class="text-center">Pangkalpinang, <span
                                                    class="py-3">{{ Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Yang Menerima</td>
                                        </tr>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ asset('storage/' . Auth::user()->signature) }}"
                                            alt="{{ Auth::user()->name }}" width="120">
                                    </div>
                                    {{-- <p class="text-center">Kessyie Arisani, S.Si</p> --}}
                                    <p class="text-center"><b>{{ Auth::user()->name }}</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </div>
@endsection

@section('script')
    <script>
        function terbilang(angka) {
            const satuan = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan"];

            const belasan = ["sepuluh", "sebelah", "dua belas", "tiga belas", "empat belas", "lima belas", "enam belas",
                "tujuh belas", "delapan belas", "sembilan belas"
            ];

            const puluhan = ["", "", "dua puluh", "tiga puluh", "empat puluh", "lima puluh", "enam puluh", "tujuh puluh",
                "delapan puluh", "sembilan puluh"
            ];

            const ribuan = ["", "ribu", "juta", "miliar", "triliun"];

            if (angka === 0) return "nol";

            function convertToWords(num) {
                if (num < 10) return satuan[num];
                if (num < 20) return belasan[num - 10];
                if (num < 100) return puluhan[Math.floor(num / 10)] + (num % 10 !== 0 ? " " + satuan[num % 10] : "");
                if (num < 1000) return (num < 200 ? "seratus" : satuan[Math.floor(num / 100)] + " ratus") + (num % 100 !==
                    0 ? " " + convertToWords(num % 100) : "");
                return "";
            }

            let result = "";
            let i = 0;

            while (angka > 0) {
                let chunk = angka % 1000;
                if (chunk !== 0) {
                    let chunkText = convertToWords(chunk) + (ribuan[i] ? " " + ribuan[i] : "");
                    result = chunkText + (result ? " " + result : "");
                }
                angka = Math.floor(angka / 1000);
                i++;
            }
            result += " rupiah"
            return result.trim();
        }
        $(document).ready(() => {
            let $kelas = $('#kelas-select');
            let $siswa = $('#siswa-select');
            let $terbilang = $('#text-terbilang');

            function updateDays() {
                let tahun = $("#tahun").val();
                let bulan = $("#bulan").val();
                let $tanggalSelect = $("#tanggal");

                $tanggalSelect.empty().append('<option value="">Semua</option>');

                if (tahun && bulan) {
                    let daysInMonth = new Date(tahun, bulan, 0).getDate();
                    for (let i = 1; i <= daysInMonth; i++) {
                        $tanggalSelect.append(`<option value="${i}">${i}</option>`);
                    }
                }
            }

            $("#bulan, #tahun").change(updateDays);

            @isset($data)
                let nominal = @json($total);
                let raw = terbilang(nominal);
                let textTerbilang = raw.charAt(0).toUpperCase() + raw.slice(1);
                console.log(nominal);
                $terbilang.text(textTerbilang);
            @endisset

            $kelas.change(() => {
                $.ajax({
                    url: "{{ route('siswa-kelas') }}?kelas=" + $kelas.val(),
                    type: "GET",
                    dataType: "json",
                    success: data => {
                        $siswa.empty();
                        $siswa.append($('<option>', {
                            text: '--- Pilih Siswa ---'
                        }));
                        data.forEach(item => {
                            $siswa.append(
                                `<option value="${item.id}">${item.nama_lengkap}</option>`
                            );
                        });
                    },
                })
            });

            $kelas.select2({
                width: '100%',
                placeholder: '--- Pilih Kelas ---',
                allowClear: true,
                // dropdownParent: $('#exampleModal')
            }).addClass("form-control");

            $siswa.select2({
                width: '100%',
                placeholder: '--- Pilih Siswa ---',
                allowClear: true,
                // dropdownParent: $('#exampleModal')
            }).addClass("form-control");

            $('#tahun').select2({
                width: '100%',
                placeholder: '--- Pilih Tahun ---',
                allowClear: true,
                // dropdownParent: $('#exampleModal')
            }).addClass("form-control");

            $('#bulan').select2({
                width: '100%',
                placeholder: '--- Pilih Bulan ---',
                allowClear: true,
                // dropdownParent: $('#exampleModal')
            }).addClass("form-control");

            $('#tanggal').select2({
                width: '100%',
                placeholder: '--- Pilih Tanggal ---',
                allowClear: true,
                // dropdownParent: $('#exampleModal')
            }).addClass("form-control");

        })
    </script>
@endsection
