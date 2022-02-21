@extends('adminlte::page')

@section('title', 'Profil')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            @if (strpos(url()->current(), '/profil/edit'))
                <h1>Profil</h1>
            @else
                <h1>Pengguna</h1>
            @endif
        </div>
    </div>
@stop

@section('content')
    @if (session('success'))
        <div class="row">
            <div class="col-md my-3">
                <x-adminlte-alert theme="success" title="Success" dismissable>
                    {{ session('success') }}
                </x-adminlte-alert>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md">
            <x-adminlte-card theme="success" theme-mode="outline" title='Edit Pengguna "{{ $data->nama }}"'>
                @if (strpos(url()->current(), '/profil/edit'))
                    <form action="{{ route('profil.update') }}" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="hidden" value="profil">
                    @else
                        <form action="{{ route('users.update', $data->username) }}" method="POST"
                            enctype="multipart/form-data">
                            <input type="hidden" name="hidden" value="users">
                @endif
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-md">
                        <x-adminlte-input name="nama" label="Nama" value="{{ $data->nama }}" disable-feedback />
                    </div>
                    <div class="col-md">
                        <x-adminlte-input name="email" type="email" label="Email" value="{{ $data->email }}"
                            disable-feedback />
                    </div>
                    <div class="col-md">
                        <x-adminlte-input name="nip" label="NIP" value="{{ $data->nip }}" disable-feedback />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md mb-3">
                        <x-adminlte-input name="nomor_telepon" type="number" label="No Telepon"
                            value="{{ $data->nomor_telepon }}" disable-feedback />
                    </div>
                    <div class="col-md mb-3">
                        @php
                            $kelamin = ['Pria' => 'Pria', 'Wanita' => 'Wanita'];
                            $pekerjaan = ['Monitoring' => 'Monitoring', 'Satker' => 'Satker'];
                        @endphp
                        <label>Jenis Kelamin</label>
                        <select name="gender" class="form-control">
                            @foreach ($kelamin as $item)
                                @if (old('gender', $data->gender) == $item)
                                    <option value="{{ $data->gender }}" selected>{{ $data->gender }}</option>
                                @else
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md mb-3">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            @foreach ($pekerjaan as $item)
                                @if (old('role', $data->role) == $item)
                                    <option value="{{ $data->role }}" selected>{{ $data->role }}</option>
                                @else
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md mb-3">
                        <label>Poto Profil</label>
                        <x-adminlte-input-file name="user_profile" placeholder="Choose file..." />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        @if (strpos(url()->current(), '/profil/edit'))
                            <div class="div">
                                <a href="{{ route('profil') }}">
                                    <button type="button" class="px-4 py-2 mt-3 btn btn-secondary btn-sm fw-bold"><i
                                            class="fas fa-caret-square-left"></i>
                                        Kembali
                                    </button>
                                </a>
                            </div>
                        @else
                            <div class="div">
                                <a href="{{ route('users.list.detail', $data->username) }}">
                                    <button type="button" class="px-4 py-2 mt-3 btn btn-secondary btn-sm fw-bold"><i
                                            class="fas fa-caret-square-left"></i>
                                        Kembali
                                    </button>
                                </a>
                            </div>
                        @endif
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
            </x-adminlte-card>
        </div>
    </div>
@stop
