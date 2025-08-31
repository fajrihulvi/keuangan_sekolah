@extends('app.master')

@section('konten')
    <div class="content-body">

        <div class="row page-titles mx-0 mt-2">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Jabatan</a></li>
                </ol>
            </div>

        </div>

        <div class="container-fluid">

            <div class="card">

                <div class="card-header pt-4">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                        data-target="#exampleModal">
                        <i class="fa fa-plus"></i> &nbsp TAMBAH JABATAN
                    </button>
                    <h4>Data Jabatan</h4>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('jabatan.store') }}" method="post">
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Jabatan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        @method('POST')
                                        <x-forms.input name="nama" label="Nama Jabatan" />
                                        <x-forms.input name="tunjangan" label="Tunjangan Jabatan" />
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
                                    <th>Nama Jabatan</th>
                                    <th>Tunjangan</th>
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
                                            {{ $row->tunjangan != 0?'Rp'.number_format($row->tunjangan,0,',','.'):'-' }}
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
                                            <form method="POST" action="{{ route('jabatan.destroy', $row->id) }}">
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
                                            <form method="POST" action="{{ route('jabatan.update', $row->id) }}">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit data
                                                            Jabatan</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @method('PUT')
                                                        @csrf
                                                        <x-forms.input name="nama" label="Nama Jabatan"
                                                            value="{{ $row->nama }}" />
                                                        <x-forms.input name="edit_tunjangan" label="Tunjangan Jabatan"
                                                            value="{{ $row->tunjangan }}" />
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

            $(document).on("input", "#tunjangan_input, #edit_tunjangan_input", function(e) {
                // let bilangan = e.target.value.replace(/[^,\d]/g, '').toString();
                let bilangan = $(this).val().replace(/[^,\d]/g, '').toString();
                let split = bilangan.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);
                if (ribuan) rupiah += (sisa ? '.' : '') + ribuan.join('.');
                $(this).val('Rp ' + (split[1] !== undefined ? rupiah + ',' + split[1] : rupiah));
            });
        })
    </script>
@endsection
