@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
    <div class="container-fluid pt-3">
        <div class="row">
            @foreach ($panduans as $panduan)
                <div class="col-md-3">
                    <div class="card" style="height: 90%;">
                        <div class="card-header pt-3" style="min-height: 5.3rem">
                            <h5>{{ $panduan->nama }}</h5>
                        </div>
                        <div class="card-body p-3">
                            <a href="{{ asset('files/panduan') . '/' . $panduan->file }}" class="btn btn-primary btn-sm"
                                target="_blank" download>
                                <i class="fas fa-download me-1"></i>
                                Unduh @if ($panduan->nama != 'Usulan Rencana Kerja')
                                PDF @else Excel
                                @endif </a>
                            <!-- Button trigger modal -->
                            @if(auth()->user()->role == 'Monitoring')
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                data-target="#editPanduan_{{ $panduan->id }}"><i class="fas fa-upload me-1"></i>
                                Unggah @if ($panduan->nama != 'Usulan Rencana Kerja')
                                PDF @else Excel
                                @endif </button>
                            @endif
                            @if ($panduan->nama == 'Usulan Rencana Kerja')
                                @if(auth()->user()->role == 'Monitoring')
                                <button type="button" class="btn btn-sm btn-primary mt-md-1" data-toggle="modal" data-target="#URK"><i class="fas fa-list "></i>
                                @elseif(auth()->user()->role == 'Satker')
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#URK"><i class="fas fa-list "></i>
                                @endif
                                    Bidang
                                </button>

                                {{-- Modal Bidang Edit Start --}}
                                <div class="modal fade" id="URK" tabindex="-1" aria-labelledby="URKLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="URKLabel">Usulan Rencana Kerja</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @foreach ($urks as $urk)
                                                    <div class="card mb-3">
                                                        <div class="card-header p-0 pt-2 px-2">
                                                            <h5 class="card-title">Usulan Rencana Kerja
                                                                {{ $urk->bidang }}
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <a href="{{ asset('files/urk') . '/' . $urk->file }}"
                                                                class="btn btn-primary btn-sm" target="_blank" download>
                                                                <i class="fas fa-download me-1"></i>
                                                                Unduh Excel
                                                            </a>
                                                            @if(auth()->user()->role == 'Monitoring')
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                data-target="#editURK_{{ $urk->id }}"
                                                                data-toggle="modal"> <i class="fas fa-upload me-1"></i>
                                                                Unggah Excel</button>
                                                            @endif
                                                            <div class="modal fade" id="editURK_{{ $urk->id }}"
                                                                tabindex="-1" aria-labelledby="editModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="exampleModalLabel">
                                                                                Usulan Rencana Kerja {{ $urk->bidang }}
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form action="{{ route('urk.update', $urk->id) }}"
                                                                            method="POST" id="editForm"
                                                                            enctype="multipart/form-data">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <label for="bidang"
                                                                                            class="form-label">{{ $urk->bidang }}</label>
                                                                                        <div class="mb-3 input-group">
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                id="bidang" name="bidang"
                                                                                                placeholder="{{ $urk->bidang }}"
                                                                                                value="{{ $urk->bidang }} "
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <label for="" class="mb-1">
                                                                                        Unggah
                                                                                        File
                                                                                    </label>
                                                                                    <div class="input-group">
                                                                                        <input value="{{ $urk->file }}"
                                                                                            type="file"
                                                                                            class="form-control"
                                                                                            name="file"
                                                                                            accept="application/vnd.ms-excel">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary btn-sm"
                                                                                    data-dismiss="modal">Kembali</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary btn-sm">Perbarui</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- Modal Bidang Edit End --}}

                            {{-- Modal Edit Start --}}
                            <div class="modal fade" id="editPanduan_{{ $panduan->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('panduan.update', $panduan->id) }}" method="POST"
                                            id="editForm" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="nama" class="form-label">Nama Panduan</label>
                                                        <div class="mb-3 input-group">
                                                            <input type="text" class="form-control" id="nama" name="nama"
                                                                placeholder="{{ $panduan->nama }}"
                                                                value="{{ $panduan->nama }} " disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="" class="mb-1"> Unggah File
                                                    </label>
                                                    <div class="input-group">
                                                        <input value="{{ $panduan->file }}" type="file"
                                                            class="form-control" name="file" accept="application/pdf">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">Kembali</button>
                                                <button type="submit" class="btn btn-primary btn-sm">Perbarui</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal Edit Start --}}
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- endcard --}}
        </div>
    </div>
    {{-- <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-card title="Chart Bar Anggaran" theme="primary" icon="fas fa-chart-bar">
                    <canvas id="chartBarAnggaran" height="200"></canvas>
                </x-adminlte-card>
            </div>
            <div class="col-md-6">
                <x-adminlte-card title="Chart Bar Output" theme="primary" icon="fas fa-chart-bar">
                    <canvas id="chartBarOutput" height="200"></canvas>
                </x-adminlte-card>
            </div>
        </div>
    </div> --}}
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-R/QOHLpV1Ggq22vfDAWYOaMd5RopHrJNMxi8/lJu8Oihwi4Ho4BRFeiMiCefn9rasajKjnx9/fTQ/xkWnkDACg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const dataBarAnggaranRealisasi = [{{ $rpUMUM }}, {{ $rpPPAI }}, {{ $rpPPAII }},
            {{ $rpSKKI }}, {{ $rpPAPK }}
        ]
        const dataBarAnggaranPagu = [{{ $paguUMUM }}, {{ $paguPPAI }}, {{ $paguPPAII }}, {{ $paguSKKI }},
            {{ $paguPAPK }}
        ]
        const dataBarAnggaranSisa = [{{ $sisaUMUM }}, {{ $sisaPPAI }}, {{ $sisaPPAII }}, {{ $sisaSKKI }},
            {{ $sisaPAPK }}
        ]

        const ResultMax = data => {
            return data * 2
        }

        console.log({{ max([$sisaUMUM, $sisaPPAI, $sisaPPAII, $sisaSKKI, $sisaPAPK]) }})

        // setup chart bar group
        const dataGroup = {
            labels: ['UMUM', 'PPA I', 'PPA II', 'SKKI', 'PAPK'],
            datasets: [{
                    label: 'REALISASI',
                    data: dataBarAnggaranRealisasi,
                    backgroundColor: ['rgb(255, 99, 132)'],
                    stack: 'Stack 0',
                    yAxisID: 'percentage'
                },
                {
                    label: 'PAGU',
                    data: dataBarAnggaranPagu,
                    backgroundColor: ['rgb(54, 162, 235)'],
                    stack: 'Stack 1',
                    yAxisID: 'percentage'
                },
                {
                    label: 'SISA',
                    data: dataBarAnggaranSisa,
                    backgroundColor: ['rgb(255, 205, 86)'],
                    stack: 'Stack 2',
                    yAxisID: 'currency'
                },
            ]
        };

        // config chart bar group
        const configGroup = {
            type: 'bar',
            data: dataGroup,
            options: {
                plugins: {
                    title: {
                        display: true
                    },
                },
                responsive: true,
                interaction: {
                    intersect: false,
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    },
                    currency: {
                        type: 'linear',
                        position: 'left',
                        min: 0,
                        max: ResultMax({{ $paguUMUM }}, {{ $paguPPAI }}, {{ $paguPPAII }},
                            {{ $paguSKKI }}, {{ $paguPAPK }}),
                        grid: {
                            display: false
                        }
                    },
                    percentage: {
                        type: 'linear',
                        position: 'right',
                        min: 0,
                        max: ResultMax({{ $paguUMUM }}, {{ $paguPPAI }}, {{ $paguPPAII }},
                            {{ $paguSKKI }}, {{ $paguPAPK }}),
                        grid: {
                            display: false
                        }
                    },
                }
            }
        };

        const chartBarAnggaran = new Chart(
            document.getElementById('chartBarAnggaran'),
            configGroup
        )

        const dataBarOutputRealisasi = [{{ $rp2UMUM }}, {{ $rp2PPAI }}, {{ $rp2PPAII }},
            {{ $rp2SKKI }}, {{ $rp2PAPK }}
        ]
        const dataBarOutputTarget = [{{ $targetUMUM }}, {{ $targetPPAI }}, {{ $targetPPAII }},
            {{ $targetSKKI }}, {{ $targetPAPK }}
        ]

        const dataBarOutput = {
            labels: ['UMUM', 'PPA I', 'PPA II', 'SKKI', 'PAPK'],
            datasets: [{
                    label: 'REALISASI',
                    data: dataBarOutputRealisasi,
                    backgroundColor: ['rgb(255, 99, 132)'],
                    stack: 'Stack 0',
                    yAxisID: 'percentage'
                },
                {
                    label: 'TARGET',
                    data: dataBarOutputTarget,
                    backgroundColor: ['rgb(54, 162, 235)'],
                    stack: 'Stack 1',
                    yAxisID: 'percentage'
                }
            ]
        };

        const configBarOutput = {
            type: 'bar',
            data: dataBarOutput,
            options: {
                plugins: {
                    title: {
                        display: true
                    },
                },
                responsive: true,
                interaction: {
                    intersect: false,
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    },
                    currency: {
                        type: 'linear',
                        position: 'left',
                        min: 0,
                        max: ResultMax(
                            {{ max([$targetUMUM, $targetPPAI, $targetPPAII, $targetSKKI, $targetPAPK]) }}
                        ),
                        grid: {
                            display: false
                        }
                    },
                    percentage: {
                        type: 'linear',
                        position: 'right',
                        min: 0,
                        max: ResultMax(
                            {{ max([$targetUMUM, $targetPPAI, $targetPPAII, $targetSKKI, $targetPAPK]) }}
                        ),
                        grid: {
                            display: false
                        }
                    },
                }
            }
        };

        const chartBarOutput = new Chart(
            document.querySelector('#chartBarOutput'),
            configBarOutput
        )
    </script>
@stop
