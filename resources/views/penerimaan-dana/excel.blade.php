<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Penerimaan Dana</title>
</head>
<body>
    <table>
        <thead>
          <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Status</th>
            <th>Nominal</th>
            <th>Dibuat pada</th>
            <th>Terkirim pada</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td><strong>{{ $loop->iteration }}</strong></td>
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>
                        @if ($item->status == 1)
                        <span style="color: blue;">Sedang diproses</span>
                        @else
                        <span style="color: green;">Terkirim</span>
                        @endif
                    </td>
                    <td>{{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->status == 1 ? '-' : $item->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
      </table>
</body>
</html>