@extends('adminlte::page')

@if (strpos(url()->current(), '/profil'))
    @section('title', 'Profil')
@else
    @section('title', 'Pengguna')
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
    @if ($errors->any())
        <div class="row">
            <div class="col-md my-3">
                <x-adminlte-alert theme="danger" title="Failed" dismissable>
                    {{ $errors->first() }}
                </x-adminlte-alert>
            </div>
        </div>
    @endif

    @if (session('status'))
        <div class="row">
            <div class="col-md my-3">
                <x-adminlte-alert theme="success" title="Success" dismissable>
                    {{ session('status') }}
                </x-adminlte-alert>
            </div>
        </div>
    @endif

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
                        <label>Gender</label>
                        <input type="text" class="form-control" value="{{ $data->gender }}" disabled>
                    </div>
                    <div class="col-md mb-3">
                        <label>Role</label>
                        <input type="text" class="form-control" value="{{ $data->role }}" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="div">
                            <a href="{{ url()->previous() }}">
                                <button type="button" class="px-4 py-2 mt-3 btn btn-secondary btn-sm fw-bold"><i
                                        class="fas fa-caret-square-left"></i>
                                    Kembali
                                </button>
                            </a>
                        </div>
                        <div class="div">

                            @if (strpos(url()->current(), '/profil'))
                                <a href="{{ route('profil.edit') }}">
                                    <button class="px-4 py-2 mt-3 btn btn-success fw-bold btn-sm" data-toggle="modal"
                                        data-target="#tambahDokumen"><i class="fas fa-edit"></i>
                                        <div class="d-none d-sm-inline  p-3">Sunting
                                    </button>
                                </a>
                            @else
                                <a href="{{ route('users.edit', $data->username) }}">
                                    <button class="px-4 py-2 mt-3 btn btn-success fw-bold btn-sm"><i class="fas fa-edit"></i>
                                        <div class="d-none d-sm-inline p-3">Sunting</div>
                                    </button>
                                </a>
                            @endif
                            <button type="button" class="px-4 py-2 mt-3 btn btn-info fw-bold btn-sm" data-toggle="modal"
                                data-target="#editPassword">
                                <i class="fas fa-key"></i>
                                <div class="d-none d-sm-inline p-3">Sunting Password</div>
                            </button>
                        </div>

                        <div class="modal fade" id="editPassword" tabindex="-1" role="dialog"
                            aria-labelledby="editPasswordLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered"" role=" document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editPasswordLabel">Ubah password pengguna
                                            [{{ $data->username }}]</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('profil.update.password', $data) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <label>Password baru</label>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Password baru">

                                            <label>Konfirmasi password </label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="Konfirmasi Password">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Kembali</button>
                                            <button type="submit" class="btn btn-primary">Perbarui</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>

@stop
