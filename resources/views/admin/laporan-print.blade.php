<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Riwayat Transaksi</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, Helvetica, sans-serif;
            color: #111827;
            background: #f3f4f6;
        }

        .report-container {
            max-width: 1100px;
            margin: auto;
            padding: 35px;
            background: white;
            border: 1px solid #e5e7eb;
        }

        .report-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .report-header h1 {
            margin: 0;
            font-size: 22px;
        }

        .report-header h2 {
            margin: 5px 0;
            font-size: 18px;
        }

        .report-header p {
            margin: 5px 0;
            font-size: 13px;
            color: #6b7280;
        }

        .report-period {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 12px 0;
            margin-bottom: 20px;
            border-top: 1px solid #d1d5db;
            border-bottom: 1px solid #d1d5db;
            font-size: 13px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .summary-card {
            padding: 15px;
            border: 1px solid #d1d5db;
        }

        .summary-card span {
            display: block;
            margin-bottom: 7px;
            font-size: 12px;
            color: #6b7280;
        }

        .summary-card strong {
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 9px;
            border: 1px solid #d1d5db;
            font-size: 12px;
        }

        th {
            text-align: center;
            background: #f3f4f6;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .report-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            font-size: 11px;
            color: #6b7280;
        }

        .print-actions {
            max-width: 1100px;
            margin: 0 auto 15px;
            text-align: right;
        }

        .print-button {
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            background: #dc2626;
            color: white;
            cursor: pointer;
        }

        @media print {
            body {
                padding: 0;
                background: white;
            }

            .report-container {
                max-width: none;
                border: none;
                padding: 0;
            }

            .print-actions {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="print-actions">
        <button
            type="button"
            class="print-button"
            onclick="window.print()"
        >
            🖨 Cetak
        </button>
    </div>

    <div class="report-container">

        <div class="report-header">

            <h1>
                CV DWI TIRTA AGUNG
            </h1>

            <h2>
                PERTASHOP
            </h2>

            <p>
                LAPORAN RIWAYAT TRANSAKSI PENJUALAN BBM
            </p>

        </div>


        <div class="report-period">

            <div>
                <strong>Periode:</strong>
                {{ $dari->translatedFormat('d F Y') }}
                s/d
                {{ $sampai->translatedFormat('d F Y') }}
            </div>

            <div>
                Dicetak:
                {{ now()->translatedFormat('d F Y H:i') }}
                WITA
            </div>

        </div>


        <div class="summary">

            <div class="summary-card">

                <span>
                    Total Transaksi
                </span>

                <strong>
                    {{ $totalTransaksi }}
                </strong>

            </div>


            <div class="summary-card">

                <span>
                    Total BBM Terjual
                </span>

                <strong>
                    {{ number_format($totalLiter, 0, ',', '.') }}
                    Liter
                </strong>

            </div>


            <div class="summary-card">

                <span>
                    Total Penjualan
                </span>

                <strong>
                    Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
                </strong>

            </div>

        </div>


        <table>

            <thead>

                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Pelaku</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody>

                @forelse ($riwayat as $index => $item)

                    <tr>

                        <td class="center">
                            {{ $index + 1 }}
                        </td>

                        <td class="center">
                            {{ $item['id'] }}
                        </td>

                        <td class="center">
                            {{ $item['tanggal']->translatedFormat('d/m/Y H:i') }}
                        </td>

                        <td class="center">
                            {{ $item['jenis'] }}
                        </td>

                        <td>
                            {{ $item['pelaku'] }}
                        </td>

                        <td>
                            {{ $item['produk'] }}
                        </td>

                        <td class="right">
                            {{ number_format($item['jumlah_liter'], 0, ',', '.') }}
                            L
                        </td>

                        <td class="right">
                            Rp {{ number_format($item['total_harga'], 0, ',', '.') }}
                        </td>

                        <td class="center">
                            {{ ucfirst(
                                str_replace('_', ' ', $item['metode'])
                            ) }}
                        </td>

                        <td class="center">
                            {{ ucfirst(
                                str_replace('_', ' ', $item['status'])
                            ) }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="10" class="center">
                            Tidak ada transaksi pada periode yang dipilih.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>


        <div class="report-footer">

            <div>
                Sistem Informasi Pertashop
            </div>

            <div>
                Dokumen laporan transaksi
            </div>

        </div>

    </div>

</body>

</html>