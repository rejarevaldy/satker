@extends('adminlte::page')

@section('title', 'Tambah Pengguna')

@section('content_header')
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col mt-4 bg-white p-3 shadow-sm border rounded">
                <h2>Tambah Pengguna</h2>
            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="row mt-3">
            <div class="col">
                <x-adminlte-alert theme="success" title="Success">
                    {{ session('success') }}
                </x-adminlte-alert>
            </div>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md my-3">
            <x-adminlte-card theme="lime" theme-mode="outline">
                <form action="{{ route('users.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md mt-3">
                            <label for="">Nama</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md mt-3">
                            <label for="">Username</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md mt-3">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md mt-3">
                            <label for="">NIP</label>
                            <input type="text" name="nip" class="form-control">
                        </div>
                        <div class="col-md mt-3">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="col-md mt-3">
                            <label for="">No Telepon</label>
                            <input type="number" name="nomor_telepon" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md mt-3">
                            <label for="">Jenis Kelamin</label>
                            <select name="gender" class="form-control">
                                <option value="Pria">Pria</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md mt-3">
                            <label for="">Role</label>
                            <select name="role" class="form-control">
                                <option value="Monitoring">Monitoring</option>
                                <option value="Satker">Satker</option>
                            </select>
                        </div>
                        <div class="col-md mt-3">
                            <x-adminlte-input-file name="user_profile" label="Poto Profil" placeholder="Choose a file..." />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md my-3">
                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop

