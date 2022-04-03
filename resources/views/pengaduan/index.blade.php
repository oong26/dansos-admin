@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaduan /</span> Data</h4>
    <div class="card mt-2">
        <h5 class="card-header">Data Pengaduan</h5>
        <div class="table-responsive text-nowrap">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>No. HP</th>
                <th>Perihal</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($data as $item)
                    <tr>
                        <td class="text-center"><strong>{{ $loop->iteration }}</strong></td>
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td>
                            {{ substr($item->perihal, 0, 40).'...' }}
                            <a href="#modalScrollable" class="openPerihalModal" style="text-decoration: underline;"
                                data-perihal="{{ $item->perihal }}"
                                >Selengkapnya</a>
                        </td>
                        <td class="align-middle">
                            <form action="{{route('pengaduan.destroy', $item->id)}}" method="POST" class="d-inline">
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
        <!-- Modal -->
        <div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalScrollableTitle">Detail Perihal</h5>
                        <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <p id="perihal"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('extraJS')
<script>
    $(document).on("click", ".openPerihalModal", function () {
        var perihal = $(this).data('perihal');

        $(".modal-body #perihal").html( perihal );
        $('#modalScrollable').modal('show');
    });
</script>
@endpush