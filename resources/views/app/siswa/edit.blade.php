@extends('app.master')

@section('konten')

<div class="content-body">

  <div class="row page-titles mx-0 mt-2">

    <h3 class="col p-md-0">Siswa</h3>

    <div class="col p-md-0">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Siswa</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah</a></li>
      </ol>
    </div>

  </div>

  <div class="container-fluid">

    <div class="card">

      <div class="card-header pt-4">
        <a href="{{ route('siswa.index') }}" class="btn btn-primary float-right"><i class="fa fa-arrow-left"></i> &nbsp KEMBALI</a>
        <h4>Edit Siswa Sistem</h4>

      </div>
      <div class="card-body pt-0">

        <div class="row">

          <div class="col-lg-5">

            <form method="POST" action="{{ route('siswa.update',$data->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <div class="form-group has-feedback">
                        <label class="text-dark">Nama</label>
                        <input id="nama_lengkap" type="text" placeholder="Masukkan nama siswa"
                            class="form-control @error('nama_lengkap') is-invalid @enderror"
                            name="nama_lengkap" value="{{ old('nama_lengkap',$data->nama_lengkap) }}" autocomplete="off">
                        @error('nama_lengkap')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group has-feedback">
                        <label class="text-dark">Nama</label>
                        <input id="nisn" type="text" placeholder="Masukkan NISN siswa"
                            class="form-control @error('nisn') is-invalid @enderror"
                            name="nisn" value="{{ old('nisn',$data->nisn) }}" autocomplete="off">
                        @error('nisn')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group has-feedback">
                        <label class="text-dark">Kelas</label>
                        <select class="form-control @error('id_kelas') is-invalid @enderror"
                            name="id_kelas">
                            @foreach ($kelas as $row)
                                <option <?php if (old('id_kelas',$data->id_kelas) == $row->id) {
                                    echo "selected='selected'";
                                } ?> value="{{ $row->id }}">
                                    {{ $row->nama_kelas }}</option>
                            @endforeach
                        </select>

                        @error('id_kelas')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group has-feedback">
                        <label class="text-dark">Nama Orang Tua</label>
                        <input id="nama_orangtua" type="text" placeholder="Masukkan nama orang tua siswa"
                            class="form-control @error('nama_orangtua') is-invalid @enderror"
                            name="nama_orangtua" value="{{ old('nama_orangtua') }}" autocomplete="off">
                        @error('nama_orangtua')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group has-feedback">
                        <label class="text-dark">Nomor Hp Orang Tua</label>
                        <input id="nohp_orangtua" type="text" placeholder="Masukkan nomor HP Orang tua siswa"
                            class="form-control @error('nohp_orangtua') is-invalid @enderror"
                            name="nohp_orangtua" value="{{ old('nohp_orangtua') }}" autocomplete="off">
                        @error('nohp_orangtua')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group has-feedback">
                        <label class="text-dark">Alamat</label>
                        <textarea name="alamat" id="alamat" cols="30" rows="10"
                            class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan alamat siswa">{{ old('alamat',$data->alamat) }}</textarea>
                        @error('alamat')
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
