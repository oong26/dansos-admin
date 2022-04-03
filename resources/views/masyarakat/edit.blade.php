@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User/</span> Tambah</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('masyarakat.update', $data->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-nik">NIK</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" id="basic-default-nik" placeholder="35111xxxxxxxxxxx" max="16" value="{{ $data->nik }}" readonly/>
                            @error('nik')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="nama" id="basic-default-fullname" placeholder="John Doe" value="{{ $data->nama }}" required/>
                            @error('name')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <small class="form-label">Jenis Kelamin</small>
                            <div class="form-check mt-1">
                                <input
                                    name="jenis_kelamin"
                                    class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                    type="radio"
                                    value="Laki-laki"
                                    id="rbLaki"
                                    {{ $data->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}
                                    required
                                />
                                <label class="form-check-label" for="rbLaki"> Laki-laki </label>
                            </div>
                            <div class="form-check">
                                <input
                                    name="jenis_kelamin"
                                    class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                    type="radio"
                                    value="Perempuan"
                                    id="rbPerempuan"
                                    {{ $data->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}
                                    required
                                />
                                <label class="form-check-label" for="rbPerempuan"> Perempuan </label>
                            </div>
                            @error('jenis_kelamin')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-tgllahir">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" id="basic-default-tgllahir" value="{{ $data->tanggal_lahir }}" required/>
                            @error('tanggal_lahir')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-message">Alamat</label>
                                <textarea
                                name="alamat"
                                id="basic-default-message"
                                class="form-control @error('alamat') is-invalid @enderror"
                                placeholder="Jalan Mangga Besar III No. XX, RT XX RW XX, Kelurahan XXXX"
                                >{{ $data->alamat }}</textarea>
                            @error('alamat')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">No. HP</label>
                            <input class="form-control @error('no_hp') is-invalid @enderror" type="tel" max="13" placeholder="08xxxxxxxxxx" name="no_hp" id="html5-tel-input" value="{{ $data->no_hp }}" readonly/>
                            @error('no_hp')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection