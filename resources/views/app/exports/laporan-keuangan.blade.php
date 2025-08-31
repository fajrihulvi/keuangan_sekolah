@php
    $totalSisa = 0;
@endphp
<table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th rowspan="2" class="text-center align-middle">NO</th>
                <th rowspan="2" class="align-middle">NAMA SISWA</th>
                @foreach ($kategori as $data)
                    <th class="text-uppercase text-center align-middle">{{ $data['nama'] }}</th>
                @endforeach
                <th class="text-center align-middle">TOTAL</th>
                <th rowspan="2" class="text-center align-middle">SISA</th>
                <th rowspan="2" class="text-center align-middle">KET</th>
            </tr>
            <tr>
                @foreach ($kategori as $data)
                    <th class="text-center align-middle font-weight-normal">{{ 'Rp'.number_format($data['anggaran'],0,',','.') }}</th>
                @endforeach
                <th class="text-center align-middle font-weight-normal">{{ 'Rp'.number_format($totalAnggaran,0,',','.') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $index => $row)
                <tr>
                    <td class="text-center align-middle">{{ ++$index }}</td>
                    <td class="align-middle font-weight-bold">{{ $row->nama_lengkap }}</td>
                    @foreach ($kategori as $data)
                        <td class="text-right align-middle">
                            @isset($transaksi[$row->id][$data['id']][0]->nominal)
                                Rp{{ number_format($transaksi[$row->id][$data['id']][0]->nominal, 0, ',', '.') }}
                            @else
                                -
                            @endisset
                        </td>
                    @endforeach
                    <td class="text-right align-middle font-weight-bold">
                        @isset($grandTotal[$row->id])
                            Rp{{ number_format($grandTotal[$row->id], 0, ',', '.') }}
                        @else
                            -
                        @endisset
                    </td>
                    @php
                        $sisa = $totalAnggaran - $totalAnggaranSiswa[$row->id]['total_biaya'];
                        if($sisa < 0){
                            $isa = 0;
                        }
                        $totalSisa += $sisa;
                    @endphp
                    <td class="text-right align-middle font-weight-bold">{{ $sisa !== 0? 'Rp'.number_format($sisa,0,',','.') : '-' }}</td>
                    <td class="text-right align-middle font-weight-bold">{{ $sisa <= 0 ? "LUNAS" : "BELUM LUNAS" }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2">TOTAL</td>
                @foreach ($kategori as $data)
                    <td>{{ $data['total'] != 0 ? 'Rp'.number_format($data['total'],0,',','.'):'-' }}</td>
                @endforeach
                <td>{{ $totalAnggaranSiswa->sum('total_biaya') !== 0 ? "Rp".number_format($totalAnggaranSiswa->sum('total_biaya'),0,",",".") : '-' }}</td>
                <td colspan="2" class="text-center">{{ $totalSisa >= 0 ? "Rp".number_format($totalSisa,0,",",".") : '-' }}</td>
            </tr>
        </tbody>
    </table>
