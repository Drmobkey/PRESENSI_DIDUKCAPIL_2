<!DOCTYPE html>
<html>
<head>
    <title>Laporan Logbook</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 0; }
        p { text-align: center; margin-top: 5px; }
    </style>
</head>
<body>
    <h2>Laporan Aktivitas Logbook</h2>
    <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pegawai</th>
                <th>Tanggal</th>
                <th>Aktivitas / Deskripsi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->user->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                <td>{{ $row->description }}</td>
                <td>{{ strtoupper($row->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
