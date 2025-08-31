<?php
use Carbon\Carbon;
Carbon::setLocale('id');
?>

@extends('app.master')

@section('css')
    <style>
        .select2 .select2-container .select2-container--default .select2-container--below {
            display: block;
            width: 100%;
            height: calc(2.0625rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out
        }

        .gaji-btn {
            display: grid;
            justify-content: end;
        }
    </style>
@endsection

@section('konten')
    <div class="content-body">
        <div class="row page-titles mx-0 mt-2">
            <h3 class="col p-md-0">Gaji</h3>
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Gaji</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">

            <div class="card">
                <div class="card-header pt-4">
                    @if (Auth::user()->level != 'pengawas')
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#exampleModal">
                            <i class="fa fa-plus"></i> &nbsp TAMBAH GAJI
                        </button>
                        <h4>Data Gaji</h4>
                    @endif
                </div>
                <div class="card-body pt-0">
                    <!-- Tambah Gaji -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Gaji</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form action="{{ route('gaji.store') }}" method="post">
                                        @csrf
                                        <div id="gaji-container">
                                            <div class="gaji-item">
                                                <div class="gaji-wrapper">
                                                    <div class="form-group">
                                                        <label>Pegawai</label>
                                                        <select class="form-control js-example-basic-single"
                                                            required="required" name="pegawai" id="pegawai-select">
                                                            <option value="">--- Pilih Pegawai ---</option>
                                                            @foreach ($pegawai as $item)
                                                                <option value="{{ $item->id }}">{{ $item->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Pemasukkan</p>
                                                            <div id="kafalah-container">
                                                                {{-- ADD COLUMN TUNJANGAN JABATAN --}}
                                                                <div
                                                                    class="d-flex kafalah-row align-item-center mb-2 justify-content-between">
                                                                    <div class="form-group flex-grow-1 mb-0">
                                                                        <select class="form-control" required="required"
                                                                            disabled id="jabatan-select">
                                                                            <option value="">Jabatan
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group flex-grow-1 mx-2 mb-0">
                                                                        <input placeholder="Masukan nominal..."
                                                                            class="form-control nominal" disabled
                                                                            id="jabatan-nominal" autocomplete="off">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="tambah-kafalah btn btn-success">+</button>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <p>Potongan</p>
                                                            <div id="potongan-container">
                                                                <div
                                                                    class="d-flex potongan-row align-item-center mb-2 justify-content-between">
                                                                    <div class="form-group flex-grow-1 mb-0">
                                                                        <select class="form-control" required="required"
                                                                            name="potongan[]">
                                                                            <option value="">--- Pilih Potongan ---
                                                                            </option>
                                                                            @foreach ($potongan as $item)
                                                                                <option value="{{ $item->id }}">
                                                                                    {{ $item->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group flex-grow-1 mx-2 mb-0">
                                                                        <input placeholder="Masukan nominal..."
                                                                            class="form-control nominal"
                                                                            name="potongan-nominal[]" autocomplete="off">
                                                                    </div>
                                                                    <button type="button"
                                                                        class="tambah-potongan btn btn-success">+</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-between gap-3">
                                                        <div class="form-group w-100 pr-1">
                                                            <label>Bulan</label>
                                                            <select class="form-control js-example-basic-single" required
                                                                name="bulan">
                                                                <option value="" selected disabled>--- Pilih Bulan ---
                                                                </option>
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
                                                                        12 => __('Desember'),
                                                                    ];
                                                                @endphp

                                                                @foreach ($months as $num => $name)
                                                                    <option value="{{ $num }}"
                                                                        @selected(Carbon::now()->month == $num)>
                                                                        {{ $name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <x-forms.input class="w-100" type="number" :value="date('Y')"
                                                            label="Tahun" name="tahun" />
                                                    </div>

                                                </div>
                                                <hr>
                                            </div>
                                        </div>

                                        {{-- <button type="button" id="tambahInput" class="btn btn-success">
                                            <i class="fa fa-plus"></i> Tambah Gaji Baru
                                        </button> --}}

                                        <button type="submit" class="btn btn-success"
                                            onclick="this.disabled=true;this.innerHTML = '<i class=\'fa fa-spinner fa-spin\'></i> Menambahkan...';this.form.submit();">
                                            <i class="fa fa-paper-plane"></i> Tambah
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table-datatable" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="text-center" width="1%">NO</th>
                                    <th class="text-center" width="11%">NAMA</th>
                                    <th class="text-center">JABATAN</th>
                                    <th class="text-center">BULAN</th>
                                    <th class="text-center">TAHUN</th>
                                    <th class="text-center">TOTAL PEMASUKAN</th>
                                    <th class="text-center">TOTAL POTONGAN</th>
                                    <th class="text-center">TOTAL BERSIH</th>
                                    @if (Auth::user()->level != 'pengawas')
                                        <th class="text-center" width="10%">OPSI</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $currentMonth = date('n');
                                    $months = [
                                        '1' => __('Januari'),
                                        '2' => __('Februari'),
                                        '3' => __('Maret'),
                                        '4' => __('April'),
                                        '5' => __('Mei'),
                                        '6' => __('Juni'),
                                        '7' => __('Juli'),
                                        '8' => __('Agustus'),
                                        '9' => __('September'),
                                        '10' => __('Oktober'),
                                        '11' => __('November'),
                                        '12' => __('Desember'),
                                    ];
                                @endphp
                                @foreach ($data as $t)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $t->pegawai->nama }}</td>
                                        <td class="text-center">{{ $t->pegawai->jabatan->nama }}</td>
                                        <td class="text-center">{{ Carbon::parse()->month($t->bulan)->translatedFormat('F') }}</td>
                                        <td class="text-center">{{ $t->tahun }}</td>
                                        <td class="text-center">
                                            {{ 'Rp' . number_format($t->total_pemasukan, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            {{ 'Rp' . number_format($t->total_potongan, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">{{ 'Rp' . number_format($t->total_bersih, 0, ',', '.') }}
                                        </td>
                                        @if (Auth::user()->level != 'pengawas')
                                            <td>
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-default btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modalEdit_{{ $t->id }}"><i
                                                            class="fa fa-cog"></i></button>
                                                    <a href="{{ route('gaji.show', ['gaji' => $t->id]) }}"
                                                        class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modalDelete_{{ $t->id }}"><i
                                                            class="fa fa-trash"></i></button>
                                                </div>
                                                <!-- Modal -->
                                                <form method="POST"
                                                    action="{{ route('gaji.destroy', ['gaji' => $t->id]) }}">
                                                    <div class="modal fade" id="modalDelete_{{ $t->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Peringatan</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">


                                                                    @csrf
                                                                    {{ method_field('DELETE') }}
                                                                    <p>Apakah anda yakin ingin menghapus data ini?</p>

                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal"><i
                                                                            class="ti-close m-r-5 f-s-12"></i>
                                                                        Tutup</button>
                                                                    <button type="submit" class="btn btn-primary"><i
                                                                            class="fa fa-paper-plane m-r-5"></i>
                                                                        Hapus</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form action="{{ route('gaji.update', $t->id) }}" method="post">
                                                    <div class="modal fade" id="modalEdit_{{ $t->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalEdit_{{ $t->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="exampleModalEdit_{{ $t->id }}">Edit
                                                                        Data
                                                                        Gaji</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="pegawai_{{ $t->id }}">Pegawai</label>
                                                                        <select
                                                                            class="form-control js-example-basic-single"
                                                                            id="pegawai_{{ $t->id }}"
                                                                            required="required" name="pegawai">
                                                                            <option value="">--- Pilih Pegawai ---
                                                                            </option>
                                                                            @foreach ($pegawai as $item)
                                                                                <option value="{{ $item->id }}"
                                                                                    @selected($t->id_pegawai == $item->id)>
                                                                                    {{ $item->nama }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="row my-2">
                                                                        <div class="col">
                                                                            <div
                                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                                <p>Pemasukan</p>
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-success tambah-pemasukan-btn"
                                                                                    id="">
                                                                                    <i class="fa fa-plus"></i> Tambah
                                                                                </button>
                                                                            </div>

                                                                            <div class="edit-pemasukan-container">
                                                                                @if ($t->kafalah && count((array) $t->kafalah) > 0)
                                                                                    @foreach ($t->kafalah as $nama_pemasukan => $nominal)
                                                                                        @if ($nama_pemasukan != 'Tunjangan Jabatan')
                                                                                            <div class="input-group mb-2">
                                                                                                <select
                                                                                                    class="form-control"
                                                                                                    name="pemasukan[]">
                                                                                                    <option value="">
                                                                                                        --
                                                                                                        Pilih Opsi --
                                                                                                    </option>
                                                                                                    @foreach ($kafalah as $item)
                                                                                                        <option
                                                                                                            value="{{ $item->id }}"
                                                                                                            @selected($item->nama == $nama_pemasukan)>
                                                                                                            {{ $item->nama }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                                <input type="text"
                                                                                                    class="form-control nominal"
                                                                                                    name="pemasukan_nominal[]"
                                                                                                    placeholder="Masukkan nominal..."
                                                                                                    value="{{ $nominal }}"
                                                                                                    autocomplete="off">
                                                                                                <div
                                                                                                    class="input-group-append">
                                                                                                    <button type="button"
                                                                                                        class="btn btn-danger hapus-baris-btn">-</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        @else
                                                                                            <div class="input-group mb-2">
                                                                                                <select
                                                                                                    class="form-control" disabled>
                                                                                                    <option>{{ $t->pegawai->jabatan->nama }}
                                                                                                    </option>
                                                                                                </select>
                                                                                                <input type="text"
                                                                                                    class="form-control nominal" disabled
                                                                                                    placeholder="Masukkan nominal..."
                                                                                                    value="{{ $nominal }}"
                                                                                                    autocomplete="off">
                                                                                                <div
                                                                                                    class="input-group-append">
                                                                                                    <button type="button"
                                                                                                        class="btn btn-danger hapus-baris-btn">-</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @else
                                                                                    <div class="input-group mb-2">
                                                                                        <select class="form-control"
                                                                                            name="pemasukan[]">
                                                                                            <option value="">-- Pilih
                                                                                                Opsi --</option>
                                                                                            @foreach ($kafalah as $item)
                                                                                                <option
                                                                                                    value="{{ $item->id }}">
                                                                                                    {{ $item->nama }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        <input type="text"
                                                                                            class="form-control nominal"
                                                                                            name="pemasukan_nominal[]"
                                                                                            placeholder="Masukkan nominal..."
                                                                                            autocomplete="off">
                                                                                        <div class="input-group-append">
                                                                                            <button type="button"
                                                                                                class="btn btn-danger hapus-baris-btn">-</button>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>

                                                                        <div class="col">
                                                                            <div
                                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                                <p>Potongan</p>
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-success tambah-potongan-btn"
                                                                                    id="">
                                                                                    <i class="fa fa-plus"></i> Tambah
                                                                                </button>
                                                                            </div>
                                                                            <div class="edit-potongan-container">
                                                                                @if ($t->potongan && count((array) $t->potongan) > 0)
                                                                                    @foreach ($t->potongan as $nama_potongan => $nominal)
                                                                                        <div class="input-group mb-2">
                                                                                            <select class="form-control"
                                                                                                name="potongan[]">
                                                                                                <option value="">--
                                                                                                    Pilih Opsi --</option>
                                                                                                @foreach ($potongan as $item)
                                                                                                    <option
                                                                                                        value="{{ $item->id }}"
                                                                                                        @selected($item->nama == $nama_potongan)>
                                                                                                        {{ $item->nama }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                            <input type="text"
                                                                                                class="form-control nominal"
                                                                                                name="potongan_nominal[]"
                                                                                                placeholder="Masukkan nominal..."
                                                                                                value="{{ $nominal }}"
                                                                                                autocomplete="off">
                                                                                            <div
                                                                                                class="input-group-append">
                                                                                                <button type="button"
                                                                                                    class="btn btn-danger hapus-baris-btn">-</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                @else
                                                                                    <div class="input-group mb-2">
                                                                                        <select class="form-control"
                                                                                            name="potongan[]">
                                                                                            <option value="">-- Pilih
                                                                                                Opsi --</option>
                                                                                            @foreach ($potongan as $item)
                                                                                                <option
                                                                                                    value="{{ $item->id }}">
                                                                                                    {{ $item->nama }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        <input type="text"
                                                                                            class="form-control nominal"
                                                                                            name="potongan_nominal[]"
                                                                                            placeholder="Masukkan nominal..."
                                                                                            autocomplete="off">
                                                                                        <div class="input-group-append">
                                                                                            <button type="button"
                                                                                                class="btn btn-danger hapus-baris-btn">-</button>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <hr>

                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="bulan_{{ $t->id }}">Bulan</label>
                                                                                <select
                                                                                    class="form-control w-100 js-example-basic-single"
                                                                                    id="bulan_{{ $t->id }}"
                                                                                    required name="bulan">
                                                                                    @php
                                                                                        $months = [
                                                                                            'Januari',
                                                                                            'Februari',
                                                                                            'Maret',
                                                                                            'April',
                                                                                            'Mei',
                                                                                            'Juni',
                                                                                            'Juli',
                                                                                            'Agustus',
                                                                                            'September',
                                                                                            'Oktober',
                                                                                            'November',
                                                                                            'Desember',
                                                                                        ];
                                                                                    @endphp
                                                                                    @foreach ($months as $index => $name)
                                                                                        <option
                                                                                            value="{{ $index + 1 }}"
                                                                                            @selected($index + 1 == $t->bulan)>
                                                                                            {{ $name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="tahun_{{ $t->id }}">Tahun</label>
                                                                                <input type="number"
                                                                                    id="tahun_{{ $t->id }}"
                                                                                    class="form-control w-100"
                                                                                    name="tahun"
                                                                                    value="{{ $t->tahun ?? date('Y') }}"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    {{-- <button type="submit" class="btn btn-success"
                                                                    onclick="this.disabled=true;this.innerHTML = '<i class=\'fa fa-spinner fa-spin\'></i> Menambahkan...';this.form.submit();">
                                                                    <i class="fa fa-paper-plane"></i> Tambah
                                                                </button> --}}
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary"
                                                                        onclick="this.disabled=true;this.innerHTML = '<i class=\'fa fa-spinner fa-spin\'></i> Menyimpan...';this.form.submit();">
                                                                        <i class="fa fa-save"></i> Simpan Perubahan
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(document).on("input", ".nominal", function(e) {
                // let bilangan = e.target.value.replace(/[^,\d]/g, '').toString();
                let bilangan = $(this).val().replace(/[^,\d]/g, '').toString();
                let split = bilangan.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);
                if (ribuan) rupiah += (sisa ? '.' : '') + ribuan.join('.');
                $(this).val('Rp. ' + (split[1] !== undefined ? rupiah + ',' + split[1] : rupiah));
            });

            $("#tambahInput").click(function() {
                let newInput = $(".gaji-item:first").clone();
                newInput.find("input, select").val("");
                newInput.find(".select2").remove();
                newInput.find("select").removeClass("select2-hidden-accessible").removeAttr(
                    "data-select2-id").removeAttr("aria-hidden");

                newInput.find('[data-select2-id]').removeAttr('data-select2-id');
                $("#gaji-container").append(newInput);

                newInput.find("select").removeData("select2");
                newInput.find(".js-example-basic-single").select2({
                    width: "100%",
                    placeholder: "--- Pilih Opsi ---",
                    allowClear: true,
                    dropdownParent: newInput
                });

            });

            var kafalahRowHTML = `
            <div class="d-flex kafalah-row align-items-center mb-2">
                <div class="form-group mb-0 flex-grow-1">
                    <select class="form-control kafalah-select" required="required" name="pemasukan[]">
                        <option value="">--- Pilih Kafalah ---</option>
                        @foreach ($kafalah as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-0 mx-2 flex-grow-1">
                    <input placeholder="Masukan nominal..." class="form-control nominal " name="pemasukan-nominal[]" autocomplete="off">
                </div>
                <button type="button" class="btn btn-danger hapus-kafalah">-</button>
            </div>
            `;

            var potonganRowHTML = `
            <div class="d-flex potongan-row align-items-center mb-2">
                <div class="form-group mb-0 flex-grow-1">
                    <select class="form-control" required="required" name="potongan[]">
                        <option value="">--- Pilih Potongan ---</option>
                        @foreach ($potongan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-0 mx-2 flex-grow-1">
                    <input placeholder="Masukan nominal..." class="form-control nominal" name="potongan-nominal[]" autocomplete="off">
                </div>
                <button type="button" class="btn btn-danger hapus-potongan">-</button>
            </div>
            `;

            $('#gaji-container').on('click', '.tambah-kafalah', function() {
                var kafalahContainer = $(this).closest('.gaji-wrapper').find('#kafalah-container');
                $(kafalahContainer).append(kafalahRowHTML);
            });

            $('#gaji-container').on('click', '.tambah-potongan', function() {
                var potonganContainer = $(this).closest('.gaji-wrapper').find('#potongan-container');
                $(potonganContainer).append(potonganRowHTML);
            });

            $('#gaji-container').on('click', '.hapus-kafalah', function() {
                $(this).closest('.kafalah-row').remove();
            });

            $('#gaji-container').on('click', '.hapus-potongan', function() {
                $(this).closest('.potongan-row').remove();
            });

            $(document).on("click", ".remove-input", function() {
                if ($("#gaji-container").find(".gaji-item").length > 1) $(this).closest(
                    ".gaji-item").remove();
                else alert("Minimal harus ada satu gaji!");
            });

            $('#exampleModal').on('show.bs.modal', function() {
                $(".js-example-basic-single").select2({
                    width: "100%",
                    placeholder: "--- Pilih Opsi ---",
                    allowClear: true,
                    dropdownParent: $(this),
                    theme: "bootstrap4",
                });
            })

            $('[id^=modalEdit_]').on('shown.bs.modal', function() {
                var modalId = $(this).attr('id');
                console.log(modalId)
                $("#" + modalId + " .js-example-basic-single").select2({
                    width: "100%",
                    placeholder: "--- Pilih Opsi ---",
                    allowClear: true,
                    dropdownParent: $("#" + modalId),
                    // dropdownCssClass: 'form-control',
                    theme: "bootstrap4",
                });
            });

            // $('.tambah-pemasukan-btn').on('click', function() {
            //     var container = $('#pemasukan-container');

            //     if (container.find('.input-group').length === 0) {
            //         alert('Tidak ada baris untuk dicontoh. Silakan refresh halaman.');
            //         return;
            //     }
            //     var newRow = container.find('.input-group:first').clone();
            //     newRow.find('select').val('');
            //     newRow.find('input[type="number"]').val('');

            //     container.append(newRow);
            //     // newRow.find('.js-example-basic-single').select2();
            // });


            $(document).on('click', '.tambah-potongan-btn', function() {
                var container = $(this).closest('.col').find('.edit-potongan-container');

                if (container.find('.input-group').length === 0) {
                    alert('Tidak ada baris untuk dicontoh. Silakan refresh halaman.');
                    return;
                }

                var newRow = container.find('.input-group:first').clone();
                newRow.find('select').val('');
                newRow.find('input.nominal').val('');

                container.append(newRow);
            });

            // $('.tambah-potongan-btn').on('click', function() {
            //     var container = $('#edit-potongan-container');
            //     console.log(container)
            //     if (container.find('.input-group').length === 0) {
            //         alert('Tidak ada baris untuk dicontoh. Silakan refresh halaman.');
            //         return;
            //     }

            //     var newRow = container.find('.input-group:first').clone();
            //     newRow.find('select').val('');
            //     newRow.find('input[type="number"]').val('');

            //     container.append(newRow);
            //     // newRow.find('.js-example-basic-single').select2();
            // });

            $(document).on('click', '.tambah-pemasukan-btn', function() {
                var container = $(this).closest('.col').find('.edit-pemasukan-container');

                if (container.find('.input-group').length === 0) {
                    alert('Tidak ada baris untuk dicontoh. Silakan refresh halaman.');
                    return;
                }

                var newRow = container.find('.input-group:first').clone();
                newRow.find('select').val('');
                newRow.find('input.nominal').val('');

                container.append(newRow);
            });

            $(document).on('click', '.hapus-baris-btn', function() {
                var container = $(this).closest('.edit-pemasukan-container, .edit-potongan-container');

                var rowCount = container.children('.input-group').length;

                if (rowCount > 1) {
                    $(this).closest('.input-group').remove();
                } else {
                    alert('Baris terakhir tidak dapat dihapus.');
                }
            });
            // JABATAN
            let $jabatanSelect = $('#jabatan-select');
            let $jabatanNominal = $('#jabatan-nominal');
            $('#pegawai-select').change(function(e) {
                e.preventDefault();

                let token = $('[name="_token"]').val()
                var data = $.post("{{ route('api.check-tunjangan') }}", {
                        pegawai: $(this).val(),
                        '_token': token
                    },
                    function(data, textStatus, jqXHR) {
                        console.log(textStatus)
                    },
                    "json"
                );
                data.done(function({
                    data
                }) {
                    $jabatanSelect.append($('<option>', {
                        text: data.nama,
                        value: data.nama,
                        selected: true
                    }));
                    $jabatanNominal.val(data.tunjangan);
                    console.log(data)
                });
            });

            // SELECT KAFALAH AND POTONGAN
            const kafalah = @json($kafalah);
            const potongan = @json($potongan);
            $(document).on('change', '.kafalah-select', function() {
                let idPemasukan = $(this).val();
                let nominal = kafalah.find(function(data) {
                    return data.id == idPemasukan
                }).nominal;
                $(this).closest('.kafalah-row').find('input[name="pemasukan-nominal[]"]').val(nominal);
            });

            $(document).on('change', 'select[name="potongan[]"]', function() {
                let idPotongan = $(this).val();
                console.log(idPotongan);
                let nominal = potongan.find(function(data) {
                    return data.id == idPotongan
                }).nominal;
                $(this).closest('.potongan-row').find('input[name="potongan-nominal[]"]').val(nominal);
            });
        });
    </script>
@endsection
