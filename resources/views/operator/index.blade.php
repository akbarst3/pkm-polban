<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail PKM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Detail PKM</h1>

        <h2>Jumlah Judul per Skema</h2>
        <ul class="list-group">
            @if (count($judulCounts) > 0)
                @foreach ($judulCounts as $item)
                    @if ($item['id_skema'] == 0)
                        <li class="list-group-item">{{ $item['total'] }}</li>
                    @else
                        <li class="list-group-item">Skema {{ $item['id_skema'] }}: {{ $item['total'] }}</li>
                    @endif
                @endforeach
            @else
                <li class="list-group-item">Tidak ada data</li>
            @endif
        </ul>

        <h2>Jumlah Proposal per Skema</h2>
        <ul class="list-group">
            @if (count($proposalCounts) > 0)
                @foreach ($proposalCounts as $item)
                    @if ($item['id_skema'] == 0)
                        <li class="list-group-item">{{ $item['total'] }}</li>
                    @else
                        <li class="list-group-item">Skema {{ $item['id_skema'] }}: {{ $item['total'] }}</li>
                    @endif
                @endforeach
            @else
                <li class="list-group-item">Tidak ada data</li>
            @endif
        </ul>

        <h2>Jumlah Pengisian Identitas per Skema</h2>
        <ul class="list-group">
            @if (count($pengisianCounts) > 0)
                @foreach ($pengisianCounts as $item)
                    @if ($item['id_skema'] == 0)
                        <li class="list-group-item">Jumlah Pengisian Identitas: {{ $item['count'] }}</li>
                    @else
                        <li class="list-group-item">Skema {{ $item['id_skema'] }}: Jumlah Pengisian Identitas: {{ $item['count'] }}</li>
                    @endif
                @endforeach
            @else
                <li class="list-group-item">Tidak ada data</li>
            @endif
        </ul>

        <h2>Jumlah Validasi Dosen Pembimbing per Skema</h2>
        <ul class="list-group">
            @if (count($validasiCounts['val_dospem']) > 0)
                @foreach ($validasiCounts['val_dospem'] as $item)
                    @if ($item['id_skema'] == 0)
                        <li class="list-group-item">Jumlah Validasi Dosen Pembimbing: {{ $item['total'] }}</li>
                    @else
                        <li class="list-group-item">Skema {{ $item['id_skema'] }}: Jumlah Validasi Dosen Pembimbing: {{ $item['total'] }}</li>
                    @endif
                @endforeach
            @else
                <li class="list-group-item">Tidak ada data</li>
            @endif
        </ul>
        <h2>Jumlah Validasi Perguruan Tinggi per Skema</h2>
        <ul class="list-group">
            @if (count($validasiCounts['val_pt']) > 0)
                @foreach ($validasiCounts['val_pt'] as $item)
                    @if ($item['id_skema'] == 0)
                        <li class="list-group-item">Jumlah Validasi Perguruan Tinggi: {{ $item['total'] }}</li>
                    @else
                        <li class="list-group-item">Skema {{ $item['id_skema'] }}: Jumlah Validasi Perguruan Tinggi: {{ $item['total'] }}</li>
                    @endif
                @endforeach
            @else
                <li class="list-group-item">Tidak ada data</li>
            @endif
        </ul>
    </div>
</body>
</html>