@extends('adminlte::page')

@section('title', 'Detail')

@section('content_header')

@stop

@section('content')
    <div class="container-fluid pt-3">
        <div class="row">
            <div class="col-12">
                <div class="p-4 mb-4 border rounded shadow-sm bg-white">
                    <h2 class="mb-2">Detail Laporan
                    </h2>
                    <div class="p-2 rounded bg-white">
                        <div class="row">
                            <div class="col-sm">
                                <a href="{{ route('laporan') }}" class="text-decoration-none">
                                    <button class="px-4 py-2 btn btn-secondary fw-bold btn-sm"><i
                                            class="fas fa-caret-square-left"></i>
                                        <div class="d-none d-sm-inline p-3">Kembali</div>
                                    </button>
                                </a>
                                <a href="{{ route('laporan.edit', $data) }}" class="text-decoration-none">
                                    <button class="px-4 py-2 btn btn-success fw-bold btn-sm"><i class="fas fa-edit"></i>
                                        <div class="d-none d-sm-inline p-3">Sunting</div>
                                    </button>
                                </a>
                                <button type="button" class="px-4 py-2 btn btn-danger fw-bold btn-sm" data-toggle="modal"
                                    data-target="#deleteLaporan">
                                    <i class="fas fa-trash"></i>
                                    <div class="d-none d-sm-inline p-3">Hapus</div>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- Col End --}}

                <x-adminlte-card title="Detail Laporan" theme="success" theme-mode="outline">
                    <div class="form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4 form-input">
                                    <label for="" class="mb-1 fw-bold">
                                        Nama RO</label>
                                    <div class="input-group">
                                        <input placeholder="{{ $data->nama_ro }}" class="form-control" name="nama_ro"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4 form-input">
                                    <label for="" class="mb-1 fw-bold">
                                        Capaian Ro</label>
                                    <div class="input-group">
                                        <input placeholder="{{ $data->capaian_ro }}" class="form-control"
                                            name="capaian_ro" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-4 input-group">
                                    <label for="" class="mb-1 fw-bold">
                                        Bagian/Bidang
                                    </label>
                                    <div class="input-group">
                                        <input placeholder="{{ $data->bidang }}" class="form-control" name="capaian_ro"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-4 input-group">
                                    <label for="" class="mb-1 fw-bold">
                                        Satuan
                                    </label>
                                    <div class="input-group">
                                        <input placeholder="{{ $data->satuan }}" class="form-control" name="capaian_ro"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4 form-input">
                                    <label for="" class="mb-1 fw-bold">
                                        Pagu</label>
                                    <div class="input-group">
                                        <input type="number" value="Rp. {{ number_format($data->pagu, 0, '.', '.') }}"
                                            placeholder="Rp. {{ number_format($data->pagu, 0, '.', '.') }}"
                                            class="form-control" name="pagu" id="rupiah" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4 form-input">
                                    <label for="" class="mb-1 fw-bold">
                                        RP</label>
                                    <div class="input-group">
                                        <input type="number" value="Rp. {{ number_format($data->rp, 0, '.', '.') }}"
                                            placeholder="Rp. {{ number_format($data->rp, 0, '.', '.') }}"
                                            class="form-control" name="rp" id="rupiah" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4 form-input">
                                    <label for="" class="mb-1 fw-bold">
                                        Sisa</label>
                                    <div class="input-group">
                                        <input type="number" value="Rp. {{ number_format($data->sisa, 0, '.', '.') }}"
                                            placeholder="Rp. {{ number_format($data->sisa, 0, '.', '.') }}"
                                            class="form-control" name="sisa" id="rupiah" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4 form-input">
                                    <label for="" class="mb-1 fw-bold">
                                        RVO</label>
                                    <div class="input-group">
                                        <input placeholder="{{ $data->rvo * 100 }} %" class="form-control" name=""
                                            disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4 form-input">
                                    <label for="" class="mb-1 fw-bold">
                                        RVO Maksimal</label>
                                    <div class="input-group">
                                        <input placeholder="{{ $data->rvo_maksimal }}" class="form-control" name=""
                                            disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4 form-input">
                                    <label for="" class="mb-1 fw-bold">
                                        Capaian</label>
                                    <div class="input-group">
                                        <input
                                            placeholder="{{ number_format(floor($data->capaian * 100), 2, '.', '') }} % "
                                            class="form-control" name="capaian_ro" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-4 form-input">
                                    <label for="" class="mb-1 fw-bold">
                                        ID</label>
                                    <div class="input-group">
                                        <input placeholder="{{ $data->digit }}" class="form-control" name="digit"
                                            disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-4 form-input">
                                    <label for="" class="mb-1 fw-bold">
                                        KD KRO</label>
                                    <div class="input-group">
                                        <input placeholder="{{ $data->kd_kro }}" class="form-control" name="kd_kro"
                                            disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-4 form-input">
                                    <label for="" class="mb-1 fw-bold">
                                        KD RO</label>
                                    <div class="input-group">
                                        <input placeholder="{{ $data->kd_ro }}" class="form-control" name="kd_ro"
                                            disabled>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="mb-4 form-input">
                                    <label for="" class="mb-1 fw-bold">
                                        Target Volume</label>
                                    <div class="input-group">
                                        <input type="number" placeholder="{{ $data->volume_target }}"
                                            class="form-control" name="volume_target" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-4 form-input">
                                    <label for="" class="mb-1 fw-bold">
                                        Jumlah Volume</label>
                                    <div class="input-group">
                                        <input type="number" placeholder="{{ $data->volume_jumlah }}"
                                            class="form-control" name="volume_jumlah" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Form End -->
                </x-adminlte-card>

                {{-- Modal Hapus --}}
                <div class="modal fade" id="deleteLaporan" tabindex="-1" role="dialog"
                    aria-labelledby="deleteLaporanLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteLaporanLabel">Peringatan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('laporan.destroy', $data) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body">
                                    Apakah anda yakin akan menghapus nya? </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </div>
                            </form>
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
