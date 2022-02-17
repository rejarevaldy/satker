<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .table-output-excel {
            border-collapse: collapse;
            width: 100%;
        }
        
        .table-output-excel td {
            padding: 15px;
            text-align: center;
            height: 50px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <table class="table-output-excel" border="1">
        <tr>
            <th rowspan="2"></th>
            <th colspan="4">Anggaran</th>
            <th colspan="3">Output</th>
        </tr>
        <tr>
            <th>Pagu</th>
            <th>Realisasi</th>
            <th>Sisa</th>
            <th>%</th>
            <th>Target</th>
            <th>Realisasi</th>
            <th>%</th>
        </tr>

        <tr>
            <td>Semua Data</td>
            <td>Rp. {{ number_format($pagu, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($rp, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($sisa, 0, '.', '.') }}</td>
            <td>{{ number_format($percentage, 0, '.', '.') }}%</td>
            <td>Rp. {{ number_format($target, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($rp2, 0, '.', '.') }}</td>
            <td>{{ number_format($percentage2, 0, '.', '.') }}%</td>
        </tr>
    </table>
</body>
</html>