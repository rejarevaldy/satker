@php
$heads = [['label' => 'No', 'width' => 1], ['label' => 'Digit', 'width' => 5], ['label' => 'KD KRO', 'width' => 5], ['label' => 'KD RO', 'width' => 5], ['label' => 'Bidang', 'width' => 10], 'Nama Ro', 'Capaian Ro', ['label' => 'Target', 'width' => 10], ['label' => 'Satuan', 'width' => 10], 'Jumlah Volume', ['label' => '%', 'width' => 1], ['label' => 'Opsi', 'no-export' => true, 'width' => 5]];
$query = [];
$loop = 1;
// @dd($datas);
foreach ($datas as $data) {
    $dataId = $data->id;
    $dataNama = $data->nama;
    $btnDetail =
        '<a href=' .
        route('laporan.show', $data) .
        '><button class="btn btn-xs btn-primary mx-1 shadow-sm" title="Detail">
                <i class="fa fa-fw fa-info"></i> Detail
            </button> </a>';

    $percent = round($data->volume_jumlah / $data->volume_target, 2) * 100 . ' %';

    $query[] = [$loop, $data->digit, $data->kd_kro, $data->kd_ro, $data->bidang, $data->nama_ro, $data->capaian_ro, $data->volume_target, $data->satuan, $data->volume_jumlah, $percent, '<nobr>' . $btnDetail . '</nobr>'];
    // @dd($dataId);
    $loop++;
}
$config = [
    'data' => $query,
    'order' => [[0, 'asc']],
    'columns' => [['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center']],
    'language' => ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'],
];

@endphp

@extends('adminlte::page')

@section('title', 'Dashboard')

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
                                <a href="{{ route('laporan.create') }}" class="text-white text-decoration-none">
                                    <button class="px-4 py-2 btn btn-primary fw-bold btn-sm"><i class="fas fa-plus"></i>
                                        <div class="d-none d-sm-inline  p-3">Tambah
                                    </button>
                                </a>
                                <a href="" class="text-white text-decoration-none">
                                    <button class="px-4 py-2 btn btn-success fw-bold btn-sm"><i
                                            class="far fa-file-excel"></i>
                                        <div class="d-none d-sm-inline  p-3">Excel
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Col End --}}

                <div class="row">
                    <div class="col-12">
                        <x-adminlte-card title="Daftar Ruangan" theme="success" theme-mode="outline">
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
