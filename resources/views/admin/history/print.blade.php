<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Riwayat Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 5px 0;
        }
        .header p {
            margin: 3px 0;
        }
        @media print {
            body {
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="header">
        <h2>LAPORAN RIWAYAT PEMINJAMAN BUKU</h2>
        <p>EduSelf - Perpustakaan</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Judul Buku</th>
                <th style="width: 20%;">Nama Anggota</th>
                <th style="width: 12%;">Tanggal Pinjam</th>
                <th style="width: 12%;">Jatuh Tempo</th>
                <th style="width: 14%;">Tanggal Kembali</th>
                <th style="width: 12%;">Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histories as $index => $history)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $history->buku->title ?? '-' }}</td>
                    <td>{{ $history->anggota->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($history->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($history->tanggal_jatuh_tempo)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($history->tanggal_kembali)->format('d/m/Y H:i') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($history->denda, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Belum ada riwayat pengembalian</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 50px;">
        <p>Total Riwayat: {{ count($histories) }} transaksi</p>
        <p>Total Denda: Rp {{ number_format($histories->sum('denda'), 0, ',', '.') }}</p>
    </div>
</body>
</html>