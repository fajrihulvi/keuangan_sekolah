@extends('app.master')

@section('konten')
    <div class="content-body">

        <div class="row page-titles mx-0 mt-2">

            {{-- <h3 class="col p-md-0">Siswa</h3> --}}

            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Siswa</a></li>
                </ol>
            </div>

        </div>

        <div class="container-fluid">

            <div class="card">
                <div class="card-header pt-4">
                    <div class="">
                        <button type="button" class="btn btn-success ml-2 float-right" data-toggle="modal"
                            data-target="#exampleModal">
                            <i class="fa fa-plus"></i> &nbsp IMPORT DATA
                        </button>
                        <a href="{{ route('siswa.create') }}" class="btn btn-primary float-right"><i class="fa fa-plus"></i>
                            &nbsp TAMBAH SISWA</a>
                    </div>
                    <h4>Data Siswa Sistem</h4>

                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('import.siswa') }}" method="post" enctype="multipart/form-data">
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Import Data Siswa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <div class="form-group">
                                            <div class="form-group has-feedback">
                                                {{-- <label class="text-dark">Importy</label> --}}
                                                <input id="import_siswa" type="file" placeholder="Masukkan nama kelas"
                                                    class="form-control @error('import_siswa') is-invalid @enderror"
                                                    name="import_siswa" value="{{ old('import_siswa') }}" autocomplete="off">
                                                @error('import_siswa')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                                class="ti-close m-r-5 f-s-12"></i> Tutup</button>
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fa fa-paper-plane m-r-5"></i> Import</button>
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
                                    <th>NAMA</th>
                                    <th class="text-center">NISN</th>
                                    <th class="text-center">Kelas</th>
                                    <th class="text-center">Nama Orang Tua</th>
                                    <th class="text-center">Alamat</th>
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
                                            {{ $row->nama_lengkap }}
                                        </td>
                                        <td class="text-center">{{ $row->nisn }}</td>
                                        <td class="text-center">{{ $row->kelas->nama_kelas }}</td>
                                        <td class="text-center">{{ $row->nama_orangtua }}</td>
                                        <td class="text-center">{{ $row->alamat }}</td>
                                        <td>
                                            <div class="text-center">
                                                <a href="{{ route('siswa.edit', $row->id) }}"
                                                    class="btn btn-default btn-sm">
                                                    <i class="fa fa-cog"></i>
                                                </a>

                                                {{-- @if ($row->id != 1) --}}
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#hapus_user_{{ $row->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                {{-- @endif --}}
                                            </div>

                                            <!-- modal hapus -->
                                            <form method="POST" action="{{ route('siswa.destroy', $row->id) }}">
                                                <div class="modal fade" id="hapus_user_{{ $row->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Data
                                                                    siswa</h5>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>





        </div>
        <!-- #/ container -->
    </div>
@endsection
