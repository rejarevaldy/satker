@extends('adminlte::page')

@section('title', 'Daftar Pengguna')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <h1>Daftar Pengguna</h1>
        </div>
    </div>
@stop

@php
    $heads = [
        'ID',
        'Name',
        'Role',
        'Action',
    ];
    
    $x = 1;
    $query = [];
    foreach ($data as $key => $item) {
        $dataUsername = $item->username;
        $dataName = $item->nama;

        $btnDelete = '<button type="button" class="btn btn-sm mx-auto btn-default text-danger" data-toggle="modal" data-target="#exampleModal_' . $x . '">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </button>';

        $modalDelete = '
                    <div class="modal fade" id="exampleModal_' . $x . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">' . $dataName . '</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        $btnDetails = '<a href=" ' . route("users.list.detail", $item->username) . '" class="btn btn-sm mx-auto btn-default text-teal">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </a>';

        $query[] = [$x, $item->nama, $item->role, $btnDetails .  ' ' . $btnDelete];
        echo $modalDelete;
        $x++;
    }    

    $config = [
        'data' => $query,
        'order' => [[1, 'asc']],
        'columns' => [null, null, null, ['className' => 'text-center']],
    ];
@endphp
@section('content')
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
            <x-adminlte-card theme="lime" theme-mode="outline">
                <x-adminlte-datatable id="table1" :heads="$heads" head-theme="dark" hoverable bordered>
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

