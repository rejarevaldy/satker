@extends('adminlte::page')

@section('title', 'Daftar Pengguna')

@section('content_header')
@stop

@php
    $heads = [
        ['label' => 'No', 'no-export' => true, 'width' => 1],
        'Nama',
        ['label' => 'Role', 'no-export' => true, 'width' => 5],
        ['label' => 'Opsi', 'no-export' => true, 'width' => 16],
    ];

    $x = 1;
    $query = [];
    foreach ($data as $key => $item) {
        $dataUsername = $item->username;
        $dataName = $item->nama;

        $btnDelete = '<button class="btn btn-xs btn-danger mx-1 shadow-sm" title="Detail" data-toggle="modal" data-target="#exampleModal_' . $x . '">
                        <i class="fa fa-fw fa-trash"></i> Hapus
                    </button>';

        $modalDelete = '
                    <div class="modal fade" id="exampleModal_' . $x . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">' . $dataName . '</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                                </div>
                                <div class="forum">
                                    <form action="' . route("users.delete", $item->id) . '" method="POST" style="display: inline;">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                    <input type="hidden" name="_method" value="delete" />
                                        <div class="modal-body">
                                            Apakah yakin ' . $dataName . ' akan dihapus?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>';
        $btnDetails ='<a href=' .
                    route("users.list.detail", $item->username) .
                    '><button class="btn btn-xs btn-primary mx-1 shadow-sm" title="Detail">
                            <i class="fa fa-fw fa-info"></i> Detail
                        </button> </a>';

        $query[] = [$x, $item->nama, $item->role, $btnDetails .  ' ' . $btnDelete];
        echo $modalDelete;
        $x++;
    }

    $config = [
        'data' => $query,
        'order' => [[1, 'asc']],
        'columns' => [['className' => 'text-center'], null, null, ['className' => 'text-center']],
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-md">
            <div class="p-4 my-4 border rounded shadow-sm bg-white">
                <h2 class="mb-2">Pengguna</h2>
                <div class="p-2 rounded bg-white">
                    <div class="row">
                        <div class="col-sm">
                            <a href="{{ route('users.create') }}" class="text-white text-decoration-none">
                                <button class="px-4 py-2 btn btn-primary fw-bold btn-sm"><i class="fas fa-plus"></i>
                                    <div class="d-none d-sm-inline  p-3">Tambah
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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
            <x-adminlte-card theme="success" theme-mode="outline" title="Daftar Pengguna">
                <x-adminlte-datatable id="table1" :heads="$heads" hoverable bordered>
                    @foreach($config['data'] as $row)
                        <tr>
                            @foreach($row as $cell)
                                <td>{!! $cell !!}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop

