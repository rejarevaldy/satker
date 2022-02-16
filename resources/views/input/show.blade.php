@php
$heads = [['label' => 'No', 'width' => 1], ['label' => 'Nama RO', 'width' => 30], ['label' => 'Volume Capaian', 'width' => 30], ['label' => 'Uraian', 'width' => 30], ['label' => 'Nomor Dokumen', 'width' => 8], ['label' => 'Tanggal', 'width' => 8], ['label' => 'File', 'width' => 8]];
if (auth()->user()->role == 'Satker') {
$heads[] =  ['label' => 'Opsi', 'no-export' => true, 'width' => 5];
}
$query = [];
$loop = 1;
// @dd($datas);


foreach ($datas2 as $data2) {
    if ($data2->file == NULL) {
        $file = '<i class="text-muted">Tidak ada file</i>';
    } else {
        $file = '<a href="'.asset('files').'/'.$data2->file.'">'.$data2->file.'</a>';
        // $file = '<a href="'.asset('files').'/'.$data2->file.'" class="btn btn-primary btn-xs">Unduh</a>';
    };

    $serekshon = [];

    foreach ($selection as $select) {
        if ($select->id == $data2->one_input_id) {
            $serekshon[] = '<option selected value="'.$select->id.'">'.$select->nama_ro.'</option>';
        } else
        {
            $serekshon[] = '<option value="'.$select->id.'">'.$select->nama_ro.'</option>';
        }
    }

    $serekshon = implode(' ', $serekshon);

    // dd($serekshon);

    $tanggal = \Carbon\Carbon::parse($data2->tanggal)->format('d-m-Y');
    $tanggal_input = \Carbon\Carbon::parse($data2->tanggal)->format('Y-m-d');

    if (auth()->user()->role == 'Satker') {
        $btnEdit = '<button class="btn btn-xs btn-success mx-1 shadow-sm" title="Edit" data-toggle="modal" data-target="#modalSunting_'.$data2->id.'">
                    <i class="fa fa-fw fa-pen"></i> Edit
                </button>';
        $btnDelete = '<button class="btn btn-xs btn-danger mx-1 shadow-sm" title="Hapus" data-toggle="modal" data-target="#modalHapus_'.$data2->id.'">
                      <i class="fa fa-fw fa-trash"></i> Hapus
                  </button>';
        $mdlEdit = '<div class="modal fade" id="modalSunting_'.$data2->id.'" tabindex="-1" aria-labelledby="modalSuntingLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSuntingLabel">Edit Ruangan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="'.route("edit.dokumen", $data2->id).'" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="'.csrf_token().'" />
                        <div class="row">
                            <div class="col">
                                <label for="uraian" class="form-label">Uraian</label>
                                <div class="mb-3 input-group">
                                    <input type="text" class="form-control" id="uraian"
                                        name="uraian" placeholder="Masukkan Uraian"
                                        value="'.$data2->uraian.'">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="nodok" class="form-label">Nomor Dokumen</label>
                                <div class="mb-3 input-group">
                                    <input type="text" class="form-control" id="nodok"
                                        name="nodok" placeholder="Masukkan Nomor Dokumen"
                                        value="'.$data2->nomor_dokumen.'">
                                </div>
                            </div>
                            <div class="col">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <div class="mb-3 input-group">
                                    <input type="date" class="form-control" id="tanggal"
                                        name="tanggal" placeholder="Masukkan Tanggal"
                                        value="'.$tanggal_input.'">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="naro" class="form-label">Nama RO</label>
                                <div class="mb-3 input-group">
                                    <select type="select" class="form-control" id="naro"
                                        name="naro" required>
                                        '.$serekshon.'
                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="volcap" class="form-label">Volume Capaian</label>
                            <div class="mb-3 input-group">
                                <input type="number" class="form-control" id="volcap"
                                    name="volcap" placeholder="Masukkan Volume Capaian"
                                    value="'.$data2->volume_capaian.'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="file" class="mb-1"> Upload File</label>
                            <div class="mb-3 input-group">
                                <input value="'.$data2->file.'" type="file" class="form-control"
                                    name="file">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="mr-auto px-3 py-1 btn btn-secondary btn-sm"
                                data-bs-dismiss="modal" data-dismiss="modal">Batal</button>
                            <button type="submit" class="px-3 py-1 btn btn-success btn-sm">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
        $mdlDelete = '<div class="modal fade" id="modalHapus_'.$data2->id.'" tabindex="-1" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Hapus Dokumen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus '.$data2->uraian.'?
                    </div>
                    <div class="modal-footer">
                        <form action="'.route("destroy.dokumen", $data2->id).'" method="POST">
                            <input type="hidden" name="_method" value="DELETE" />
                            <input type="hidden" name="_token" value="'.csrf_token().'" />
                            <button type="button" class="mr-auto px-3 py-1 btn btn-secondary btn-sm"
                                data-bs-dismiss="modal" data-dismiss="modal">Tidak</button>
                            <button type="submit" class="px-3 py-1 btn btn-danger btn-sm">Ya</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
    }

        if (auth()->user()->role == 'Satker') {
            $query[] = [$loop, $data2->oneInput->nama_ro, $data2->volume_capaian, $data2->uraian, $data2->nomor_dokumen, $tanggal, $file, '<nobr>' .$btnEdit.$btnDelete. '</nobr>'];
            // $query[] =  ['<nobr>' .$btnEdit.$btnDelete. '</nobr>'];
            // array_push($query, );
            // dd($query);
            echo($mdlEdit);
            echo($mdlDelete);
        } else {
            $query[] = [$loop, $data2->oneInput->nama_ro, $data2->volume_capaian, $data2->uraian, $data2->nomor_dokumen, $tanggal, $file];
        }
        // @dd($dataId);
        $loop++;


    if (auth()->user()->role == 'Monitoring') {
        $config = [
        'data' => $query,
        'order' => [[0, 'asc']],
        'columns' => [['className' => 'text-center'],['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center']],
        'language' => ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'],
    ];
    } elseif (auth()->user()->role == 'Satker') {
        $config = [
        'data' => $query,
        'order' => [[0, 'asc']],
        'columns' => [['className' => 'text-center'],['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center']],
        'language' => ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'],
    ];
    } else {
        $config = [];
    }
}

@endphp

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
                                @if (auth()->user()->role == 'Satker')
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
                                @endif
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
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="p-4 mb-4 border rounded shadow-sm bg-white">
                    <h2 class="mb-2">Dokumen {{ session('year') }} - [{{ Auth()->user()->nama }}]
                    </h2>
                    <div class="p-2 rounded bg-white">
                        @if (auth()->user()->role == 'Satker')
                        <div class="row">
                            <div class="col-sm">
                                <button class="px-4 py-2 btn btn-primary fw-bold btn-sm" data-toggle="modal" data-target="#tambahDokumen"><i class="fas fa-plus"></i>
                                    <div class="d-none d-sm-inline  p-3">Tambah
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                {{-- Col End --}}

                <div class="row">
                    <div class="col-12">
                        <x-adminlte-card title="Daftar Dokumen" theme="success" theme-mode="outline">
                            <x-adminlte-datatable id="table" :heads="$heads" head-theme="white" :config="$config" striped
                                hoverable bordered />
                        </x-adminlte-card>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('store.dokumen') }}" method="POST" enctype="multipart/form-data">
    <x-adminlte-modal id="tambahDokumen" title="Tambah Dokumen" v-centered>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label for="uraian" class="form-label"><span class="text-danger">*</span> Uraian</label>
                        <div class="mb-3 input-group">
                            <input type="text" class="form-control" id="uraian" name="uraian"
                                placeholder="Masukkan uraian" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="nodok" class="form-label"><span class="text-danger">*</span> Nomor
                            Dokumen</label>
                        <div class="mb-3 input-group">
                            <input type="text" class="form-control" id="nodok" name="nodok"
                                placeholder="Masukkan nomor dokumen" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal" class="form-label"><span class="text-danger">*</span>
                            Tanggal</label>
                        <div class="mb-3 input-group">
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                placeholder="Masukkan tanggal" required>
                        </div>
                    </div>
                </div>
                <div class="row" hidden>
                    <div class="col">
                        <label for="naro" class="form-label"><span class="text-danger">*</span> Nama RO</label>
                        <div class="mb-3 input-group">
                            <input value="{{ $data->id }}" type="naro" class="form-control"
                                name="naro" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="" class="mb-1"> Upload File
                        </label>
                        <div class="input-group">
                            <input value="{{ $data2->file }}" type="file" class="form-control"
                                name="file">
                        </div>
                    </div>
                </div>
            </div>
            <x-slot name="footerSlot">
                <button type="button" class="btn btn-secondary btn-sm mr-auto" data-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
            </x-slot>
        </x-adminlte-modal>
    </form>
    </div>



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
