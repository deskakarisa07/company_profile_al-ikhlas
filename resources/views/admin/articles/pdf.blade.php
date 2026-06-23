<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 11px
        }

        h1 {
            text-align: center;
            color: #246b3b
        }

        p {
            text-align: center
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px
        }

        th,
        td {
            border: 1px solid #777;
            padding: 7px
        }

        th {
            background: #dcefe2
        }

        .summary {
            margin-top: 15px;
            text-align: left
        }
    </style>
</head>

<body>
    <h1>{{ $company?->name ?? 'Yayasan Al Ikhlas' }}</h1>
    <p><strong>Laporan Data Artikel/Berita</strong><br>Tanggal cetak: {{ now()->translatedFormat('d F Y H:i') }}</p>
    <div class="summary">Total: {{ $summary['total'] }} | Published: {{ $summary['published'] }} | Draft:
        {{ $summary['draft'] }}</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->category }}</td>
                    <td>{{ ucfirst($article->status) }}</td>
                    <td>{{ $article->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
