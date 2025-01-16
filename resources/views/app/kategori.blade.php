@extends('app.master')

@section('konten')
    <div class="content-body">

        <div class="row page-titles mx-0 mt-2">

            <h3 class="col p-md-0">Kategori</h3>

            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Kategori</a></li>
                </ol>
            </div>

        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header pt-4">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                        data-target="#exampleModal">
                        <i class="fa fa-plus"></i> &nbsp TAMBAH KATEGORI
                    </button>
                    <h4>Data Kategori</h4>

                </div>
                <div class="card-body pt-0">
                    <!-- Modal -->
                    <form action="{{ route('kategori.aksi') }}" method="post">
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <div class="form-group">
                                            <label>Nama Kategori</label>
                                            <input type="text" name="kategori" required="required" class="form-control"
                                                placeholder="Nama Kategori ..">
                                                <select class="form-control @error('id_tipe') is-invalid @enderror"
                                                name="id_tipe">
                                                @foreach ($jenis as $row)
                                                    <option <?php if (old('id_tipe') == $row->id) {
                                                        echo "selected='selected'";
                                                    } ?> value="{{ $row->id }}">
                                                        {{ $row->tipe }}</option>
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
                                    <th>NAMA KATEGORI</th>
                                    <th class="text-center" width="10%">OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($kategori as $id => $k)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="d-flex">
                                            @if ($k->untuk_siswa == 'Y')
                                                <button type="button" class="btn btn-link text-left text-decoration-none w-100 p-0 text-dark"
                                                    data-toggle="collapse" data-target="#collapse{{ $id }}" aria-expanded="false"
                                                    aria-controls="collapse{{ $id }}">
                                                    {{ $k->kategori }}
                                                </button>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" height="16" width="16" class="text-dark">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            @else
                                                <p class="text-dark">{{ $k->kategori }}</p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal"
                                                data-target="#edit_kategori_{{ $k->id }}">
                                                <i class="fa fa-cog"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#hapus_kategori_{{ $k->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="collapse" id="collapse{{ $id }}">
                                        <td colspan="3">
                                            <div class="card card-body">
                                                {{-- <h5>Kelas</h5> --}}
                                                @if ($k->untuk_siswa == 'Y')
                                                    @foreach ($kelas as $row)
                                                        <div class="accordion" id="accordion{{ $row->id }}">
                                                            <div class="card">
                                                                <div class="card-header" id="heading{{ $row->id }}">
                                                                    <h5 class="mb-0">
                                                                        <button class="btn btn-link w-100 text-left p-0 text-dark" type="button"
                                                                            data-toggle="collapse" data-target="#collapseKelas{{ $row->id }}"
                                                                            aria-expanded="false" aria-controls="collapseKelas{{ $row->id }}">
                                                                            <strong>Kelas {{ $row->nama_kelas }}</strong>
                                                                        </button>
                                                                    </h5>
                                                                </div>
                                                                <div id="collapseKelas{{ $row->id }}" class="collapse"
                                                                    aria-labelledby="heading{{ $row->id }}" data-parent="#accordion{{ $row->id }}">
                                                                    <div class="card-body">
                                                                        @php
                                                                            $studentsInClass = $siswa->where('id_kelas', $row->id);
                                                                        @endphp

                                                                        @if ($studentsInClass->isNotEmpty())
                                                                        @php
                                                                            $nomor=1;
                                                                        @endphp
                                                                            @foreach ($studentsInClass as $student)
                                                                                <p>{{ $nomor++.'. '. $student->nama_lengkap }}</p>
                                                                            @endforeach
                                                                        @else
                                                                            <p class="text-muted">Belum ada data di kelas ini. <span><a href="{{ route('siswa.create') }}">Tambahkan data siswa</a></span>
                                                                            </p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <form action="{{ route('kategori.update', ['id' => $k->id]) }}"
                                        method="post">
                                        <div class="modal fade" id="edit_kategori_{{ $k->id }}"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit
                                                            Kategori</h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        @csrf
                                                        {{ method_field('PUT') }}

                                                        <div class="form-group" style="width:100%">
                                                            <label>Nama Kategori</label>
                                                            <input type="hidden" name="id"
                                                                value="{{ $k->id }}">
                                                            <input type="text" name="nama"
                                                                required="required" class="form-control"
                                                                placeholder="Nama Kategori .."
                                                                value="{{ $k->kategori }}"
                                                                style="width:100%">
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

                                    <!-- modal hapus -->
                                    <form method="POST"
                                        action="{{ route('kategori.delete', ['id' => $k->id]) }}">
                                        <div class="modal fade" id="hapus_kategori_{{ $k->id }}"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Peringatan!
                                                        </h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <p>Yakin ingin menghapus data ini ?</p>

                                                        @csrf
                                                        {{ method_field('DELETE') }}


                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal"><i
                                                                class="ti-close m-r-5 f-s-12"></i>
                                                            Batal</button>
                                                        <button type="submit" class="btn btn-primary"><i
                                                                class="fa fa-paper-plane m-r-5"></i> Ya,
                                                            Hapus</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
