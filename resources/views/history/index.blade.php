@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tracking Penerimaan Dana /</span> Data</h4>
    <form action="{{ route('history.index') }}" method="get">
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="dari">Dari</label>
                    <div class="col-sm-10">
                        <input
                            type="date"
                            name="dari"
                            id="dari"
                            class="form-control"
                            aria-describedby="dari"
                            value="{{ isset($_GET['dari']) ? $_GET['dari'] : '' }}"
                        />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="sampai">Sampai</label>
                    <div class="col-sm-10">
                        <input
                            type="date"
                            name="sampai"
                            id="sampai"
                            class="form-control"
                            aria-describedby="sampai"
                            value="{{ isset($_GET['sampai']) ? $_GET['sampai'] : '' }}"
                        />
                    </div>
                </div>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-sm btn-primary">
                    <span class="tf-icons bx bx-filter"></span>&nbsp; Filter
                </button>
            </div>
        </div>
    </form>
    @isset($data)
    <div class="card mt-2">
        <h5 class="card-header">Data Penerimaan Dana dari tanggal <b>{{ $_GET['dari'] }}</b> sampai <b>{{ $_GET['sampai'] }}</b></h5>
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
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
    @endisset
</div>
@endsection