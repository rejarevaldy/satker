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
                                    <th rowspan="2" style="width: 9%" class="text-center"></th>
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
                                    <td>Semua Data</td>
                                    <td>Rp. {{ number_format($pagu, 0, '.', '.') }}</td>
                                    <td>Rp. {{ number_format($rp, 0, '.', '.') }}</td>
                                    <td>Rp. {{ number_format($pagu - $rp, 0, '.', '.') }}</td>
                                    <td>{{ $percentage }} % </td>
                                    <td>{{ $target }}</td>
                                    <td>{{ $rp2 }}</td>
                                    <td>{{ $percentage2 }} % </td>
                                </tr>
                            </tbody>
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
