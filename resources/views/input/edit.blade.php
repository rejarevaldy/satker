@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
    <div class="pt-3"></div>

    @if (session('status'))
        <x-adminlte-alert class="bg-teal" dismissable>
            {{ session('status') }}
        </x-adminlte-alert>
    @endif


    <x-adminlte-card title="Sunting Laporan" theme="primary" theme-mode="outline">
        <form action="{{ route('laporan.update', $data) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-lg-4">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            Nama RO</label>
                        <div class="input-group">
                            <input value="{{ $data->nama_ro }}" placeholder="{{ $data->nama_ro }}" class="form-control"
                                name="nama_ro">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            Capaian Ro</label>
                        <div class="input-group">
                            <input value="{{ $data->capaian_ro }}" placeholder="{{ $data->capaian_ro }}"
                                class="form-control" name="capaian_ro">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="mb-4 input-group">
                        <label for="" class="mb-1 fw-bold"><span class="text-danger">*</span>
                            Bagian/Bidang
                        </label>
                        <div class="input-group">
                            <select class="custom-select" id="inputGroupSelect01" name="bidang" required>
                                @foreach ($bidangs as $bidang)
                                    @if ($data->bidang == $bidang)
                                        <option value="{{ $data->bidang }}" selected>
                                            {{ $data->bidang }}
                                        </option>
                                    @else
                                        <option value="{{ $bidang }}">
                                            {{ $bidang }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="mb-4 input-group">
                        <label for="" class="mb-1 fw-bold"><span class="text-danger">*</span>
                            Satuan
                        </label>
                        <div class="input-group">
                            <select class="custom-select" id="inputGroupSelect01" name="satuan" required>
                                @foreach ($satuans as $satuan)
                                    @if ($data->satuan == $satuan)
                                        <option value="{{ $data->satuan }}" selected>
                                            {{ $data->satuan }}
                                        </option>
                                    @else
                                        <option value="{{ $satuan }}">
                                            {{ $satuan }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            Pagu</label>
                        <div class="input-group">
                            <input type="text" value="{{ $data->pagu }}" placeholder="{{ $data->pagu }}"
                                class="form-control" name="pagu" id="rupiah">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            RP</label>
                        <div class="input-group">
                            <input type="text" value="{{ $data->rp }}" placeholder="{{ $data->rp }}"
                                class="form-control" name="rp" id="rupiah2">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            ID</label>
                        <div class="input-group">
                            <input value="{{ $data->digit }}" placeholder="{{ $data->digit }}" class="form-control"
                                name="digit">
                        </div>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            KD KRO</label>
                        <div class="input-group">
                            <input value="{{ $data->kd_kro }}" placeholder="{{ $data->kd_kro }}"
                                class="form-control" name="kd_kro">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            KD RO</label>
                        <div class="input-group">
                            <input value="{{ $data->kd_ro }}" placeholder="{{ $data->kd_ro }}" class="form-control"
                                name="kd_ro">
                        </div>
                    </div>
                </div>


                <div class="col-lg-3">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            Target Volume</label>
                        <div class="input-group">
                            <input type="number" value="{{ $data->volume_target }}"
                                placeholder="{{ $data->volume_target }}" class="form-control" name="volume_target">
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            Jumlah Volume</label>
                        <div class="input-group">
                            <input type="number" value="{{ $data->volume_jumlah }}"
                                placeholder="{{ $data->volume_jumlah }}" class="form-control" name="volume_jumlah">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                    <div class="div">
                        <a class="text-secondary text-secondary-hover d-none d-sm-inline text-decoration-none"
                            href="{{ route('laporan.show', $data) }}">
                            <button type="button" class="px-4 py-2 mt-3 btn btn-secondary btn-sm fw-bold"><i
                                    class="fas fa-caret-square-left"></i>
                                Kembali
                            </button>
                        </a>
                    </div>
                    <div class="div">
                        <button type="reset" class="px-4 py-2 mt-3 btn btn-danger btn-sm fw-bold" value="reset"><i
                                class="fas fa-undo"></i>
                            <div class="d-none d-sm-inline"> Reset</div>
                        </button>
                        <button type="submit" class="px-4 py-2 mt-3 btn btn-primary btn-sm fw-bold"><i
                                class="fas fa-edit"></i>
                            <div class="d-none d-sm-inline"> Perbarui</div>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Form End -->
    </x-adminlte-card>


@stop

@section('css')
    <link rel=" stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        var rupiah = document.getElementById('rupiah');
        rupiah.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah.value = formatRupiah(this.value, 'Rp. ');
        });
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
        var rupiah2 = document.getElementById('rupiah2');
        rupiah2.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah2.value = formatRupiah(this.value, 'Rp. ');
        });
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah2 = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah2 += separator + ribuan.join('.');
            }
            rupiah2 = split[1] != undefined ? rupiah2 + ',' + split[1] : rupiah2;
            return prefix == undefined ? rupiah2 : (rupiah2 ? 'Rp. ' + rupiah2 : '');
        }
    </script>
@stop