@php
use Illuminate\Support\Carbon;
Carbon::setLocale('id');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SLIP GAJI {{ $data->pegawai->nama }} - {{ Carbon::create()->month(request()->month)->translatedFormat('F') }} {{request()->tahun }}</title>
    
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 9pt; 
            line-height: 1.3;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        
        @page {
            size: A4 portrait;
            margin: 10mm;
        }
        
        @media print {
            body * { visibility: hidden; }
            .printable-area, .printable-area * { visibility: visible; }
            .printable-area { position: absolute; left: 0; top: 0; width: 100%; }
            .slip-container {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                gap: 5mm; 
            }
            
            .slip-gaji {
                width: calc(50% - 2.5mm);
                height: 100%;
                box-sizing: border-box;
                padding: 4mm;
            }
        }
        
        .slip-gaji {
            .kw-nav { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid black; padding-bottom: 5px; }
            .kw-nav img { max-height: 50px; } /* Logo diperkecil */
            .kw-header { text-align: center; }
            .kw-header h3 { font-size: 10pt; margin: 0; line-height: 1.2; }
            .kw-header p { font-size: 7pt; margin: 0; }
            .kw-title { text-align: center; margin-top: 10px; margin-bottom: 10px; text-decoration: underline; font-size: 12pt; }
            .table { width: 100%; border-collapse: collapse; }
            .table-borderless td { border: none; padding: 1px; }
            .line-divider { border-top: 1px solid #7d7e7f; }
            .font-weight-bold { font-weight: bold; }
            .text-red { color: red; }
            .text-center { text-align: center; }
            .w-100 { width: 100%; }
            .my-4 { margin-top: 0.8rem; margin-bottom: 0.8rem; }
            .d-flex { display: flex; }
            .flex-column { flex-direction: column; }
            .align-items-center { align-items: center; }
            .align-items-end { align-items: flex-end; }
            .justify-content-center { justify-content: center; }
            .mr-8 { margin-right: 1rem; }
            .col-4, .col-8 { box-sizing: border-box; }
            .col-4 { width: 40%; padding: 0 2px;} /* Proporsi diubah agar lebih fleksibel */
            .col-8 { width: 60%; padding: 0 2px;}
            .row { display: flex; width: 100%; }
        }
    </style>
</head>
<body>

    <div class="printable-area">
        <div class="slip-container">
            <div class="slip-gaji">
                @include('app.gaji.print')
            </div>
    
            <div class="slip-gaji">
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>