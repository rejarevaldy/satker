@extends('adminlte::page')

@if (strpos(url()->current(), '/profil'))
@section('title', 'Profil')
@else
@section('title', 'Penggun')
@endif

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            @if (strpos(url()->current(), '/profil'))
            <h1>Profil</h1>
            @else
            <h1>Pengguna</h1>
            @endif
        </div>
    </div>
@stop

@section('content')
        <div class="row">
            <div class="col-md-3">
                <x-adminlte-card theme="dark" theme-mode="outline" title="Foto Profil">
                    <img src="/images/{{ $data->user_profile }}" alt="" class="img-fluid" style="width: 100%">
                </x-adminlte-card>
            </div>
            <div class="col-md">
                <x-adminlte-card theme="success" theme-mode="outline" title="Informasi Pengguna">
                    <div class="row">
                        <div class="col-md mb-3">
                            <label>Nama</label>
                            <input type="text" class="form-control" value="{{ $data->nama }}" disabled>
                        </div>
                        <div class="col-md mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ $data->email }}" disabled>
                        </div>
                        <div class="col-md mb-3">
                            <label>NIP</label>
                            <input type="text" class="form-control" value="{{ $data->nip }}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md mb-3">
                            <label>No Telepon</label>
                            <input type="text" class="form-control" value="{{ $data->nomor_telepon }}" disabled>
                        </div>
                        <div class="col-md mb-3">
                            <label>Jenis Kelamin</label>
                            <input type="text" class="form-control" value="{{ $data->gender }}" disabled>
                        </div>
                        <div class="col-md mb-3">
                            <label>Role</label>
                            <input type="text" class="form-control" value="{{ $data->role }}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            @if (strpos(url()->current(), '/profil'))
                                <a href="{{ route('profil.edit') }}">
                                    <button class="px-4 py-2 btn btn-success fw-bold btn-sm" data-toggle="modal"
                                    data-target="#tambahDokumen"><i class="fas fa-edit"></i>
                                    <div class="d-none d-sm-inline  p-3">Sunting
                                    </button>
                                </a>
                            @else
                                <a href="{{ route('users.edit', $data->username) }}">
                                    <button class="px-4 py-2 btn btn-success fw-bold btn-sm"><i
                                        class="fas fa-edit"></i>
                                    <div class="d-none d-sm-inline p-3">Sunting</div>
                                </button>
                            </a>

                            @endif
                        </div>
                    </div>
                </x-adminlte-card>
            </div>
        </div>

@stop

