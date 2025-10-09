<table class="table table-striped table-bordered table-hover ">
    <thead class="thead-dark">
        <tr>
            <th rowspan="2" class="text-center align-middle">NO</th>
            <th rowspan="2" class="align-middle">NAMA</th>
            <th rowspan="2" class="align-middle">JABATAN</th>
            <th colspan="{{ count($kafalah) }}" class="text-center align-middle">KAFALAH</th>
            <th colspan="{{ count($potongan) }}" class="text-center align-middle">POTONGAN</th>
            <th colspan="3" class="text-center align-middle">TOTAL</th>
        </tr>
        <tr>
            @foreach ($kafalah as $item)
                <th class="text-center align-middle font-weight-normal">{{ $item->nama }}</th>
            @endforeach
            @foreach ($potongan as $item)
                <th class="text-center align-middle font-weight-normal">{{ $item->nama }}</th>
            @endforeach
            <th class="text-center align-middle font-weight-normal">KAFALAH</th>
            <th class="text-center align-middle font-weight-normal">POTONGAN</th>
            <th class="text-center align-middle font-weight-normal">BERSIH</th>
        </tr>
    </thead>
    <tbody>
        @php
            $colCount = count($kafalah) + count($potongan);
        @endphp
        @forelse ($data as $row)
            <tr>
                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                <td class="align-middle font-weight-bold">{{ $row->pegawai->nama }}</td>
                <td class="align-middle font-weight-semibold">{{ $row->jabatan ?? '-' }}</td>
                @foreach ($kafalah as $item)
                    <td class="text-right align-middle">
                        @isset($row->kafalah[$item->nama])
                            Rp{{ number_format($row->kafalah[$item->nama],0,',','.') }}
                        @else
                            Rp0
                        @endisset
                    </td>
                @endforeach
                @foreach ($potongan as $item)
                    <td class="text-right align-middle">
                        @isset($row->potongan[$item->nama])
                            Rp{{ number_format($row->potongan[$item->nama],0,',','.') }}
                        @else
                            Rp0
                        @endisset
                    </td>
                @endforeach
                <td class="text-right align-middle font-weight-bold">
                    Rp{{ number_format($row->total_pemasukan,0,',','.') }}
                </td>
                <td class="text-right align-middle font-weight-bold">
                    Rp{{ number_format($row->total_potongan,0,',','.') }}
                </td>
                <td class="text-right align-middle font-weight-bold">
                    Rp{{ number_format($row->total_bersih,0,',','.') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ $colCount + 6 }}" class="text-center">Data tidak ditemukan. Silakan pilih bulan atau tahun lain.</td>
            </tr>
        @endforelse
        <tr class="bg-primary font-weight-bold text-white text-center">
            <td colspan="3">TOTAL</td>
            <td colspan="{{ $colCount }}"></td>
            <td>Rp{{ number_format($data->sum('total_pemasukan'),0,',','.') }}</td>
            <td>Rp{{ number_format($data->sum('total_potongan'),0,',','.') }}</td>
            <td>Rp{{ number_format($data->sum('total_bersih'),0,',','.') }}</td>
        </tr>
    </tbody>
</table>
