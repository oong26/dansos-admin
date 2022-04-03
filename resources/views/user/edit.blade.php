@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User/</span> Edit</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', $data->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="basic-default-fullname" placeholder="John Doe" value="{{ $data->name }}" required/>
                            @error('name')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Email</label>
                            <div class="input-group input-group-merge">
                            <input
                                type="text"
                                name="email"
                                id="basic-default-email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="john.doe"
                                aria-label="john.doe"
                                aria-describedby="basic-default-email2"
                                value="{{ $data->email }}"
                                required
                            />
                            <span class="input-group-text" id="basic-default-email2">@example.com</span>
                            </div>
                            @error('email')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="basic-default-password" placeholder="123xxxx" required/>
                            @error('password')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Role</label>
                            <select class="form-select @error('role') is-invalid @enderror" name="role" id="exampleFormControlSelect1" aria-label="Default select example" required>
                            <option selected>Pilih role</option>
                            <option value="Pimpinan" {{ $data->role == 'Pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                            <option value="Officer" {{ $data->role == 'Officer' ? 'selected' : '' }}>Officer</option>
                            <option value="Dinas Provinsi" {{ $data->role == 'Dinas Provinsi' ? 'selected' : '' }}>Dinas Provinsi</option>
                            </select>
                            @error('role')
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