<?php
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

$groupTransaksi = $transaksi->groupBy('jenis.id')->sort();
?>


@extends('app.master')

@section('css')
    <style>
        .transaksi-wrapper {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-column-gap: 16px;
        }

        .transaksi-btn {
            display: grid;
            justify-content: end;
        }

        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .bg-primary {
            background: linear-gradient(45deg, #4099ff, #73b4ff);
        }

        .bg-danger {
            background: linear-gradient(45deg, #FF5370, #ff869a);
        }

        .bg-info {
            background: linear-gradient(45deg, #2ed8b6, #59e0c5);
        }
    </style>
@endsection

@section('konten')
    <div class="content-body">
        <div class="container-fluid mt-3">
            <div class="row mb-3">
                <div class="col-lg-4 col-sm-12">
                </div>
                <div class="col-lg-4 col-sm-12">
                </div>
                <div class="col-lg-4 col-sm-12">
                    {{-- <a href="{{ route('dahboard-export') }}" class="btn btn-success ml-2 float-right">
                        EXPORT DASHBOARD
                    </a> --}}
                    <button type="button" class="btn btn-success ml-2 float-right" data-toggle="modal" data-target="#dashboardModal">
                        EXPORT DASHBOARD
                    </button>
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-plus"></i> &nbsp TAMBAH TRANSAKSI
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-7">
                        <div class="card-body">
                            <h3 class="card-title text-white">Pilih Durasi Tanggal</h3>
                            <form method="get" action="">
                                <select class="form-control" name="session" onchange="this.form.submit()">
                                    <option <?php if (isset($_GET['session'])) {
                                        if ($_GET['session'] == 'hari') {
                                            echo "selected='selected'";
                                        }
                                    } else {
                                        echo "selected='selected'";
                                    } ?> value="hari">Hari Ini</option>
                                    <option <?php if (isset($_GET['session'])) {
                                        if ($_GET['session'] == 'bulan') {
                                            echo "selected='selected'";
                                        }
                                    } ?> value="bulan">Bulan Ini</option>
                                    <option <?php if (isset($_GET['session'])) {
                                        if ($_GET['session'] == 'tahun') {
                                            echo "selected='selected'";
                                        }
                                    } ?> value="tahun">Tahun Ini</option>
                                    <option <?php if (isset($_GET['session'])) {
                                        if ($_GET['session'] == 'semua') {
                                            echo "selected='selected'";
                                        }
                                    } ?> value="semua">Semua</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
      if(isset($_GET['session'])){
        if($_GET['session'] == "hari"){
          ?>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-7">
                        <div class="card-body">
                            <h3 class="card-title text-white">Pemasukan Hari Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($pemasukan_hari_ini->total) . ' ,-' }}</h3>
                                <p class="text-white mb-0">{{ date('d-m-Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-8">
                        <div class="card-body">
                            <h3 class="card-title text-white">Saldo Hari Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">
                                    {{ 'Rp. ' . number_format($pemasukan_hari_ini->total - $pengeluaran_hari_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">Saldo</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
        }else if($_GET['session'] == "bulan"){
          ?>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-2">
                        <div class="card-body">
                            <h3 class="card-title text-white">Pemasukan Bulan Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($pemasukan_bulan_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">{{ date('M') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-8">
                        <div class="card-body">
                            <h3 class="card-title text-white">Saldo Bulan</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">
                                    {{ 'Rp. ' . number_format($pemasukan_bulan_ini->total - $pengeluaran_bulan_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">Saldo</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
        }else if($_GET['session'] == "tahun"){
          ?>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-3">
                        <div class="card-body">
                            <h3 class="card-title text-white">Pemasukan Tahun Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($pemasukan_tahun_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">{{ date('Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-8">
                        <div class="card-body">
                            <h3 class="card-title text-white">Saldo Tahun Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">
                                    {{ 'Rp. ' . number_format($pemasukan_tahun_ini->total - $pengeluaran_tahun_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">Saldo</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
        }else if($_GET['session'] == "semua"){
          ?>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-4">
                        <div class="card-body">
                            <h3 class="card-title text-white">Seluruh Pemasukan</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($seluruh_pemasukan->total) . ' ,-' }}</h3>
                                <p class="text-white mb-0">Semua</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-8">
                        <div class="card-body">
                            <h3 class="card-title text-white">Saldo Keseluruhan</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">
                                    {{ 'Rp. ' . number_format($seluruh_pemasukan->total - $seluruh_pengeluaran->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">Saldo</p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
        }
      }else{
        ?>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-7">
                        <div class="card-body">
                            <h3 class="card-title text-white">Pemasukan Hari Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($pemasukan_hari_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">{{ date('d-m-Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-8">
                        <div class="card-body">
                            <h3 class="card-title text-white">Saldo Hari Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">
                                    {{ 'Rp. ' . number_format($pemasukan_hari_ini->total - $pengeluaran_hari_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">Saldo</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
      }
      ?>
            </div>

            <div class="row">
                <div class="col-lg-4 col-sm-12">
                </div>
                <?php
      if(isset($_GET['session'])){
        if($_GET['session'] == "hari"){
          ?>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-1">
                        <div class="card-body">
                            <h3 class="card-title text-white">Pengeluaran Hari Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($pengeluaran_hari_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">{{ date('d-m-Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-2">
                        <div class="card-body">
                            <h3 class="card-title text-white">Bantuan Hari Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($bantuan_hari_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">{{ date('d-m-Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
        }else if($_GET['session'] == "bulan"){
          ?>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-9">
                        <div class="card-body">
                            <h3 class="card-title text-white">Pengeluaran Bulan Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($pengeluaran_bulan_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">{{ date('M') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-1">
                        <div class="card-body">
                            <h3 class="card-title text-white">Bantuan Bulan Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($bantuan_bulan_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">{{ date('M') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
        }else if($_GET['session'] == "tahun"){
          ?>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-6">
                        <div class="card-body">
                            <h3 class="card-title text-white">Pengeluaran Tahun Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($pengeluaran_tahun_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">{{ date('Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-7">
                        <div class="card-body">
                            <h3 class="card-title text-white">Bantuan Tahun Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($bantuan_tahun_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">{{ date('Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
        }else if($_GET['session'] == "semua"){
          ?>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-8">
                        <div class="card-body">
                            <h3 class="card-title text-white">Seluruh Pengeluaran</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($seluruh_pengeluaran->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">Semua</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-9">
                        <div class="card-body">
                            <h3 class="card-title text-white">Seluruh Bantuan</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($seluruh_bantuan->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">Semua</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
        }
      }else{
        ?>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-1">
                        <div class="card-body">
                            <h3 class="card-title text-white">Pengeluaran Hari Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($pengeluaran_hari_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">{{ date('d-m-Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card gradient-2">
                        <div class="card-body">
                            <h3 class="card-title text-white">Bantuan Hari Ini</h3>
                            <div class="d-inline-block">
                                <h3 class="text-white">{{ 'Rp. ' . number_format($bantuan_hari_ini->total) . ' ,-' }}
                                </h3>
                                <p class="text-white mb-0">{{ date('d-m-Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
      }
      ?>
            </div>
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-3">Saldo per Kategori</h2>
                    <div class="row" id="category-balance-container">
                        </div>
                </div>
            </div>

            <div class="row">
                <h2 class="col mb-3 font-weight-bold">KEUANGAN</h2>
            </div>
            <div id="transaction-container">
            </div>
            <div class="row">
                <!-- Tambah Transaksi -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('transaksi.aksi') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="home" value="1">
                                    <div id="transaksi-container">
                                        <div class="transaksi-item">
                                            <div class="transaksi-wrapper">
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="text" class="form-control datepicker2"
                                                        required="required" name="tanggal[]" autocomplete="off"
                                                        placeholder="Masukkan tanggal ..">
                                                </div>

                                                <div class="form-group">
                                                    <label>Jenis</label>
                                                    <select class="form-control jenis" required="required"
                                                        name="jenis[]">
                                                        <option value="">--- Pilih Jenis ---</option>
                                                        @foreach ($jenis as $item)
                                                            <option value="{{ $item->id }}">{{ $item->tipe }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Kategori</label>
                                                    <select class="form-control js-example-basic-single kategori"
                                                        required="required" name="kategori_id[]"
                                                        data-placeholder="--- Pilih Kategori ---">
                                                        <option></option>
                                                    </select>
                                                </div>

                                                <div class="form-group wrapper-kelas" id="kelas">
                                                    <label>Kelas</label>
                                                    <select class="form-control js-example-basic-single kelas"
                                                        name="kelas[]" data-placeholder="--- Pilih Kelas ---">
                                                        <option value=""></option>
                                                    </select>
                                                </div>

                                                <div class="form-group wrapper-siswa" id="siswa">
                                                    <label>Siswa</label>
                                                    <select class="form-control js-example-basic-single siswa"
                                                        name="id_siswa[]" data-placeholder="--- Pilih Siswa ---">
                                                        <option value=""></option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Nominal</label>
                                                    <input type="text" class="form-control nominal"
                                                        required="required" name="nominal[]" autocomplete="off"
                                                        placeholder="Masukkan nominal ..">
                                                    <small class="desc-anggaran font-italic"></small>
                                                </div>

                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <textarea class="form-control" name="keterangan[]" required placeholder="Masukkan keterangan .."></textarea>
                                                </div>
                                            </div>
                                            <div class="transaksi-btn">
                                                <button type="button" class="btn btn-danger remove-input">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>

                                    <button type="button" id="tambahInput" class="btn btn-success">
                                        <i class="fa fa-plus"></i> Tambah Transaksi Baru
                                    </button>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-paper-plane"></i> Simpan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="dashboardModal" tabindex="-1" role="dialog"
                    aria-labelledby="dashboardModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="dashboardModalLabel">Export Data Pemasukan dan Pengeluaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="{{ route('dahboard-export') }}" method="GET">
                            <div class="modal-body">

                                <div class="form-group w-100">
                                    <label>Bulan</label>
                                    <select class="form-control js-example-basic-single" required name="bulan">
                                        <option value="" selected disabled>--- Pilih Bulan ---</option>
                                        @php
                                            $currentMonth = date('n');
                                            $months = [
                                                1 => __('Januari'),
                                                2 => __('Februari'),
                                                3 => __('Maret'),
                                                4 => __('April'),
                                                5 => __('Mei'),
                                                6 => __('Juni'),
                                                7 => __('Juli'),
                                                8 => __('Agustus'),
                                                9 => __('September'),
                                                10 => __('Oktober'),
                                                11 => __('November'),
                                                12 => __('Desember')
                                            ];
                                        @endphp

                                        @foreach($months as $num => $name)
                                            <option value="{{ $num }}">
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group w-100">
                                    <label>Tahun</label>
                                    <select class="form-control js-example-basic-single" required="required" name="tahun">
                                        <option value="">--- Pilih Tahun ---</option>
                                        @foreach(range(date('Y') - 5, date('Y') + 5) as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-paper-plane"></i> Export
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <style type="text/css">
                    .card-grafik canvas {
                        width: 100% !important;
                        position: relative !important;
                        height: auto !important;
                    }
                </style>
                <section class="col-lg-6">
                    <div class="card card-grafik">
                        <div class="card-header pt-4">
                            <h5 class="card-title">Grafik Keuangan <b>Per Bulan</b> Di Tahun Ini</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="grafik1"></canvas>

                        </div>
                    </div>
                </section>
                <section class="col-lg-6">
                    <div class="card card-grafik">
                        <div class="card-header pt-4">
                            <h5 class="card-title">Grafik Keuangan <b>Per Tahun</b></h5>
                        </div>
                        <div class="card-body">
                            <canvas id="grafik2"></canvas>
                        </div>
                    </div>
                </section>
                <section class="col-lg-12">
                    <div class="card card-grafik">
                        <div class="card-header pt-4">
                            <h5 class="card-title">Grafik Keuangan <b>Per Hari</b> Di Bulan Ini</h5>
                        </div>
                        <div class="card-body">
                            <div style="overflow-x: scroll;">
                                <canvas id="grafik3"></canvas>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-12">
                    <div class="card card-grafik">
                        <div class="card-header pt-4">
                            <h5 class="card-title">Grafik Keuangan <b>Per Kategori</b> Bulan Ini</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="get" class="row">
                                <div class="col-lg-offset-2 col-lg-2">
                                    <div class="form-group">
                                        <label>Tipe</label>
                                        <select class="form-control" name="kategori" id="filter-jenis">
                                            <option value="">Semua</option>
                                            @foreach ($jenis as $item)
                                                <option value="{{ $item->id }}"
                                                    @isset($_GET['kategori'])
                                                  {{ $item->id == $_GET['kategori'] ? "selected='selected'" : '' }}
                                              @endisset>
                                                    {{ $item->tipe }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <canvas id="grafik4"></canvas>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var randomScalingFactor = function() {
            return Math.round(Math.random() * 100)
        };

        var barChartData = {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
                    label: 'Pemasukan',
                    fillColor: "rgba(51, 240, 113, 0.61)",
                    strokeColor: "rgba(11, 246, 88, 0.61)",
                    highlightFill: "rgba(220,220,220,0.75)",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: [
                        <?php
                        for ($bulan = 1; $bulan <= 12; $bulan++) {
                            $tahun = date('Y');
                            $pemasukan_perbulan = DB::table('transaksi')->select(DB::raw('SUM(nominal) as total'))->where('jenis', $pemasukan)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->first();
                            $total = $pemasukan_perbulan->total;
                            if ($pemasukan_perbulan->total == '') {
                                echo '0,';
                            } else {
                                echo $total . ',';
                            }
                        }
                        ?>
                    ]
                },
                {
                    label: 'Pengeluaran',
                    fillColor: "rgba(255, 51, 51, 0.8)",
                    strokeColor: "rgba(248, 5, 5, 0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: [
                        <?php
                        for ($bulan = 1; $bulan <= 12; $bulan++) {
                            $tahun = date('Y');
                            $pengeluaran_perbulan = DB::table('transaksi')->select(DB::raw('SUM(nominal) as total'))->where('jenis', $pengeluaran)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->first();
                            $total = $pengeluaran_perbulan->total;
                            if ($pengeluaran_perbulan->total == '') {
                                echo '0,';
                            } else {
                                echo $total . ',';
                            }
                        }
                        ?>
                    ]
                }
            ]

        }

        var barChartData2 = {
            labels: [
                <?php
            $thn2 = DB::table('transaksi')
            ->select(DB::raw('year(tanggal) as tahun'))
            ->distinct()
            ->orderBy('tahun','asc')
            ->get();
            foreach($thn2 as $t){
        ?> "<?php echo $t->tahun; ?>",
                <?php
  }
  ?>
            ],
            datasets: [{
                    label: 'Pemasukan',
                    fillColor: "rgba(51, 240, 113, 0.61)",
                    strokeColor: "rgba(11, 246, 88, 0.61)",
                    highlightFill: "rgba(220,220,220,0.75)",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: [
                        <?php
                        foreach ($thn2 as $t) {
                            $thn = $t->tahun;
                            $tahun = DB::table('transaksi')->select(DB::raw('SUM(nominal) as total'))->where('jenis', $pemasukan)->whereYear('tanggal', $thn)->first();
                            $total = $tahun->total;
                            if ($tahun->total == '') {
                                echo '0,';
                            } else {
                                echo $total . ',';
                            }
                        }
                        ?>
                    ]
                },
                {
                    label: 'Pengeluaran',
                    fillColor: "rgba(255, 51, 51, 0.8)",
                    strokeColor: "rgba(248, 5, 5, 0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(254, 29, 29, 0)",
                    data: [
                        <?php
                        foreach ($thn2 as $t) {
                            $thn = $t->tahun;
                            $tahun = DB::table('transaksi')->select(DB::raw('SUM(nominal) as total'))->where('jenis', $pengeluaran)->whereYear('tanggal', $thn)->first();
                            $total = $tahun->total;
                            if ($tahun->total == '') {
                                echo '0,';
                            } else {
                                echo $total . ',';
                            }
                        }
                        ?>
                    ]
                }
            ]

        }

        var barChartData3 = {
            <?php
            $dateBegin = strtotime('first day of this month');
            $dateEnd = strtotime('last day of this month');

            $awal = date('Y-m-d', $dateBegin);
            $akhir = date('Y-m-d', $dateEnd);
            ?>
            labels: [
                <?php
  for($a=$awal;$a<=$akhir;$a++){
    ?> "<?php echo date('d-m-Y', strtotime($a)); ?>",
                <?php
                }
            ?>
            ],
            datasets: [{
                label: 'Pemasukan',
                fillColor: "rgba(51, 240, 113, 0.61)",
                strokeColor: "rgba(11, 246, 88, 0.61)",
                highlightFill: "rgba(220,220,220,0.75)",
                highlightStroke: "rgba(220,220,220,1)",
                data: [
                    <?php
                    for ($a = $awal; $a <= $akhir; $a++) {
                        $tgl = $a;
                        $pemasukan_perhari = DB::table('transaksi')->select(DB::raw('SUM(nominal) as total'))->where('jenis', $pemasukan)->whereDate('tanggal', $tgl)->first();
                        $total = $pemasukan_perhari->total;
                        if ($pemasukan_perhari->total == '') {
                            echo '0,';
                        } else {
                            echo $total . ',';
                        }
                    }
                    ?>
                ]
            }, {
                label: 'Pengeluaran',
                fillColor: "rgba(255, 51, 51, 0.8)",
                strokeColor: "rgba(248, 5, 5, 0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(254, 29, 29, 0)",
                data: [
                    <?php
                    for ($a = $awal; $a <= $akhir; $a++) {
                        $tgl = $a;
                        $pemasukan_perhari = DB::table('transaksi')->select(DB::raw('SUM(nominal) as total'))->where('jenis', $pengeluaran)->whereDate('tanggal', $tgl)->first();
                        $total = $pemasukan_perhari->total;
                        if ($pemasukan_perhari->total == '') {
                            echo '0,';
                        } else {
                            echo $total . ',';
                        }
                    }
                    ?>
                ]
            }]
        }

        var barChartData4 = {
            labels: [
                @foreach ($kategori_filter as $k)
                    "{{ $k->kategori }}",
                @endforeach
            ],
            datasets: [{
                label: 'Pemasukan',
                fillColor: "rgba(51, 240, 113, 0.61)",
                strokeColor: "rgba(11, 246, 88, 0.61)",
                highlightFill: "rgba(220,220,220,0.75)",
                highlightStroke: "rgba(220,220,220,1)",
                data: [
                    @php
                        foreach ($kategori_filter as $k) {
                            $id_kategori = $k->id;
                            $pemasukan_perkategori = DB::table('transaksi')->select(DB::raw('SUM(nominal) as total'))->where('jenis', $pemasukan)->where('kategori_id', $id_kategori)->first();
                            $total = $pemasukan_perkategori->total;
                            if ($pemasukan_perkategori->total == '') {
                                echo '0,';
                            } else {
                                echo $total . ',';
                            }
                        }
                    @endphp
                ]
            }, {
                label: 'Pengeluaran',
                fillColor: "rgba(255, 51, 51, 0.8)",
                strokeColor: "rgba(248, 5, 5, 0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(254, 29, 29, 0)",
                data: [
                    @php
                        foreach ($kategori_filter as $k) {
                            $bln = date('m');
                            $id_kategori = $k->id;
                            $pemasukan_perkategori = DB::table('transaksi')->select(DB::raw('SUM(nominal) as total'))->where('jenis', $pengeluaran)->where('kategori_id', $id_kategori)->whereMonth('tanggal', $bln)->first();
                            $total = $pemasukan_perkategori->total;
                            if ($pemasukan_perkategori->total == '') {
                                echo '0,';
                            } else {
                                echo $total . ',';
                            }
                        }
                    @endphp
                ]
            }]
        }

        $(document).ready(() => {
            let $filterJenis = $('#filter-jenis');
            let ctx = document.getElementById("grafik4").getContext('2d');
            $.ajax({
                url: "{{ route('data-cateroty-month') }}",
                type: "GET",
                dataType: "json",
                success: data => {
                    let labels = data.pemasukan.map(item => item.kategori);
                    let dataPemasukan = data.pemasukan.map(item => item.total);
                    let dataPengeluaran = data.pengeluaran.map(item => item.total);

                    var barChartData4 = {
                        labels: labels,
                        datasets: [{
                            label: 'Pemasukan',
                            fillColor: "rgba(51, 240, 113, 0.61)",
                            strokeColor: "rgba(11, 246, 88, 0.61)",
                            highlightFill: "rgba(220,220,220,0.75)",
                            highlightStroke: "rgba(220,220,220,1)",
                            data: dataPemasukan
                        }, {
                            label: 'Pengeluaran',
                            fillColor: "rgba(255, 51, 51, 0.8)",
                            strokeColor: "rgba(248, 5, 5, 0.8)",
                            highlightFill: "rgba(151,187,205,0.75)",
                            highlightStroke: "rgba(254, 29, 29, 0)",
                            data: dataPengeluaran,
                        }]
                    }

                    window.myBar4 = new Chart(ctx).Bar(barChartData4, {
                        responsive: true,
                        animation: true,
                        barValueSpacing: 5,
                        barDatasetSpacing: 1,
                        tooltipFillColor: "rgba(0,0,0,0.8)",
                        multiTooltipTemplate: "<%= datasetLabel %> - Rp.<%= value.toLocaleString() %>,-"
                    });
                },
                error: () => {

                }
            })

            $filterJenis.change(() => {
                let path = "{{ route('data-cateroty-month') }}";
                if ($filterJenis.val() != "") {
                    path += "?tipe=" + $filterJenis.val();
                }
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType: "json",
                    success: data => {
                        myBar4.destroy();
                        let labels = data.pemasukan.map(item => item.kategori);
                        let dataPemasukan = data.pemasukan.map(item => item.total);
                        let dataPengeluaran = data.pengeluaran.map(item => item.total);

                        var barChartData4 = {
                            labels: labels,
                            datasets: [{
                                label: 'Pemasukan',
                                fillColor: "rgba(51, 240, 113, 0.61)",
                                strokeColor: "rgba(11, 246, 88, 0.61)",
                                highlightFill: "rgba(220,220,220,0.75)",
                                highlightStroke: "rgba(220,220,220,1)",
                                data: dataPemasukan
                            }, {
                                label: 'Pengeluaran',
                                fillColor: "rgba(255, 51, 51, 0.8)",
                                strokeColor: "rgba(248, 5, 5, 0.8)",
                                highlightFill: "rgba(151,187,205,0.75)",
                                highlightStroke: "rgba(254, 29, 29, 0)",
                                data: dataPengeluaran,
                            }]
                        }

                        window.myBar4 = new Chart(ctx).Bar(barChartData4, {
                            responsive: true,
                            animation: true,
                            barValueSpacing: 5,
                            barDatasetSpacing: 1,
                            tooltipFillColor: "rgba(0,0,0,0.8)",
                            multiTooltipTemplate: "<%= datasetLabel %> - Rp.<%= value.toLocaleString() %>,-"
                        });
                    },
                    error: () => {

                    }
                })
            });

            const $kategori = $("#kategori");
            const $jenisFilter = $("#filter-jenis");
            const $kategoriFilter = $("#kategori-filter");
            const kelas = $("#kelas");
            const siswa = $("#siswa");
            const kategoriData = @json($kategori);

            $('.wrapper-siswa').hide();
            $('#exampleModal').find('.wrapper-kelas').hide();

            kategoriData.forEach(data => {
                $kategori.append(new Option(data.kategori, data.id));
                $kategoriFilter.append(new Option(data.kategori, data.id));
            });

            $(document).on("change", ".jenis", function() {
                let parent = $(this).closest(".transaksi-item");
                let jenisVal = $(this).val();
                parent.find(".wrapper-kelas, .wrapper-siswa").hide();
                parent.find(".kategori").val("").change();
                parent.find(".kelas").empty().append(new Option('--- Pilih Kelas ---'));
                // parent.find(".siswa").empty().append(new Option('--- Pilih Siswa ---'));

                let kategoriFiltered = kategoriData.filter(item => item.id_tipe == jenisVal);
                parent.find(".kategori").empty().append(new Option('--- Pilih Kategori ---'));

                kategoriFiltered.forEach(item => {
                    parent.find(".kategori").append(new Option(item.kategori, item.id));
                });
            });


            $(document).on("change", ".kategori", function() {
                let parent = $(this).closest(".transaksi-item");
                let kategoriVal = $(this).val();

                parent.find(".wrapper-kelas, .wrapper-siswa").hide();
                parent.find(".kelas").empty().append(new Option('--- Pilih Kelas ---'));

                const found = kategoriData.find(item => item.id == kategoriVal);
                if (found && found.untuk_siswa === "Y") {
                    parent.find(".siswa").empty().append(new Option('--- Pilih Siswa ---'));
                    parent.find(".wrapper-kelas").show();

                    $.ajax({
                        url: "{{ route('kelas') }}",
                        type: "GET",
                        dataType: "json",
                        success: data => {
                            data.forEach(item => {
                                parent.find(".kelas").append(new Option(item.nama_kelas,
                                    item.id));
                            });
                        }
                    });
                    $.ajax({
                        url: "{{ route('kategori-anggaran') }}?id=" + kategoriVal,
                        type: "GET",
                        dataTyp: "json",
                        success: data => {
                            let bilangan = data.anggaran.toString();
                            let split = bilangan.split(',');
                            let sisa = split[0].length % 3;
                            let rupiah = split[0].substr(0, sisa);
                            let ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);
                            if (ribuan) rupiah += (sisa ? '.' : '') + ribuan.join('.');
                            $(".desc-anggaran").text("Maksimal nominal: Rp" + (split[1] !==
                                undefined ? rupiah + ',' + split[1] : rupiah));
                        }
                    })
                }
                $('.desc-anggaran').text('');
            });

            $(document).on("change", ".kelas", function() {
                let parent = $(this).closest(".transaksi-item");
                let kelasVal = $(this).val();

                parent.find(".wrapper-siswa").hide();
                parent.find(".siswa").empty().append(new Option('--- Pilih Siswa ---'));

                if (kelasVal) {
                    parent.find(".wrapper-siswa").show();

                    $.ajax({
                        url: "{{ route('siswa-kelas') }}?kelas=" + kelasVal,
                        type: "GET",
                        dataType: "json",
                        success: data => {
                            data.forEach(item => {
                                parent.find(".siswa").append(new Option(item
                                    .nama_lengkap, item.id));
                            });
                        }
                    });
                }
            });


            $(document).on("input", ".nominal", function(e) {
                let bilangan = e.target.value.replace(/[^,\d]/g, '').toString();
                let split = bilangan.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);
                if (ribuan) rupiah += (sisa ? '.' : '') + ribuan.join('.');
                $(this).val('Rp. ' + (split[1] !== undefined ? rupiah + ',' + split[1] : rupiah));
            });

            $("#tambahInput").click(function() {
                let newInput = $(".transaksi-item:first").clone();

                newInput.find("input, select, textarea").val("");
                // newInput.find(".datepicker2").removeClass("hasDatepicker").removeAttr("id");
                newInput.find(".select2").remove();
                newInput.find("select").removeClass("select2-hidden-accessible").removeAttr(
                    "data-select2-id").removeAttr("aria-hidden");

                newInput.find('.wrapper-kelas, .wrapper-siswa').hide();
                newInput.find('.kelas, .siswa').empty();

                // let uniqueId = "datepicker2-" + Date.now();
                // newInput.find(".datepicker2").attr("id", uniqueId);

                $("#transaksi-container").append(newInput);

                newInput.find(".js-example-basic-single").select2({
                    width: "100%",
                    placeholder: "--- Pilih Opsi ---",
                    allowClear: true,
                    dropdownParent: newInput
                });
                newInput.find(".datepicker2").datepicker({
                    // newInput.find("#" + uniqueId).datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });

            });

            $(document).on("change", ".datepicker2", function() {
                let parent = $(this).closest(".transaksi-item");
                parent.find(".js-example-basic-single").each(function() {
                    let $select = $(this);
                    $select.select2({
                        width: "100%",
                        placeholder: "--- Pilih Opsi ---",
                        allowClear: true,
                        dropdownParent: parent
                    });
                });
            });

            $(document).on("click", ".remove-input", function() {
                if ($("#transaksi-container").find(".transaksi-item").length > 1) $(this).closest(
                    ".transaksi-item").remove();
                else alert("Minimal harus ada satu transaksi!");
            });

            $('#exampleModal').on('show.bs.modal', function() {
                $(".js-example-basic-single").select2({
                    width: "100%",
                    placeholder: "--- Pilih Opsi ---",
                    allowClear: true,
                    dropdownParent: $(this)
                });
            })

            $('[id^=modalEdit_]').on('shown.bs.modal', function() {
                var modalId = $(this).attr('id');
                $("#" + modalId + " .js-example-basic-single, #" + modalId + " .kelas, #" + modalId +
                    " .siswa").select2({
                    width: "100%",
                    placeholder: "--- Pilih Opsi ---",
                    allowClear: true,
                    dropdownParent: $("#" + modalId)
                });
            });
            // $(".datepicker2").datepicker({
            //     format: 'yyyy-mm-dd',
            //     autoclose: true
            // });
            $(document).on("change", ".datepicker2", function() {
                let parent = $(this).closest(".transaksi-item");

                parent.find(".js-example-basic-single").each(function() {
                    let $select = $(this);
                    let select2Instance = $select.data('select2');

                    if (select2Instance) {
                        select2Instance.options.set('dropdownParent', parent);
                    } else {
                        $select.select2({
                            width: "100%",
                            placeholder: "--- Pilih Opsi ---",
                            allowClear: true,
                            dropdownParent: parent
                        });
                    }
                });
            });

            const transactions = @json($transaksi);

            const TIPE = {
                PEMASUKAN: {{ $pemasukan ?? 1 }},
                PENGELUARAN: {{ $pengeluaran ?? 2 }},
                BANTUAN: {{ $bantuan ?? 3 }}
            };

            // console.log(TIPE);
            console.log(transactions);

            // Group transactions by category
            const grouped = {};
            transactions.forEach(transaction => {
                if (!grouped[transaction.kategori]) {
                    grouped[transaction.kategori] = [];
                }
                grouped[transaction.kategori].push(transaction);
            });

            const pairedCategories = {};
            const singleCategories = {
                pemasukan: [],
                pengeluaran: [],
                bantuan: []
            };

            Object.keys(grouped).forEach(category => {
                const items = grouped[category];
                const hasIncome = items.some(item => item.id_tipe === TIPE.PEMASUKAN || item
                    .id_tipe === TIPE.BANTUAN);
                const hasExpense = items.some(item => item.id_tipe === TIPE.PENGELUARAN);

                if (hasIncome && hasExpense) {
                    pairedCategories[category] = items;
                } else {
                    items.forEach(item => {
                        if (item.id_tipe === TIPE.PEMASUKAN) {
                            singleCategories.pemasukan.push(item);
                        } else if (item.id_tipe === TIPE.BANTUAN) {
                            singleCategories.bantuan.push(item);
                        } else {
                            singleCategories.pengeluaran.push(item);
                        }
                    });
                }
            });

            // Render the data
            renderTransactions(pairedCategories, singleCategories);

            function renderTransactions(paired, single) {
                const $container = $('#transaction-container');
                $container.empty();

                if (Object.keys(paired).length > 0) {
                    // $container.append(`
                    //     <div class="row">
                    //         <div class="col-12">
                    //             <h3 class="mb-4">Kategori Ganda</h3>
                    //         </div>
                    //     </div>
                    // `);

                    Object.keys(paired).forEach(category => {
                        const items = paired[category];
                        const incomeItems = items.filter(item =>
                            item.id_tipe === TIPE.PEMASUKAN || item.id_tipe === TIPE.BANTUAN
                        );
                        const expenseItems = items.filter(item =>
                            item.id_tipe === TIPE.PENGELUARAN);

                        const categoryHtml = `
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            ${renderItems(incomeItems, 'Pemasukan', 'gradient-4')}
                                        </div>
                                        <div class="col-md-6">
                                            ${renderItems(expenseItems, 'Pengeluaran', 'gradient-2')}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        $container.append(categoryHtml);
                    });
                }

                // Render single categories
                $container.append(`
                    <div class="row">
                        <div class="col-md-6">
                            ${renderItems(single.pemasukan, 'Pemasukan', 'gradient-4')}
                            ${renderItems(single.bantuan, 'Pemasukan', 'gradient-7')}
                        </div>
                        <div class="col-md-6">
                            ${renderItems(single.pengeluaran, 'Pengeluaran', 'gradient-2')}
                        </div>
                    </div>
                `);
            }

            function renderItems(items, prefix = '', bgClass = '') {
                if (!items || items.length === 0) {
                    return '<div class="alert alert-secondary">Tidak ada data</div>';
                }

                return items.map(item => `
                    <div class="card ${bgClass} text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">${prefix} ${item.kategori}</h5>
                            <div class="d-inline-block">
                                <h3 class="mb-1">
                                    Rp${formatNumber(item.transaksi_sum_nominal || 0)},-
                                </h3>
                                <p class="mb-0 small">${new Date().toLocaleDateString('id-ID')}</p>
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            const categoryBalances = {};

            transactions.forEach(transaction => {
                const category = transaction.kategori;
                const nominal = parseInt(transaction.transaksi_sum_nominal);

                if (!categoryBalances[category]) {
                    categoryBalances[category] = 0;
                }

                if (transaction.id_tipe === TIPE.PEMASUKAN || transaction.id_tipe === TIPE.BANTUAN) {
                    categoryBalances[category] += nominal;
                } else if (transaction.id_tipe === TIPE.PENGELUARAN) {
                    categoryBalances[category] -= nominal;
                }
            });

            renderCategoryBalances(categoryBalances);

            function renderCategoryBalances(balances) {
                const $balanceContainer = $('#category-balance-container');
                $balanceContainer.empty();

                if (Object.keys(balances).length === 0) {
                    $balanceContainer.append('<div class="alert alert-info">Tidak ada data saldo per kategori.</div>');
                    return;
                }

                Object.keys(balances).forEach(category => {
                    const balance = balances[category];
                    const balanceClass = balance >= 0 ? 'bg-success' : 'bg-danger';

                    const categoryHtml = `
                        <div class="col-md-4">
                            <div class="card ${balanceClass} text-white">
                                <div class="card-body">
                                    <h5 class="card-title">${category}</h5>
                                    <h3 class="mb-0">Rp${formatNumber(balance)},-</h3>
                                </div>
                            </div>
                        </div>
                    `;
                    $balanceContainer.append(categoryHtml);
                });
            }

        });

        window.onload = function() {
            var ctx = document.getElementById("grafik1").getContext("2d");
            window.myBar = new Chart(ctx).Bar(barChartData, {
                responsive: true,
                animation: true,
                barValueSpacing: 5,
                barDatasetSpacing: 1,
                tooltipFillColor: "rgba(0,0,0,0.8)",
                multiTooltipTemplate: "<%= datasetLabel %> - Rp.<%= value.toLocaleString() %>,-"
            });

            var ctx = document.getElementById("grafik2").getContext("2d");
            window.myBar2 = new Chart(ctx).Bar(barChartData2, {
                responsive: true,
                animation: true,
                barValueSpacing: 5,
                barDatasetSpacing: 1,
                tooltipFillColor: "rgba(0,0,0,0.8)",
                multiTooltipTemplate: "<%= datasetLabel %> - Rp.<%= value.toLocaleString() %>,-"
            });

            var ctx = document.getElementById("grafik3").getContext("2d");
            window.myBar = new Chart(ctx).Bar(barChartData3, {
                responsive: true,
                animation: true,
                barValueSpacing: 5,
                barDatasetSpacing: 1,
                tooltipFillColor: "rgba(0,0,0,0.8)",
                multiTooltipTemplate: "<%= datasetLabel %> - Rp.<%= value.toLocaleString() %>,-"
            });

            // var ctx = document.getElementById("grafik4").getContext("2d");
            // window.myBar = new Chart(ctx).Bar(barChartData4, {
            //     responsive: true,
            //     animation: true,
            //     barValueSpacing: 5,
            //     barDatasetSpacing: 1,
            //     tooltipFillColor: "rgba(0,0,0,0.8)",
            //     multiTooltipTemplate: "<%= datasetLabel %> - Rp.<%= value.toLocaleString() %>,-"
            // });

        }
    </script>
@endsection
