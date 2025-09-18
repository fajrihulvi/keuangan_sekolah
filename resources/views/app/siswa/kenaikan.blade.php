@extends('app.master')

@section('css')
<style>
    #checkAll, .siswa-checkbox {
        width: 20px;
        height: 20px;
        vertical-align: middle;
    }
    input[type="checkbox"]:after,input[type="checkbox"]:checked:after{
        display: none
    }
</style>
@endsection

@section('konten')
<div class="content-body">

    <div class="row page-titles mx-0 mt-2">
        <h3 class="col p-md-0">Kenaikan Kelas</h3>
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Kenaikan Kelas</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">

        {{-- Form untuk filter kelas --}}
        <div class="card">
            <div class="card-header pt-4">
                <h4>Filter Siswa Berdasarkan Kelas</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('kenaikan.index') }}">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="text-dark">Pilih Kelas Asal</label>
                                <select class="form-control" name="kelas_id">
                                    <option value="">--- Semua Kelas ---</option>
                                    @foreach ($semua_kelas as $kelas)
                                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary d-block"><i class="fa fa-filter"></i> &nbsp; Tampilkan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (isset($data_siswa))
        <form action="{{ route('kenaikan.store') }}" method="post">
            @csrf
            <input type="hidden" name="kelas_asal_id" value="{{ request('kelas_id') }}">

            <div class="card">
                <div class="card-header pt-4">
                    <div class="d-flex justify-content-between w-100">
                        <h4>Data Siswa untuk Kenaikan Kelas</h4>
                        <button type="submit" class="btn btn-success" id="prosesBtn" disabled><i class="fa fa-check"></i> &nbsp; Perbarui</button>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row mb-3">
                        <div class="col-md-5">
                             <div class="form-group">
                                <label class="text-dark">Pindahkan ke Kelas (Bagi yang Naik)</label>
                                <select class="form-control @error('kelas_tujuan_id') is-invalid @enderror" name="kelas_tujuan_id">
                                    <option value="">--- Pilih Kelas Tujuan ---</option>
                                     @foreach ($semua_kelas as $kelas)
                                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                @error('kelas_tujuan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="1%" class="text-center">
                                        <input type="checkbox" id="checkAll">
                                    </th>
                                    <th width="1%">NO</th>
                                    <th>NAMA</th>
                                    <th class="text-center">NISN</th>
                                    <th class="text-center">KELAS SAAT INI</th>
                                    <th class="text-center" width="25%">KETERANGAN (opsional)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_siswa as $index => $siswa)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="siswa_ids[]" class="siswa-checkbox" value="{{ $siswa->id }}">
                                        </td>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $siswa->nama_lengkap }}</td>
                                        <td class="text-center">{{ $siswa->nisn }}</td>
                                        <td class="text-center">{{ $siswa->kelas->nama_kelas }}</td>
                                        <td>
                                            <input type="text" name="keterangan[{{ $siswa->id }}]" class="form-control keterangan-input" placeholder="Cth: Pindah sekolah, tinggal kelas, dll." value="{{ $siswa->keterangan }}">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Data tidak ditemukan. Silakan pilih kelas lain.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>

        @endif
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll = document.getElementById('checkAll');
        const siswaCheckboxes = document.querySelectorAll('.siswa-checkbox');
        const prosesBtn = document.getElementById('prosesBtn');
        const keteranganInputs = document.querySelectorAll('.keterangan-input');

        function toggleProsesButton() {
            const anyChecked = Array.from(siswaCheckboxes).some(checkbox => checkbox.checked);
            const anyKeteranganFilled = Array.from(keteranganInputs).some(input => input.value.trim() !== '');
            prosesBtn.disabled = !anyChecked && !anyKeteranganFilled;
        }

        function toggleKeteranganInput(checkbox) {
            const row = checkbox.closest('tr');
            const keteranganInput = row.querySelector('.keterangan-input');

            keteranganInput.disabled = checkbox.checked;
            if (checkbox.checked) {
                keteranganInput.value = '';
            }
        }

        checkAll.addEventListener('change', function () {
            siswaCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                toggleKeteranganInput(checkbox);
            });
            toggleProsesButton();
        });

        siswaCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                toggleKeteranganInput(this);

                if (!this.checked) {
                    checkAll.checked = false;
                } else if (document.querySelectorAll('.siswa-checkbox:checked').length === siswaCheckboxes.length) {
                    checkAll.checked = true;
                }
                toggleProsesButton();
            });
            toggleKeteranganInput(checkbox);
        });

        keteranganInputs.forEach(input => {
            input.addEventListener('keyup', toggleProsesButton);
        });

        toggleProsesButton();
    });
</script>
@endsection
