@extends('app.master')

@section('konten')
    <div class="content-body">

        <div class="row page-titles mx-0 mt-2">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Kafalah</a></li>
                </ol>
            </div>

        </div>

        <div class="container-fluid">

            <div class="card">

                <div class="card-header pt-4">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                        data-target="#exampleModal">
                        <i class="fa fa-plus"></i> &nbsp TAMBAH POTONGAN
                    </button>
                    <h4>Data Potongan Gaji</h4>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('potongan.store') }}" method="post">
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Potongan Gaji</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        @method('POST')
                                        <x-forms.input name="nama" label="Nama Potongan" />
                                        <div class="form-group has-feedback">
                                            <label class="text-dark">Nominal</label>
                                            <input type="text" placeholder="Masukan nominal..."
                                                class="form-control w-100 nominal @error('nominal') is-invalid @enderror"
                                                name="nominal" value="{{ old('nominal') }}" autocomplete="off">
                                            @error('nominal')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                                class="ti-close m-r-5 f-s-12"></i> Tutup</button>
                                        <button type="submit" class="btn btn-primary"
                                            onclick="this.disabled=true; this.innerHTML='<i class=\'fa fa-spinner fa-spin\'></i> Menambahkan...'; this.form.submit();"><i
                                                class="fa fa-paper-plane m-r-5"></i> Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="table-datatable">
                            <thead>
                                <tr>
                                    <th width="1%">NO</th>
                                    <th>Jenis Potongan</th>
                                    <th>Nominal</th>
                                    <th class="text-center" width="10%">OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $row)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>
                                            {{ $row->nama }}
                                        </td>
                                        <td>Rp.{{ number_format($row->nominal,0,',','.') }}</td>
                                        <td>
                                            <div class="text-center">

                                                <button type="button" class="btn btn-outline-light btn-sm"
                                                    data-toggle="modal" data-target="#update_user_{{ $row->id }}">
                                                    <i class="fa fa-cog"></i>
                                                </button>
                                                {{-- <a href="#"
                                                    class="btn btn-default btn-sm">
                                                </a> --}}

                                                {{-- @if ($row->id != 1) --}}
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#hapus_user_{{ $row->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                {{-- @endif --}}
                                            </div>

                                            <!-- modal hapus -->
                                            <form method="POST" action="{{ route('potongan.destroy', $row->id) }}">
                                                <div class="modal fade" id="hapus_user_{{ $row->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Data
                                                                    Jenis</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <p>Yakin ingin menghapus data ini ?</p>

                                                                @csrf
                                                                @method('delete')
                                                                {{-- {{ method_field('DELETE') }} --}}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal"><i
                                                                        class="ti-close m-r-5 f-s-12"></i> Batal</button>
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="this.disabled=true; this.innerHTML='<i class=\'fa fa-spinner fa-spin\'></i> Menghapus...'; this.form.submit();"><i
                                                                        class="fa fa-paper-plane m-r-5"></i> Ya,
                                                                    Hapus</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>


                                        </td>
                                    </tr>
                                    <div class="modal fade" id="update_user_{{ $row->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form method="POST" action="{{ route('potongan.update', $row->id) }}">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit data
                                                            potongan gaji</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @method('PUT')
                                                        @csrf
                                                        <x-forms.input name="nama" label="Kategori Potongan"
                                                            value="{{ $row->nama }}" />
                                                        <div class="form-group has-feedback">
                                                            <label class="text-dark">Nominal</label>
                                                            <input type="text" placeholder="Masukan nominal..."
                                                                class="form-control w-100 nominal @error('nominal') is-invalid @enderror"
                                                                name="nominal" value="{{ old('nominal', $row->nominal) }}"
                                                                autocomplete="off">
                                                            @error('nominal')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal"><i class="ti-close m-r-5 f-s-12"></i>
                                                            Batal</button>
                                                        <button type="submit" class="btn btn-primary"><i
                                                                class="fa fa-paper-plane m-r-5"></i> Ya,
                                                            Edit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
        });
    </script>
@endsection
