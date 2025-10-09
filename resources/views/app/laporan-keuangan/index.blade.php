@php
    use Illuminate\Support\Carbon;
    Carbon::setLocale('id');
@endphp
{{-- @dd($kategori,$siswa,$transaksi,$grandTotal) --}}
@extends('app.master')

@section('css')
    <style>
        /* tbody > tr {
            color: black; */
        /* } */
    </style>
@endsection

@section('konten')
<div class="content-body">
    <div class="row page-titles mx-0 mt-2">
        <h3 class="col p-md-0">Keuangan Perkelas</h3>
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Keuangan Perkelas</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header pt-4">
                <h3 class="card-tit">Filter</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('laporan-kelas.index') }}" method="GET">
                    <div class="row">
                        <div class="col-2">
                            <label>Kelas</label>
                            <select id="kelas" class="form-control" required name="kelas">
                                <option value="">--- Pilih Kelas ---</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <label>Bulan</label>
                            <select class="form-control" name="bulan" id="bulan" required>
                                <option value="">--- Pilih Bulan ---</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">
                                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-2">
                            <x-forms.input label="Tahun" name="tahun" :value="Date('Y')"  />
                        </div>
                        {{-- <div class="col-md-2">
                            <label>Tahun</label>
                            <select class="form-control" name="tahun" id="tahun" required>
                                <option value="">--- Pilih Tahun ---</option>
                                @foreach (range(date('Y'), date('Y') - 10) as $tahun)
                                    <option value="{{ $tahun }}">
                                        {{ $tahun }}
                                    </option>
                                @endforeach
                            </select> --}}
                            <div class="col-2">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Tampilkan"
                                        style="margin-top: 25px">
                                </div>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if ($grandTotal != [])
        <div class="m-2">
            <div class="card">
                {{-- <a class="btn btn-primary" href="#">hello</button> --}}
                    <div class="card-head d-flex justify-content-end pt-3 container">
                        <a class="btn btn-success font-weight-bold text-white" href="{{route('laporan-kelas.export')."?kelas=".$_GET['kelas']."&tahun=".$_GET['tahun']."&bulan=".$_GET['bulan']}}" >Export</a>
                </div>
                <div class="card-body container">
                    @include('app.exports.laporan-keuangan')
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(()=>{
            $('#kelas,#bulan,#tahun').select2({
                width: '100%',
                placeholder: '--- Pilih ---',
                allowClear: true,
            });
        });
    </script>
@endsection
