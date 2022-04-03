@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Masyarakat /</span> Data</h4>
    <a href="{{ route('masyarakat.create') }}">
        <button type="button" class="btn btn-sm btn-primary">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Tambah
        </button>
    </a>
    <div class="card mt-2">
        <h5 class="card-header">Data Masyarakat</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>No. HP</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($data as $item)
                        <tr>
                            <td class="text-center"><strong>{{ $loop->iteration }}</strong></td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->jenis_kelamin }}</td>
                            <td>{{ $item->tanggal_lahir }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td class="align-middle">
                                <a href="{{route('masyarakat.edit', $item->id)}}">
                                    <button type="submit" class="btn btn-sm btn-info btn-circle">
                                        <i class="tf-icons bx bxs-pencil"></i>
                                    </button>
                                </a>
                                <form action="{{route('masyarakat.destroy', $item->id)}}" method="POST" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger btn-circle" onclick="return confirm('Hapus Data ?')">
                                        <i class="tf-icons bx bxs-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $data->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
@endsection