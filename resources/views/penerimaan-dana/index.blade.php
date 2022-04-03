@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Penerimaan Dana /</span> Data</h4>
    <a href="{{ route('penerimaan-dana.create') }}">
        <button type="button" class="btn btn-sm btn-primary">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Tambah
        </button>
    </a>
    <div class="card mt-2">
        <h5 class="card-header">Data Penerimaan Dana</h5>
        <div class="table-responsive text-nowrap">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Nominal</th>
                <th>Dibuat pada</th>
                <th>Terkirim pada</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($data as $item)
                    <tr>
                        <td class="text-center"><strong>{{ $loop->iteration }}</strong></td>
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>
                            @if ($item->status == 1)
                            <span class="badge bg-label-primary">Sedang diproses</span>
                            @else
                            <span class="badge bg-label-success">Terkirim</span>
                            @endif
                        </td>
                        <td class="text-right">{{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $item->created_at }}</td>
                        <td class="text-center">{{ $item->status == 1 ? '-' : $item->updated_at }}</td>
                        <td class="align-middle">
                            {{--  <a href="{{route('penerimaan-dana.edit', $item->id)}}">
                                <button type="submit" class="btn btn-sm btn-info btn-circle">
                                    <i class="tf-icons bx bxs-pencil"></i>
                                </button>
                            </a>
                            <form action="{{route('penerimaan-dana.destroy', $item->id)}}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger btn-circle" onclick="return confirm('Hapus Data ?')">
                                    <i class="tf-icons bx bxs-trash"></i>
                                </button>
                            </form>  --}}
                            @if ($item->status == 1)
                            <form action="{{route('penerimaan-dana.update', $item->id)}}" method="POST" class="d-inline">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-sm btn-success btn-circle" onclick="return confirm('Yakin akan melanjutkan ?')">
                                    <i class="tf-icons bx bx-check"></i> Konfirmasi Terkirim
                                </button>
                            </form>
                            @endif
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