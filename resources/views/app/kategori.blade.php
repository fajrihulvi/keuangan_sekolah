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
                                            <label>Jenis</label>
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
                                    <th class="text-center">NAMA KATEGORI</th>
                                    <th class="text-center" width="20%">Untuk Siswa</th>
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
                                        <td class="text-center">{{ $k->kategori }}</td>
                                        <td class="text-center">{{ $k->untuk_siswa === "Y"? "Ya":"Tidak" }}</td>
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
