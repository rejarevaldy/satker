@extends('adminlte::page')

@section('title', 'Profil')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <h1>Edit {{ $data->nama }}</h1>
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
            <x-adminlte-card theme="lime" theme-mode="outline">
            @if (strpos(url()->current(), '/profil/edit'))
                <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="hidden" value="profil">
            @else
                <form action="{{ route('users.update', $data->username) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="hidden" value="users">
            @endif
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-md">
                        <x-adminlte-input name="nama" label="Nama" value="{{ $data->nama }}" disable-feedback/>
                    </div>
                    <div class="col-md">
                        <x-adminlte-input name="email" type="email" label="Email" value="{{ $data->email }}" disable-feedback/>
                    </div>
                    <div class="col-md">
                        <x-adminlte-input name="nip" label="NIP" value="{{ $data->nip }}" disable-feedback/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md mb-3">
                        <x-adminlte-input name="nomor_telepon" type="number" label="No Telepon" value="{{ $data->nomor_telepon }}" disable-feedback/>
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
                    <div class="col-md">
                        @if (strpos(url()->current(), '/profil/edit'))
                            <a href="{{ route('profil') }}" class="btn btn-dark">Kembali</a>
                        @else
                            <a href="{{ route('users.list.detail', $data->username) }}" class="btn btn-dark">Kembali</a>
                        @endif
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop

