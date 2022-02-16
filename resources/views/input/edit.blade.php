@extends('adminlte::page')

@section('title', 'Edit')

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
                <div class="col-lg-1">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            ID</label>
                        <div class="input-group">
                            <input value="{{ $data->digit }}" placeholder="ID" class="form-control" name="digit"
                                required>
                        </div>
                    </div>
                </div>

                <div class="col-lg-1">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            KD KRO</label>
                        <div class="input-group">
                            <input value="{{ $data->kd_kro }}" placeholder="KD KRO" class="form-control" name="kd_kro"
                                required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            KD RO</label>
                        <div class="input-group">
                            <input value="{{ $data->kd_ro }}" placeholder="KD RO" class="form-control" name="kd_ro"
                                required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            Nama Ro</label>
                        <div class="input-group">
                            <input value="{{ $data->nama_ro }}" placeholder="Nama Ro" class="form-control"
                                name="nama_ro" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mb-4 input-group">
                        <label for="" class="mb-1 fw-bold">
                            Satuan Volume
                        </label>
                        <div class="input-group">
                            <input type="text" list="bulan" value="{{ $data->satuan }}" placeholder="Satuan Volume"
                                class="form-control" name="satuan">
                            <datalist id="bulan">
                                <option value="Bulan Layanan">
                            </datalist>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            Target Volume</label>
                        <div class="input-group">
                            <input value="{{ $data->volume_target }}" type="number" value="" placeholder="Target Volume"
                                class="form-control" name="volume_target" required>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            Jumlah Volume</label>
                        <div class="input-group">
                            <input value="{{ $data->volume_jumlah }}" type="number" value="" placeholder="Jumlah Volume"
                                class="form-control" name="volume_jumlah">
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
                            <input value="{{ $data->pagu }}" type="text" value="" placeholder="Pagu"
                                class="form-control" id="rupiah" name="pagu" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-4 form-input">
                        <label for="" class="mb-1 fw-bold">
                            RP</label>
                        <div class="input-group">
                            <input value="{{ $data->rp }}" type="text" value="" placeholder="RP" class="form-control"
                                name="rp" id="rupiah2" required>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                    <div class="div">
                        <a class="text-secondary text-secondary-hover d-none d-sm-inline text-decoration-none"
                            href="{{ route('laporan') }}">
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
