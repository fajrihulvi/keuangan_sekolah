<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>LAPORAN KEUANGAN {{ $tahun }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px; text-align: left; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; }
        .header-section {
            font-weight: bold;
            background-color: #f2f2f2;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h2>LAPORAN KEUANGAN {{ $tahun }}</h2>

    <!-- Bagian Pendapatan -->
    <table>
        <tr class="header-section">
            <td colspan="2">PENDAPATAN</td>
        </tr>
        @foreach($incomeData as $item)
        <tr>
            <td>{{ $item['label'] }}</td>
            <td class="text-right">{{ $item['formatted'] }}</td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td>TOTAL SALDO</td>
            <td class="text-right">{{ $incomeTotal }}</td>
        </tr>
    </table>

    <!-- Bagian Pengeluaran -->
    <table>
        <tr class="header-section">
            <td colspan="2">PENGELUARAN</td>
        </tr>
        @foreach($expenseData as $item)
        <tr>
            <td>{{ $item['label'] }}</td>
            <td class="text-right">{{ $item['formatted'] }}</td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td>TOTAL PENGELUARAN</td>
            <td class="text-right">{{ $expenseTotal }}</td>
        </tr>
    </table>
</body>
</html>
