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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-card title="5 Realisasi Tertinggi" theme="primary" icon="fas fa-chart-bar" collapsible>
                    <canvas id="chartBarTopMaxRP" height="200"></canvas>
                </x-adminlte-card>
            </div>
            <div class="col-md-6">
                <x-adminlte-card title="5 Realisasi Terendah" theme="primary" icon="fas fa-chart-bar" collapsible>
                    <canvas id="chartBarTopMinRP" height="200"></canvas>
                </x-adminlte-card>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-card title="5 Output Tertinggi" theme="primary" icon="fas fa-chart-bar" collapsible>
                    <canvas id="chartBarMaxOutput" height="200"></canvas>
                </x-adminlte-card>
            </div>
            <div class="col-md-6">
                <x-adminlte-card title="5 Output Terendah" theme="primary" icon="fas fa-chart-bar" collapsible>
                    <canvas id="chartBarMinOutput" height="200"></canvas>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-R/QOHLpV1Ggq22vfDAWYOaMd5RopHrJNMxi8/lJu8Oihwi4Ho4BRFeiMiCefn9rasajKjnx9/fTQ/xkWnkDACg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const ResultMax = data => {
            return data * 2
        }
    </script>
    @php
        // max
        $max1 = $topMax[0];
        $max2 = $topMax[1];
        $max3 = $topMax[2];
        $max4 = $topMax[3];
        $max5 = $topMax[4];

        // min
        $min1 = $topMin[0];
        $min2 = $topMin[1];
        $min3 = $topMin[2];
        $min4 = $topMin[3];
        $min5 = $topMin[4];

        // max output
        $maxoutput1 = $topMaxOutput[0];
        $maxoutput2 = $topMaxOutput[1];
        $maxoutput3 = $topMaxOutput[2];
        $maxoutput4 = $topMaxOutput[3];
        $maxoutput5 = $topMaxOutput[4];

        // min output
        $minoutput1 = $topMinOutput[0];
        $minoutput2 = $topMinOutput[1];
        $minoutput3 = $topMinOutput[2];
        $minoutput4 = $topMinOutput[3];
        $minoutput5 = $topMinOutput[4];
    @endphp

    {{-- TOP 5 MAX RP --}}
    <script>
        const dataBarMax5RP = [{{ $max1 }}, {{ $max2 }}, {{ $max3 }}, {{ $max4 }}, {{ $max5 }}];
        const maxLabel = ['{{ $usermax1 }}', '{{ $usermax2 }}', '{{ $usermax3 }}', '{{ $usermax4 }}', '{{ $usermax5 }}'];
        const dataBarMaxRp = {
            labels: maxLabel,
            datasets: [{
                    label: 'REALISASI %',
                    data: dataBarMax5RP,
                    backgroundColor: ['rgb(255, 99, 132)'],
                    yAxisID: 'percentage'
                }
            ]
        };

        const configBarTopMaxRP = {
            type: 'bar',
            data: dataBarMaxRp,
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
                        max: 100,
                        grid: {
                            display: false
                        }
                    },
                    percentage: {
                        type: 'linear',
                        position: 'right',
                        min: 0,
                        max: 100,
                        grid: {
                            display: false
                        }
                    },
                }
            }
        };

        const chartBarTopMaxRP = new Chart(
            document.querySelector('#chartBarTopMaxRP'),
            configBarTopMaxRP
        )
    </script>
    
    {{-- TOP 5 MIN RP --}}
    <script>
        const dataBarMin5RP = [{{ $min1 }}, {{ $min2 }}, {{ $min3 }}, {{ $min4 }}, {{ $min5 }}];
        const minLabel = ['{{ $usermin1 }}', '{{ $usermin2 }}', '{{ $usermin3 }}', '{{ $usermin4 }}', '{{ $usermin5 }}'];
        const dataBarMinRp = {
            labels: minLabel,
            datasets: [{
                    label: 'REALISASI %',
                    data: dataBarMin5RP,
                    backgroundColor: ['rgb(255, 99, 132)'],
                    yAxisID: 'percentage'
                }
            ]
        };

        const configBarTopMinRP = {
            type: 'bar',
            data: dataBarMinRp,
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
                        max: 100,
                        grid: {
                            display: false
                        }
                    },
                    percentage: {
                        type: 'linear',
                        position: 'right',
                        min: 0,
                        max: 100,
                        grid: {
                            display: false
                        }
                    },
                }
            }
        };

        const chartBarTopMinRP = new Chart(
            document.querySelector('#chartBarTopMinRP'),
            configBarTopMinRP
        )
    </script>

    {{-- TOP 5 MAX OUTPUT --}}
    <script>
        const dataBarMaxOutput = [{{ $maxoutput1 }}, {{ $maxoutput2 }}, {{ $maxoutput3 }}, {{ $maxoutput4 }}, {{ $maxoutput5 }}];
        const maxLabelOutput = ['{{ $usermaxoutput1 }}', '{{ $usermaxoutput2 }}', '{{ $usermaxoutput3 }}', '{{ $usermaxoutput4 }}', '{{ $usermaxoutput5 }}'];
        const dataMaxOutput = {
            labels: maxLabelOutput,
            datasets: [{
                    label: 'CAPUT %',
                    data: dataBarMaxOutput,
                    backgroundColor: ['rgb(255, 99, 132)'],
                    yAxisID: 'percentage'
                }
            ]
        };

        const configBarTopMaxOutput = {
            type: 'bar',
            data: dataMaxOutput,
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
                        max: 100,
                        grid: {
                            display: false
                        }
                    },
                    percentage: {
                        type: 'linear',
                        position: 'right',
                        min: 0,
                        max: 100,
                        grid: {
                            display: false
                        }
                    },
                }
            }
        };

        const chartBarTopMaxOutput = new Chart(
            document.querySelector('#chartBarMaxOutput'),
            configBarTopMaxOutput
        )
    </script>

    {{-- TOP 5 MIN OUTPUT --}}
    <script>
        const dataBarMinOutput = [{{ $minoutput1 }}, {{ $minoutput2 }}, {{ $minoutput3 }}, {{ $minoutput4 }}, {{ $minoutput5 }}];
        const minLabelOutput = ['{{ $userminoutput1 }}', '{{ $userminoutput2 }}', '{{ $userminoutput3 }}', '{{ $userminoutput4 }}', '{{ $userminoutput5 }}'];
        const dataMinOutput = {
            labels: minLabelOutput,
            datasets: [{
                    label: 'CAPUT %',
                    data: dataBarMinOutput,
                    backgroundColor: ['rgb(255, 99, 132)'],
                    yAxisID: 'percentage'
                }
            ]
        };

        const configBarTopMinOutput = {
            type: 'bar',
            data: dataMinOutput,
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
                        max: 100,
                        grid: {
                            display: false
                        }
                    },
                    percentage: {
                        type: 'linear',
                        position: 'right',
                        min: 0,
                        max: 100,
                        grid: {
                            display: false
                        }
                    },
                }
            }
        };

        const chartBarTopMinOutput = new Chart(
            document.querySelector('#chartBarMinOutput'),
            configBarTopMinOutput
        )
    </script>
@stop
