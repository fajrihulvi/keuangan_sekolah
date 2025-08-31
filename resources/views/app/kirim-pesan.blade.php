@extends('app.master')

@section('konten')
    <div class="content-body">

        <div class="row page-titles mx-0 mt-2">

            <h3 class="col p-md-0">Kirim Pesan</h3>

            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Kirim Pesan</a></li>
                </ol>
            </div>

        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Cari berdasarkan Kelas</h4>
                    <form action="{{ route('kirim-pesan') }}" method="GET">
                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label>Kelas</label>
                                <select class="form-control select2 @error('search') is-invalid @enderror" name="search" onchange="form.submit()">
                                    <option value=""></option>
                                    @foreach ($kelas as $row)
                                        <option <?php if (old('search') == $row->nama_kelas) {
                                            echo "selected='selected'";
                                        } ?> value="{{ $row->nama_kelas }}">
                                            {{ $row->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-lg-1 align-items-center d-flex">
                                <button type="submit" class="btn btn-primary btn-md h-2">Cari</button>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @isset($data)
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h4>Kelas {{ request()->search }}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table-datatable">
                                <thead>
                                    <tr>
                                        <th width="1%"><input type="checkbox" name="" id="check-all"></th>
                                        {{-- <th width="1%">NO</th> --}}
                                        <th>Nama Siswa</th>
                                        <th>Nama Orang Tua</th>
                                        <th>Nomor Handphone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $row)
                                        <tr>
                                            <td width="1%"><input type="checkbox" name="ids_siswa[]" value="{{ $row->id }}"></td>
                                            {{-- <td width="1%">{{ $loop->iteration }}</td> --}}
                                            <td>{{ $row->nama_lengkap }}</td>
                                            <td>{{ $row->nama_orangtua }}</td>
                                            <td>{{ $row->nohp_orangtua }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "--- Pilih Kelas ---",
                theme:'bootstrap4'
            });
        });
    </script>
@endsection
