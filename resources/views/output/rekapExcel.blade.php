<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <table class="table-output-excel" border="1">
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Bidang</th>
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
            <td>1</td>
            <td>Umum</td>
            <td>Rp. {{ number_format($paguUMUM, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($rpUMUM, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($paguUMUM - $rpUMUM, 0, '.', '.') }}</td>
            <td>{{ $percentageUMUM }} % </td>
            <td>{{ $targetUMUM }}</td>
            <td>{{ $rp2UMUM }}</td>
            <td>{{ $percentageUMUM2 }} % </td>
        </tr>
    
        <tr>
            <td>2</td>
            <td>PPAI</td>
            <td>Rp. {{ number_format($paguPPAI, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($rpPPAI, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($paguPPAI - $rpPPAI, 0, '.', '.') }}</td>
            <td>{{ $percentagePPAI }} % </td>
            <td>{{ $targetPPAI }}</td>
            <td>{{ $rp2PPAI }}</td>
            <td>{{ $percentagePPAI2 }} % </td>
        </tr>

        <tr>
            <td>3</td>
            <td>PPAII</td>
            <td>Rp. {{ number_format($paguPPAII, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($rpPPAII, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($paguPPAII - $rpPPAII, 0, '.', '.') }}</td>
            <td>{{ $percentagePPAII }} % </td>
            <td>{{ $targetPPAII }}</td>
            <td>{{ $rp2PPAII }}</td>
            <td>{{ $percentagePPAII2 }} % </td>
        </tr>

        <tr>
            <td>4</td>
            <td>SKKI</td>
            <td>Rp. {{ number_format($paguSKKI, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($rpSKKI, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($paguSKKI - $rpSKKI, 0, '.', '.') }}</td>
            <td>{{ $percentageSKKI }} % </td>
            <td>{{ $targetSKKI }}</td>
            <td>{{ $rp2SKKI }}</td>
            <td>{{ $percentageSKKI2 }} % </td>
        </tr>

        <tr>
            <td>5</td>
            <td>PAPK</td>
            <td>Rp. {{ number_format($paguPAPK, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($rpPAPK, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($paguPAPK - $rpPAPK, 0, '.', '.') }}</td>
            <td>{{ $percentagePAPK }} % </td>
            <td>{{ $targetPAPK }}</td>
            <td>{{ $rp2PAPK }}</td>
            <td>{{ $percentagePAPK2 }} % </td>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td>Rp.
                {{ number_format($totalPagu, 0, '.', '.') }}
            </td>
            <td>Rp. {{ number_format($totalRP, 0, '.', '.') }}</td>
            <td>Rp. {{ number_format($totalSisa, 0, '.', '.') }}</td>
            <td>{{ $totalRpPagu }} % </td>
            <td>{{ $totalTarget }}</td>
            <td>{{ $totalRP2 }}</td>
            <td>{{ $totalPercentage }} % </td>
        </tr>
    </table>
</body>
</html>