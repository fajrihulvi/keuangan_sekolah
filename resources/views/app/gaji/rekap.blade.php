@php
use Illuminate\Support\Carbon;
Carbon::setLocale('id');
@endphp
@extends('app.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/kwentasi.css') }}">
    <style>
        .line-divider {
            border-top: 2px solid #7d7e7f;
        }
    </style>
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
                    <h3 class="card-tit">Filter</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('gaji.cetak') }}" method="GET">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-lg-2">
                                <label>Pegawai</label>
                                <select id="pegawai-select" class="form-control" name="pegawai">
                                    <option value="">--- Pilih Pegawai ---</option>
                                    @foreach ($pegawai as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
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
                                <x-forms.input type="number" label="tahun" name="tahun" :value="Date('Y')" />
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Tampilkan"
                                        style="margin-top: 25px">
                                </div>
                            </div>
                        </div>
                        @isset($data)

                        <div class="row" style="gap: 8px; margin-bottom: 16px;">
                            <a target="_BLANK"
                                href="{{ route('gaji.print', [
                                    'pegawai' => request('pegawai'),
                                    'id' => $data->id,
                                    'bulan' => request('bulan'),
                                    'tahun' => request('tahun'),
                                ]) }}"
                                class="btn btn-outline-secondary col-md-2">
                                <i class="fa fa-print"></i> &nbsp; CETAK PRINT
                            </a>
                        </div>
                        @endisset
                    </form>

                </div>
            </div>
            @isset($data)
                <div class="container">
                    @include('app.gaji.print')
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
            let $pegawai = $('#pegawai-select');
            $pegawai.select2({
                width: '100%',
                placeholder: '--- Pilih Pegawai ---',
                allowClear: true,
                // dropdownParent: $('#exampleModal')
            }).addClass("form-control");

            $('#bulan').select2({
                width: '100%',
                placeholder: '--- Pilih Bulan ---',
                allowClear: true,
                // dropdownParent: $('#exampleModal')
            }).addClass("form-control");
        })
    </script>
@endsection
