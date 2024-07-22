<!DOCTYPE html>
<html>
<head>
    <title>Kartu Penyusutan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Kartu Penyusutan Aset Tetap</h2>
    <p><strong>Nama Aset:</strong>({{ $asset->id ?? '' }}) {{ $asset->aset->nama_aset ?? '' }}</p>
    <p><strong>Jumlah:</strong> {{ $asset->jumlah_barang }}</p>
    <p><strong>Harga Beli:</strong> {{ $asset->harga_beli ? formatRupiah($asset->harga_beli) : formatRupiah(($asset->komponen->harga_total ?? 0)) }}</p>
    <p><strong>Tanggal Operasi:</strong> {{ \Carbon\Carbon::parse($asset->tanggal_operasi)->format('d-m-Y') }}</p>
    <p><strong>Masa Penggunaan:</strong> {{ $asset->masa_penggunaan }} tahun</p>
    <p><strong>Residu:</strong> {{ number_format($asset->residu, 0, ',', '.') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Beban Penyusutan</th>
                <th>Akumulasi Penyusutan</th>
                <th>Nilai Buku</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($depreciationData as $year => $data)
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item['tahun'] }}</td>
                        <td>{{ number_format($item['penyusutan_berjalan'], 0, ',', '.') }}</td>
                        <td>{{ number_format($item['akumulasi_susut'], 0, ',', '.') }}</td>
                        <td>{{ number_format($item['nilai_buku'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>