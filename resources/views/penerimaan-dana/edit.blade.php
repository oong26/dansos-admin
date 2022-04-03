@extends('layouts.app')
@push('extraCSS')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Penerimaan Dana/</span> Tambah</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('penerimaan-dana.update', $data->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">NIK</label>
                            <select class="form-select custom-select @error('nik') is-invalid @enderror" name="nik" id="exampleFormControlSelect1" aria-label="Default select example" readonly>
                            <option value="0" selected>Pilih NIK</option>
                            @foreach ($nik as $item)
                                <option value="{{ $item->nik }}" {{ $item->nik == $data->nik ? 'selected' : '' }}>{{ $item->nik.' - '.$item->nama }}</option>
                            @endforeach
                            </select>
                            @error('nik')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="basic-default-fullname" value="{{ $data->tanggal }}" required/>
                            @error('tanggal')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="html5-tel-input">Nominal</label>
                            <input class="form-control @error('nominal') is-invalid @enderror" type="number" placeholder="20xxxxxxxxxx" name="nominal" id="html5-tel-input" value="{{ $data->nominal }}" readonly/>
                            @error('nominal')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" id="exampleFormControlSelect1" aria-label="Default select example" required>
                            <option value="0" selected>Pilih status</option>
                            <option value="1">Sedang diproses</option>
                            <option value="2">Terkirim</option>
                            </select>
                            @error('status')
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
@push('extraJS')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.custom-select').select2();
    });
</script>
@endpush