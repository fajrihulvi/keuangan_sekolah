<?php
$pemasukan = null;
$pengeluaran = null;
$bantuan = null;

foreach ($jenis as $item) {
    if (Str::lower($item->tipe) == 'pemasukan') {
        $pemasukan = $item->id;
    } else if (Str::lower($item->tipe) == 'pengeluaran') {
        $pengeluaran = $item->id;
    } else if(Str::lower($item->tipe) == 'bantuan'){
        $bantuan = $item->id;
    }
}

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
    </style>
@endsection

@section('konten')
    <div class="content-body">
        <div class="row page-titles mx-0 mt-2">
            <h3 class="col p-md-0">Transaksi</h3>
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Transaksi</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">

            <div class="card">
                <div class="card-header pt-4">
                    @if (Auth::user()->level != 'pengawas')
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#exampleModal">
                            <i class="fa fa-plus"></i> &nbsp TAMBAH TRANSAKSI
                        </button>
                        <h4>Data Transaksi</h4>
                    @endif
                </div>
                <div class="card-body pt-0">

                    <!-- Modal -->
                    <form action="{{ route('transaksi.aksi') }}" method="post">
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        @csrf

                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="text" class="form-control datepicker2" required="required"
                                                name="tanggal" autocomplete="off" placeholder="Masukkan tanggal ..">
                                        </div>

                                        <div class="form-group">
                                            <label>Jenis</label>
                                            <select class="form-control" required="required" name="jenis" id="jenis">
                                                <option value="">--- Pilih Jenis ---</option>
                                                @foreach ($jenis as $item)
                                                    <option value="{{ $item->id }}">{{ $item->tipe }}</option>
                                                @endforeach
                                                {{-- <option value="{{ $pengeluaran }}">Pengeluaran</option> --}}
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select class="form-control js-example-basic-single" required="required"
                                                name="kategori_id" id="kategori" data-placeholder="--- Pilih Kategori ---">
                                                <option></option>
                                                {{-- @foreach ($kategori as $k)
                                                    <option value="{{ $k->id }}">{{ $k->kategori }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>

                                        <div class="form-group" id="kelas">
                                            <label>Kelas</label>
                                            <select class="form-control js-example-basic-single" name="kelas"
                                                id="kelas-select" data-placeholder="--- Pilih Kelas ---">
                                                <option value=""></option>
                                            </select>
                                        </div>

                                        <div class="form-group" id="siswa">
                                            <label>Siswa</label>
                                            <select class="form-control js-example-basic-single" name="id_siswa"
                                                id="siswa-select" data-placeholder="--- Pilih Siswa ---">
                                                <option value=""></option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Nominal</label>
                                            <input type="text" class="form-control nominal" required="required" name="nominal"
                                                autocomplete="off" placeholder="Masukkan nominal .." >
                                        </div>

                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea class="form-control" name="keterangan" required placeholder="Masukkan keterangan .."></textarea>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                                class="ti-close m-r-5 f-s-12"></i> Tutup</button>
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fa fa-paper-plane m-r-5"></i> Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('transaksi') }}" method="GET" class="mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Tipe</label>
                                    <select class="form-control" name="jenis" id="filter-jenis">
                                        <option value="">Semua</option>
                                        @foreach ($jenis as $item)
                                            <option value="{{ $item->id }}">{{ $item->tipe }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Kategori</label>
                                    <select class="form-control" name="kategori" id="kategori-filter">
                                        <option value="">Semua</option>
                                        {{-- @foreach ($kategori as $row)
                                            <option value="{{ $row->id }}"
                                                {{ request('kategori') == $row->id ? 'selected' : '' }}>
                                                {{ $row->kategori }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Bulan</label>
                                    <select class="form-control" name="bulan">
                                        <option value="">Semua</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}"
                                                {{ request('bulan') == $i ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Tahun</label>
                                    <select class="form-control" name="tahun">
                                        <option value="">Semua</option>
                                        @foreach (range(date('Y'), date('Y') - 10) as $tahun)
                                            <option value="{{ $tahun }}"
                                                {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                                {{ $tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-filter"></i>
                                        Filter</button>
                                    <a href="{{ route('transaksi') }}" class="btn btn-secondary"><i
                                            class="fa fa-refresh"></i> Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="table-datatable" style="width: 100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center" width="1%">NO</th>
                                    <th rowspan="2" class="text-center" width="11%">TANGGAL</th>
                                    <th rowspan="2" class="text-center">KATEGORI</th>
                                    <th rowspan="2" class="text-center">NAMA SISWA</th>
                                    <th rowspan="2" class="text-center">KELAS</th>
                                    <th rowspan="2" class="text-center">KETERANGAN</th>
                                    <th colspan="2" class="text-center">JENIS</th>
                                    @if (Auth::user()->level != 'pengawas')
                                        <th rowspan="2" class="text-center" width="10%">OPSI</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th class="text-center">PEMASUKAN</th>
                                    <th class="text-center">PENGELUARAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                    $saldo = 0;
                                @endphp
                                @foreach ($transaksi as $t)
                                    <?php
                                    if ($t->jenis == $pemasukan) {
                                        $saldo += $t->nominal;
                                    } else if($t->jenis == $bantuan){
                                        $saldo += $t->nominal;
                                    }
                                    else {
                                        $saldo -= $t->nominal;
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($t->tanggal)) }}</td>
                                        <td class="text-center">{{ $t->kategori->kategori }} <span class="font-italic"> ( {{ $t->kategori->jenis->tipe }} )</span></td>
                                        <td class="text-center">
                                            {{ isset($t->siswa->nama_lengkap) ? $t->siswa->nama_lengkap : '-' }}</td>
                                        <td class="text-center">
                                            {{ isset($t->siswa->kelas->nama_kelas) ? $t->siswa->kelas->nama_kelas : '-' }}
                                        </td>
                                        <td class="text-center">{{ $t->keterangan }}</td>
                                        <td class="text-center">
                                            @if ($t->jenis == $pemasukan )
                                                {{ 'Rp.' . number_format($t->nominal) . ',-' }}
                                            @elseif ($t->jenis == $bantuan)
                                                {{ 'Rp.' . number_format($t->nominal) . ',-' }}
                                            @else
                                                {{-- {{ '-' }} --}}
                                                {{ $bantuan }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($t->jenis == $pengeluaran)
                                                {{ 'Rp.' . number_format($t->nominal) . ',-' }}
                                            @else
                                                {{ '-' }}
                                            @endif
                                        </td>
                                        @if (Auth::user()->level != 'pengawas')
                                            <td>
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-default btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modalEdit_{{ $t->id }}"><i
                                                            class="fa fa-cog"></i></button>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modalDelete_{{ $t->id }}"><i
                                                            class="fa fa-trash"></i></button>
                                                </div>
                                                <!-- Modal -->
                                                {{-- Edit Kategori --}}
                                                <form method="POST"
                                                    action="{{ route('transaksi.update', ['id' => $t->id]) }}">
                                                    <div class="modal fade" id="modalEdit_{{ $t->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="modalEditLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                        Transaksi</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @csrf
                                                                    {{ method_field('PUT') }}

                                                                    <div class="form-group"
                                                                        style="width: 100%;margin-bottom:20px">
                                                                        <label>Tanggal</label>
                                                                        <input type="text"
                                                                            class="form-control datepicker2 py-0"
                                                                            required="required" name="tanggal"
                                                                            value="{{ $t->tanggal }}"
                                                                            style="width: 100%">
                                                                    </div>

                                                                    <div class="form-group"
                                                                        style="width: 100%;margin-bottom:20px">
                                                                        <label>Jenis</label>
                                                                        <select class="form-control py-0 jenis-edit jenis"
                                                                            required="required" name="jenis"
                                                                            style="width: 100%">
                                                                            <option value="">--- Pilih Jenis ---
                                                                            </option>
                                                                            @foreach ($jenis as $item)
                                                                                <option
                                                                                    {{ $item->id == $t->jenis ? "selected='selected'" : '' }}
                                                                                    value="{{ $item->id }}">
                                                                                    {{ $item->tipe }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group"
                                                                        style="width: 100%;margin-bottom:20px">
                                                                        <label>Kategori</label>
                                                                        <select class="form-control py-0 kategori"
                                                                            required="required" style="width: 100%" name="kategori_id">
                                                                            <option value="">--- Pilih Kategori ---
                                                                            </option>
                                                                            @foreach ($kategori as $k)
                                                                                <option
                                                                                    {{ old('kategori_id', $t->kategori->id) == $k->id ? "selected='selected'" : '' }}
                                                                                    value="{{ $k->id }}">
                                                                                    {{ $k->kategori }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    @isset ($t->siswa)

                                                                    <div class="form-group wrapper-kelas" id="kelas">
                                                                        <label>Kelas</label>
                                                                        <select class="form-control kelas" name="kelas"
                                                                            style="width: 100%;margin-bottom:20px">
                                                                            <option value="">--- Pilih Kelas ---
                                                                            </option>
                                                                            @foreach($kelas as $kelas_item)
                                                                                <option value="{{ $kelas_item->id }}" @if ($t->siswa->id_kelas == $kelas_item->id)
                                                                                    selected
                                                                                @endif>
                                                                                    {{ $kelas_item->nama_kelas }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group wrapper-siswa" id="siswa">
                                                                        <label>Siswa</label>
                                                                        <select class="form-control siswa" name="id_siswa"
                                                                            style="width: 100%;margin-bottom:20px">
                                                                            <option value="">--- Pilih Siswa ---</option>
                                                                            @foreach ($siswa as $siswa_item)
                                                                                <option
                                                                                    value="{{ $siswa_item->id }}" @if ($siswa_item->id == $t->id_siswa)
                                                                                        selected
                                                                                    @endif>
                                                                                    {{ $siswa_item->nama_lengkap }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    @endisset

                                                                    <div class="form-group"
                                                                        style="width: 100%;margin-bottom:20px">
                                                                        <label>Nominal</label>
                                                                        <input type="text" class="form-control py-0 nominal"
                                                                            required="required" name="nominal"
                                                                            value="{{ $t->nominal }}"
                                                                            style="width: 100%" >
                                                                    </div>

                                                                    <div class="form-group"
                                                                        style="width: 100%;margin-bottom:20px">
                                                                        <label>Keterangan</label>
                                                                        <textarea class="form-control py-0" name="keterangan" autocomplete="off" required
                                                                            placeholder="Masukkan keterangan .." style="width: 100%">{{ $t->keterangan }}</textarea>
                                                                    </div>


                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal"><i
                                                                            class="ti-close m-r-5 f-s-12"></i>
                                                                        Tutup</button>
                                                                    <button type="submit" class="btn btn-primary"><i
                                                                            class="fa fa-paper-plane m-r-5"></i>
                                                                        Simpan</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                <!-- Modal -->
                                                <form method="POST"
                                                    action="{{ route('transaksi.delete', ['id' => $t->id]) }}">
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
            const $kategori = $("#kategori");
            const $jenisFilter = $("#filter-jenis");
            const $kategoriFilter = $("#kategori-filter");
            const $kategoriEdit = $("#kategori-edit");
            const kelas = $("#kelas");
            const siswa = $("#siswa");
            const siswaSelect = $("#siswa-select");
            const kelasSelect = $("#kelas-select");
            let kategoriData = @json($kategori);
            let jenisKategoriFilter = @json($kategori);

            kategoriData.forEach(data => {
                $kategori.append($('<option>', {
                    value: data.id,
                    text: data.kategori
                }))
                $kategoriFilter.append($('<option>', {
                    value: data.id,
                    text: data.kategori
                }))
            })

            $('#jenis').on("change", () => {
                console.log('test')
                kategoriData = @json($kategori);
                kategoriData = kategoriData.filter(data => {
                    return data.id_tipe == $('#jenis').val();
                });
                $kategori.empty();
                $kategori.append($('<option>', {
                    value: '',
                    text: "--- Pilih Kategori ---"
                }))
                $('#jenis').val() == "" ? kategoriData = @json($kategori) : '';
                kategoriData.forEach(data => {
                    $kategori.append($('<option>', {
                        value: data.id,
                        text: data.kategori
                    }))
                })
            });

            $('.jenis').on("change", () => {
                jenisKategoriFilter = @json($kategori);
                jenisKategoriFilter = jenisKategoriFilter.filter(data => data.id_tipe == $('.jenis').val());
                $('.kategori').empty();
                $('.jenis').val() == "" ? jenisKategoriFilter = @json($kategori) : '';
                $('.kategori').append($('<option>', {
                    value: '',
                    text: "Semua"
                }));
                jenisKategoriFilter.forEach(data => {
                    $('.kategori').append($('<option>', {
                        value: data.id,
                        text: data.kategori
                    }));
                })
            });

            $('.kategori').on("change", function() {
                $('.wrapper-kelas').hide()
                $('.wrapper-siswa').hide()
                const found = kategoriData.find(item => {
                    return item.id == $('.kategori').val()
                })
                if (found.untuk_siswa === "Y") {
                    $('.wrapper-kelas').show()
                    $('.kelas').empty()
                    $.ajax({
                        url: "{{ route('kelas') }}",
                        type: "GET",
                        dataType: "json",
                        success: data => {
                            data.forEach(item => {
                                $('.kelas').append(
                                    `<option value="${item.id}">${item.nama_kelas}</option>`
                                )
                            })
                        }
                    })
                    $('.kelas').on("change", () => {
                        $('.wrapper-siswa').show();
                        $('.siswa').empty();
                        $.ajax({
                            url: "{{ route('siswa-kelas') }}?kelas=" + $('.kelas').val(),
                            type: "GET",
                            dataType: "json",
                            success: data => {
                                $('.siswa').append($('<option>',{text:'--- Pilih Siswa ---'}))
                                data.forEach(item => {
                                    $('.siswa').append(
                                        `<option value="${item.id}">${item.nama_lengkap}</option>`
                                    )
                                })
                            }
                        })
                    })
                } else {
                    $('.wrapper-kelas').hide();
                    $('.wrapper-siswa').hide();
                }
            })

            $jenisFilter.on("change", () => {
                jenisKategoriFilter = @json($kategori);
                jenisKategoriFilter = jenisKategoriFilter.filter(data => data.id_tipe == $jenisFilter
                    .val());
                $kategoriFilter.empty();
                $jenisFilter.val() == "" ? jenisKategoriFilter = @json($kategori) : '';
                $kategoriFilter.append($('<option>', {
                    value: '',
                    text: "Semua"
                }));
                jenisKategoriFilter.forEach(data => {
                    $kategoriFilter.append($('<option>', {
                        value: data.id,
                        text: data.kategori
                    }));
                })
            })

            kelas.hide()
            siswa.hide()
            $kategori.on("change", function() {
                kelas.hide()
                siswa.hide()
                const found = kategoriData.find(item => {
                    return item.id == $kategori.val()
                })
                if (found.untuk_siswa === "Y") {
                    kelas.show()
                    $.ajax({
                        url: "{{ route('kelas') }}",
                        type: "GET",
                        dataType: "json",
                        success: data => {
                            data.forEach(item => {
                                kelasSelect.append(
                                    `<option value="${item.id}">${item.nama_kelas}</option>`
                                )
                            })
                        }
                    })
                    kelas.on("change", () => {
                        siswa.show();
                        siswaSelect.empty();
                        $.ajax({
                            url: "{{ route('siswa-kelas') }}?kelas=" + kelasSelect.val(),
                            type: "GET",
                            dataType: "json",
                            success: data => {
                                siswaSelect.append($('<option>'))
                                data.forEach(item => {
                                    siswaSelect.append(
                                        `<option value="${item.id}">${item.nama_lengkap}</option>`
                                    )
                                })
                            }
                        })
                    })
                } else {
                    kelas.hide();
                    siswa.hide();
                }
            })

            $('.js-example-basic-single').select2({
                width: '100%',
                placeholder: 'Pilih Opsi',
                allowClear: true,
                dropdownParent: $('#exampleModal'),
                // theme: "bootstrap4",
                minimumResultsForSearch: Infinity,
            }).addClass("form-control");

            $('#kelas-select').select2({
                width: '100%',
                placeholder: '--- Pilih Kelas ---',
                allowClear: true,
                dropdownParent: $('#exampleModal')
            }).addClass("form-control");

            $('#siswa-select').select2({
                width: '100%',
                placeholder: '--- Pilih Siswa ---',
                allowClear: true,
                // theme: "bootstrap4",
                dropdownParent: $('#exampleModal')
            }).addClass("form-control");

            $('.nominal').on('input', function (e) {
                let bilangan = e.target.value.replace(/[^,\d]/g, '').toString();
                let split = bilangan.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

                $(this).val('Rp. ' + rupiah);
            });
        })
    </script>
@endsection
