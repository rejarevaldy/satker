@php
$heads = [['label' => 'No', 'width' => 1], ['label' => 'Nama RO', 'width' => 30], ['label' => 'Volume Capaian', 'width' => 30], ['label' => 'Uraian', 'width' => 30], ['label' => 'Nomor Dokumen', 'width' => 8], ['label' => 'Tanggal', 'width' => 8], ['label' => 'File', 'width' => 8], ['label' => 'Opsi', 'no-export' => true, 'width' => 5]];
$query = [];
$loop = 1;
// @dd($datas);
foreach ($datas2 as $data2) {

    foreach ($selection as $select) {
        $option =
        '<option.'
        if ($select->id == $data2->one_input_id) {
            '.'selected'.'
        }
        endif
        value="'.$select->id.'">
        {{ $select->nama_ro }}</option.>'
    }

    $tanggal = \Carbon\Carbon::parse($data2->tanggal)->format('d-m-Y');

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
                    <form action="'.route("edit.dokumen", $data2->id).'" method="POST">
                    <input type="hidden" name="_token" value="'.csrf_token().'" />
                    <div class="row">
                        <label for="uraian" class="form-label">Uraian</label>
                        <div class="mb-3 input-group">
                            <input type="text" class="form-control" id="uraian"
                                name="uraian" placeholder="Masukkan Uraian"
                                value="'.$data2->uraian.'">
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
                                    value="'.$tanggal.'">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="naro" class="form-label">Nama RO</label>
                        <div class="mb-3 input-group">
                            <select type="select" class="form-control" id="naro"
                                name="naro" required>
                                .''.
                </select>
            </div>
    </div>
    <div class="row">
        <label for="" class="mb-1"> Upload File
        </label>
        <div class="input-group">
            <input value="{{ $data2->file }}" type="file" class="form-control"
                name="file">
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

    $query[] = [$loop, $data2->uraian, $data2->volume_capaian, $data2->uraian, $data2->nomor_dokumen, $tanggal, $data2->file, '<nobr>' .$btnEdit.$btnDelete. '</nobr>'];
    echo($mdlEdit);
    echo($mdlDelete);
    // @dd($dataId);
    $loop++;
}
$config = [
    'data' => $query,
    'order' => [[0, 'asc']],
    'columns' => [['className' => 'text-center'],['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center'], ['className' => 'text-center']],
    'language' => ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/id.json'],
];

@endphp

@extends('adminlte::page')

@section('title', 'Dokumen')

@section('content_header')

@stop

@section('content')
    <div class="container-fluid pt-3">
        <div class="row">
            <div class="col-12">
                <div class="p-4 mb-4 border rounded shadow-sm bg-white">
                    <h2 class="mb-2">Dokumen {{ session('year') }} - [{{ Auth()->user()->nama }}]
                    </h2>
                    <div class="p-2 rounded bg-white">
                        <div class="row">
                            <div class="col-sm">
                                <button class="px-4 py-2 btn btn-primary fw-bold btn-sm" data-toggle="modal" data-target="#tambahDokumen"><i class="fas fa-plus"></i>
                                    <div class="d-none d-sm-inline  p-3">Tambah
                                </button>
                            </div>
                        </div>
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

    <x-adminlte-modal id="tambahDokumen" title="Tambah Dokumen" v-centered>
        <form action="{{ route('store.dokumen') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <label for="uraian" class="form-label"><span class="text-danger">*</span> Uraian</label>
                    <div class="mb-3 input-group">
                        <input type="text" class="form-control" id="uraian" name="uraian"
                            placeholder="Masukkan uraian" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="nodok" class="form-label"><span class="text-danger">*</span> Nomor
                            Dokumen</label>
                        <div class="mb-3 input-group">
                            <input type="text" class="form-control" id="nodok" name="nodok"
                                placeholder="Masukkan nomor dokumen" required>
                        </div>
                    </div>
                    <div class="col">
                        <label for="tanggal" class="form-label"><span class="text-danger">*</span>
                            Tanggal</label>
                        <div class="mb-3 input-group">
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                placeholder="Masukkan tanggal" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="naro" class="form-label"><span class="text-danger">*</span> Nama RO</label>
                        <div class="mb-3 input-group">
                            <select type="select" class="form-control" id="naro" name="naro" required>
                                @foreach ($selection as $select)
                                    <option @if ($select->id == $data2->one_input_id)
                                        {{ 'selected' }}
                                @endif
                                value="{{ $select->id }}">
                                {{ $select->nama_ro }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="volcap" class="form-label"><span class="text-danger">*</span> Volume
                            Capaian</label>
                        <div class="mb-3 input-group">
                            <select type="select" class="form-control" id="volcap" name="volcap" required>
                                <option value="-">-</option>
                                <option value="Bulan Layanan">Bulan Layanan</option>
                                <option value="Dokumen">Dokumen</option>
                                <option value="ISO">ISO</option>
                                <option value="Kegiatan">Kegiatan</option>
                                <option value="KPPN">KPPN</option>
                                <option value="Laporan">Laporan</option>
                                <option value="Pegawai">Pegawai</option>
                                <option value="Rekomendasi">Rekomendasi</option>
                                <option value="Satker">Satker</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input-file name="file" label="Unggah file" placeholder="Tekan tombol" disable-feedback/>
                    </div>
                </div>
            </div>
        </form>
        <x-slot name="footerSlot">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Kembali</button>
            <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
        </x-slot>
    </x-adminlte-modal>



    {{-- <div class="modal fade" id="tambahDokumen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dokumen Baru</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div> --}}
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop