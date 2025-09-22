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
                    <form action="{{ route('laporan-gaji') }}" method="GET">
                        <div class="row">
                            <div class="col-md-2">
                                <label>Bulan</label>
                                <select class="form-control" name="bulan" id="bulan">
                                    <option value="">Semua</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" @selected($i == (int) date('m'))>
                                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <x-forms.input type="number" label="tahun" name="tahun" :value="Date('Y')" />
                            </div>
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
        @isset($data)
            <div class="m-2">
                <div class="card">
                    <div class="card-head d-flex justify-content-end pt-3 container">
                    </div>
                    <div class="card-body container-fluid">
                        <table style="width: 40%" class="mb-4 font-weight-bold">
                            <tr>
                                <td width="30%">BULAN</td>
                                <td width="5%" class="text-center">:</td>
                                <td>{{ Carbon::createFromDate(null, $_GET['bulan'], null)->getTranslatedMonthName() }}</td>
                            </tr>
                            <tr>
                                <td width="30%">TAHUN</td>
                                <td width="5%" class="text-center">:</td>
                                <td>{{ $_GET['tahun'] }}</td>
                            </tr>
                        </table>

                        <a class="btn btn-outline-secondary font-weight-bold mb-4"
                        href="{{ route('laporan-gaji.export',[
                            'bulan' => $_GET['bulan'],
                            'tahun' => $_GET['tahun'],
                        ])}}"><i class="icon-notebook menu-icon mr-2"></i>Export</a>
                        <div class="table-responsive">
                            @include('app.exports.template-gaji')
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
        $(document).ready(() => {
            $('#bulan').select2({
                width: '100%',
                placeholder: '--- Pilih ---',
                allowClear: true,
                theme: 'bootstrap4'
            });
        });
    </script>
@endsection
