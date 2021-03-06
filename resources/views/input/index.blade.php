@php

$heads = [['label' => 'No', 'width' => 1], 'Nama', 'Username', ['label' => '% Realisasi', 'width' => 13], ['label' => '% Volume RO', 'width' => 13], ['label' => 'Opsi', 'width' => 10]];

$x = 1;
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

    $dataUsername = $item->username;
    $dataName = $item->nama;

    $btnDetails =
        '<a href="/laporan/' .
        $item->username .
        '" class="btn btn-primary btn-xs ">
                        <i class="fa fa-fw fa-info"></i>Laporan</a>';

    $query[] = [$x, $item->nama, $item->username, $resultPercentage . '%', $resultPercentage2 . '%', $btnDetails];
}
$x++;

$config = [
    'data' => $query,
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, null, null, ['className' => 'text-center']],
];
@endphp


@extends('adminlte::page')

@section('title', 'Laporan')

@section('content_header')

@stop

@section('content')
    <div class="container-fluid pt-3">
        <div class="row">
            <div class="col-12">
                <div class="p-4 mb-4 border rounded shadow-sm bg-white">
                    <h2 class="mb-2">Laporan Realisasi {{ session('year') }} - [{{ Auth()->user()->nama }}]
                    </h2>
                    <div class="p-2 rounded bg-white">
                        <div class="row">
                            <div class="col-sm">
                                @if (auth()->user()->role == 'Satker')
                                    <a href="{{ route('laporan.create') }}" class="text-white text-decoration-none">
                                        <button class="px-4 py-2 btn btn-primary fw-bold btn-sm"><i
                                                class="fas fa-plus"></i>
                                            <div class="d-none d-sm-inline  p-3">Tambah
                                        </button>
                                    </a>
                                    <a href="{{ route('output.excel.table', auth()->user()->id) }}"
                                        class="text-white text-decoration-none">
                                        <button class="px-4 py-2 btn btn-success fw-bold btn-sm"><i
                                                class="far fa-file-excel"></i>
                                            <div class="d-none d-sm-inline  p-3">Excel
                                        </button>
                                    </a>
                                @else
                                    <a href="{{ route('output.excel.table.all') }}"
                                        class="text-white text-decoration-none">
                                        <button class="px-4 py-2 btn btn-success fw-bold btn-sm"><i
                                                class="far fa-file-excel"></i>
                                            <div class="d-none d-sm-inline  p-3">Excel
                                        </button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Col End --}}

                <div class="row">
                    <div class="col-12">
                        <x-adminlte-card title="Daftar Laporan Satker" theme="success" theme-mode="outline">
                            <x-adminlte-datatable id="table" :heads="$heads" head-theme="white" :config="$config" striped
                                hoverable bordered />
                        </x-adminlte-card>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
