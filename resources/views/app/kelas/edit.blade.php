@extends('app.master')

@section('konten')

<div class="content-body">

  <div class="row page-titles mx-0 mt-2">

    <h3 class="col p-md-0">Kelas</h3>

    <div class="col p-md-0">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Kelas</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah</a></li>
      </ol>
    </div>

  </div>

  <div class="container-fluid">

    <div class="card">

      <div class="card-header pt-4">
        <a href="{{ route('kelas.index') }}" class="btn btn-primary float-right"><i class="fa fa-arrow-left"></i> &nbsp KEMBALI</a>
        <h4>Edit Kelas Sistem</h4>

      </div>
      <div class="card-body pt-0">

        <div class="row">

          <div class="col-lg-5">

            <form method="POST" action="{{ route('kelas.update',$data->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <div class="form-group has-feedback">
                        <label class="text-dark">Kelas</label>
                        <input id="nama_kelas" type="text" placeholder="Masukkan nama kelas"
                            class="form-control @error('nama_kelas') is-invalid @enderror"
                            name="nama_kelas" value="{{ old('nama_kelas',$data->nama_kelas) }}" autocomplete="off">
                        @error('nama_kelas')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
          </div>


        </div>

      </div>

    </div>

  </div>
  <!-- #/ container -->
</div>

@endsection
