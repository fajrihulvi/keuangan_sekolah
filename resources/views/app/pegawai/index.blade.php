@extends('app.master')

@section('konten')
    <div class="content-body">

        <div class="row page-titles mx-0 mt-2">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Pegawai</a></li>
                </ol>
            </div>

        </div>

        <div class="container-fluid">

            <div class="card">

                <div class="card-header pt-4">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                        data-target="#exampleModal">
                        <i class="fa fa-plus"></i> &nbsp TAMBAH PEGAWAI
                    </button>
                    <h4>Data Pegawai</h4>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('pegawai.store') }}" method="post">
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Pegawai</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        @method('POST')
                                        <x-forms.input name="nama" label="Nama Pegawai" />
                                        <div class="form-group">
                                            <label>Jabatan</label>
                                            <select class="form-control @error('id_jabatan') is-invalid @enderror"
                                                name="id_jabatan" id="jabatan-select">
                                                <option value=""></option>
                                                @foreach ($jabatan as $row)
                                                    <option value="{{ $row->id }}" @selected(old('id_jabatan') == $row->id)>
                                                        {{ $row->nama }}</option>
                                                @endforeach
                                            </select>
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

                    <div class="table-responsive">
                        <table class="table table-bordered" id="table-datatable">
                            <thead>
                                <tr>
                                    <th width="1%">NO</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
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
                                        <td>
                                            {{ $row->jabatan->nama }}
                                        </td>
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
                                            <form method="POST" action="{{ route('pegawai.destroy', $row->id) }}">
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
                                                                <button type="submit" class="btn btn-primary"><i
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
                                            <form method="POST" action="{{ route('pegawai.update', $row->id) }}">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit data
                                                            pegawai</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @method('PUT')
                                                        @csrf
                                                        <x-forms.input name="nama" label="Nama Pegawai"
                                                            value="{{ $row->nama }}" />
                                                        <x-forms.input name="jabatan" label="Jabatan"
                                                            value="{{ $row->jabatan->nama }}" />
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
        $(document).ready(() => {
            $('#jabatan-select').select2({
                width: "100%",
                placeholder: "--- Pilih Opsi ---",
                allowClear: true,
                dropdownParent: $('#exampleModal'),
            });
        })
    </script>
@endsection
