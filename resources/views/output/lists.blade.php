@extends('adminlte::page')

@section('title', 'Rekap')

@section('content_header')
@stop

@php
$heads = [['label' => 'ID', 'width' => 1], 'Nama', 'Username', 'Bidang', ['label' => 'Opsi', 'width' => 10]];

$query = [];
foreach ($data as $key => $item) {
    $dataUsername = $item->username;
    $dataName = $item->nama;

    $btnDetails =
        '<a href=" ' .
        route('rekap', $item) .
        '" class="btn btn-primary btn-xs ">
                        <i class="fa fa-fw fa-info"></i>Rekap</a>';

    $query[] = [$item->id, $item->nama, $item->username, $item->role, $btnDetails];
}

$config = [
    'data' => $query,
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['className' => 'text-center']],
];
@endphp

@section('content')
    <div class="row pt-3">
        <div class="col-md">
            <x-adminlte-card theme="success" theme-mode="outline">
                <h2 class="mb-2 mb-2"> Monitoring Realisasi Dan Capaian Output Tahun {{ session('year') }}
                </h2>
                <div class="p-2 rounded bg-white">
                    <div class="row">
                        <div class="col-sm">
                            <a href="" class="text-white text-decoration-none">
                                <button class="px-4 py-2 btn btn-success fw-bold btn-sm"><i class="far fa-file-excel"></i>
                                    <div class="d-none d-sm-inline  p-3">Excel
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-2 rounded bg-white">
                    <div class="row">
                        <table id="datatable" class="table table-bordered " style="width:100%">
                            <thead>
                                <tr style="background-color: #EDECEC">
                                    <th rowspan="2" style="width: 1%" class="text-center">No</th>
                                    <th rowspan="2" style="width: 1%" class="text-center">Bidang</th>
                                    <th colspan="4" class="text-center">Anggaran</th>
                                    <th colspan="3" class="text-center">Output</th>
                                </tr>
                                <tr style="background-color: #EDECEC">
                                    <th class="text-center">Pagu</th>
                                    <th class="text-center">Realisasi</th>
                                    <th class="text-center">Sisa</th>
                                    <th class="text-center" style="1%">%</th>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Realisasi</th>
                                    <th class="text-center">%</th>
                                </tr>

                            </thead>
                            <tbody>
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

                            </tbody>
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
                    </div>
                </div>
            </x-adminlte-card>

        </div>
    </div>
    @if (session('success'))
        <div class="row">
            <div class="col-md">
                <x-adminlte-alert theme="success" title="Success" dismissable>
                    {{ session('success') }}
                </x-adminlte-alert>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md">
            <x-adminlte-card theme="primary" theme-mode="outline">
                <x-adminlte-datatable id="table1" :heads="$heads" hoverable bordered>
                    @foreach ($config['data'] as $row)
                        <tr>
                            @foreach ($row as $cell)
                                <td>{!! $cell !!}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop
