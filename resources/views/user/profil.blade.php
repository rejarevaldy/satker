@extends('adminlte::page')

@section('title', 'Profil')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <h1>Profil</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <x-adminlte-card theme="dark" theme-mode="outline">
                    <img src="/images/{{ $data->user_profile }}" alt="" class="img-fluid" style="width: 100%">
                </x-adminlte-card>
            </div>
            <div class="col-md">
                <x-adminlte-card theme="lime" theme-mode="outline">
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
                                <a href="{{ route('profil.edit') }}" class="btn btn-warning text-white">Edit</a>
                            @else
                                <a href="{{ route('users.edit', $data->username) }}" class="btn btn-warning text-white">Edit</a>
                            @endif
                        </div>
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop

