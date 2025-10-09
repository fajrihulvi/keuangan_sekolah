@php
    Carbon\Carbon::setLocale('id');
@endphp
<!DOCTYPE html>
<html>

<head>
    <title>LAPORAN GAJI {{ Carbon\Carbon::createFromDate(null, $_GET['bulan'], null)->getTranslatedMonthName() }} {{ $_GET['tahun'] }}</title>
    <link rel="stylesheet" href="{{ asset('asset_admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }} ">
</head>

<body>

    <center>
        <h4>LAPORAN GAJI {{ Carbon\Carbon::createFromDate(null, $_GET['bulan'], null)->getTranslatedMonthName() }} {{ $_GET['tahun'] }}</h4>
    </center>

    <table style="width: 40%" class="mb-4 font-weight-bold">
        <tr>
            <td width="30%">BULAN</td>
            <td width="5%" class="text-center">:</td>
            <td>{{ Carbon\Carbon::createFromDate(null, $_GET['bulan'], null)->getTranslatedMonthName() }}</td>
        </tr>
        <tr>
            <td width="30%">TAHUN</td>
            <td width="5%" class="text-center">:</td>
            <td>{{ $_GET['tahun'] }}</td>
        </tr>
    </table>

    <br>

    @include('app.exports.template-gaji')

</body>

</html>
