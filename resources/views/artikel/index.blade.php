@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Artikel /</span> Data</h4>
    <a href="{{ route('artikel.create') }}">
        <button type="button" class="btn btn-sm btn-primary">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Tambah
        </button>
    </a>
    <div class="card mt-2">
        <h5 class="card-header">Data Artikel</h5>
        <div class="table-responsive text-nowrap">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>Judul</th>
                <th>Konten</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($data as $item)
                    <tr>
                        <td class="text-center"><strong>{{ $loop->iteration }}</strong></td>
                        <td>
                            <img src="{{ asset('upload/artikel').'/'.$item->cover }}" alt="..." width="120" height="120">
                            <br>
                            {{ $item->title }}
                        </td>
                        <td>{{ $item->konten }}</td>
                        <td class="align-middle">
                            <a href="{{route('artikel.edit', $item->id)}}">
                                <button type="submit" class="btn btn-sm btn-info btn-circle">
                                    <i class="tf-icons bx bxs-pencil"></i>
                                </button>
                            </a>
                            <form action="{{route('artikel.destroy', $item->id)}}" method="POST" class="d-inline">
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