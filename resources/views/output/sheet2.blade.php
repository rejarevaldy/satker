<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>% Realisasi</th>
            <th>% Volume RO</th>
        </tr>
        @php
            $index = 1;
            $query = [];
            foreach ($data as $key => $item) {
                $datas = $item->oneinput()->all();
                // Chart Anggaran
                $allPagu = [];
                $allRP = [];
            
                // Chart Output
                $allTarget = [];
                $allRP2 = [];
            
                // Loop data and push to an empty array above
                foreach ($datas as $data) {
                    array_push($allPagu, $data['pagu']);
                    array_push($allRP, $data['rp']);
                    array_push($allTarget, $data['volume_target']);
                    array_push($allRP2, $data['volume_jumlah']);
                }
            
                // Result Chart Anggaran
                if ($allPagu and $allRP) {
                    $resultPagu = array_sum($allPagu);
                    $resultRP = array_sum($allRP);
            
                    // Result Percentage Pie Chart Anggaran
                    $percentage = ($resultRP / $resultPagu) * 100;
                    $resultPercentage = number_format(floor($percentage * 100) / 100, 1, '.', '');
                } else {
                    $resultPagu = 0;
                    $resultRP = 0;
                    $resultPercentage = 0;
                }
            
                // Result Chart Output
                if ($allTarget and $allRP2) {
                    $resultTarget = array_sum($allTarget);
                    $resultRP2 = array_sum($allRP2);
            
                    // Result Percentage Pie Chart Output
                    $percentage2 = ($resultRP2 / $resultTarget) * 100;
                    $resultPercentage2 = number_format(floor($percentage2 * 100) / 100, 2, '.', '');
                } else {
                    $resultTarget = 0;
                    $resultRP2 = 0;
                    $resultPercentage2 = 0;
                }

                $query[] = [$index, "$item->nama", "$item->username", "$resultPercentage", "$resultPercentage2"];
                $index++;
            }
        @endphp
        
        @foreach ($query as $item)
            <tr>
                @foreach ($item as $x)
                    <td>{{ $x }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>
</html>