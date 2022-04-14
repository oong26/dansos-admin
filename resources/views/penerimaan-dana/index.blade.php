@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Penerimaan Dana /</span> Data</h4>
    <a href="{{ route('penerimaan-dana.create') }}">
        <button type="button" class="btn btn-sm btn-primary">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Tambah
        </button>
    </a>
    @php
        if(isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        else {
            $page = 1;
        }
    @endphp
    <a href="{{ route('penerimaan-dana.excel', $page) }}">
        <button type="button" class="btn btn-sm btn-warning">
            <span class="tf-icons bx bx-file"></span>&nbsp; Excel
        </button>
    </a>
    <form action="{{url('/search')}}" method="post" role="search" >
        <input type="text" placeholder="Masukkan NIK..." name="search" class="form-control">
        <button type="submit" class="btn btn-primary"><i class="fa fa-search fa-sm">Cari data</i></button>
    </form>
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
                <th class="text-center">Dibuat pada</th>
                <th class="text-center">Terkirim pada</th>
                <th>Actions</th>
                <th class="text-center"><input type="checkbox" name="check_all" id="check_all"> <label for="check_all">Pilih semua</label></th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @php
                    $formExists = false;
                @endphp
                @foreach ($data as $key => $item)
                    <tr id="checkid{{$item->id}}">
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
                                    <i class="tf-icons bx bx-check"></i> Konfirmasi
                                </button>
                            </form>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($item->status == 1)
                            <input type="checkbox" name="check" id="check[]" value="{{ $item->id }}" onchange="checkItem({{$item->id}})">
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="8"></th>
                    <th>
                        <button id="multiple_confirm" class="btn btn-sm btn-success btn-circle">
                            <i class="tf-icons bx bx-check"></i> Konfirmasi yang dipilih
                        </button>
                    </th>
                </tr>
            </tbody>
          </table>
          {{ $data->links('vendor.pagination.custom') }}
        </div>
      </div>
</div>
@endsection

@push('extraJS')
<script>
    var checks = [];
    function checkItem(id) {
        checks.push(id);
        console.log(this);
        console.log(checks)
    }

    $('#check_all').click(function(event) {
        if(this.checked) {
            // Iterate each checkbox
            $('[id^=check]').each(function() {
                this.checked = true;
            });
        } else {
            $('[id^=check]').each(function() {
                this.checked = false;
            });
        }
    });

    $('#multiple_confirm').click(function(e) {
        e.preventDefault();
        var checkArr = [];
        $("input:checkbox[name=check]:checked").each(function(){
            checkArr.push($(this).val());
        });

        $.ajax({
            url: "{{ route('penerimaan-dana.multiple-konfirmasi') }}",
            type: "POST",
            data: {
                _token: "{{csrf_token()}}",
                ids: checkArr,
            },
            success: function(response) {
                console.log(response)
                if(response['success'])
                    location.reload();
                else
                    alert('Terjadi kesalahan')
            }
        })
    })
</script>
@endpush
