@extends('layouts.admin')

@section('title', 'Riwayat Transaksi')

@section('content')

<div class="page-header">
    <div>
        <h1>Riwayat Transaksi</h1>
        <p>Laporan dan statistik penjualan BBM.</p>
    </div>
</div>


{{-- FILTER LAPORAN --}}

<div class="report-filter card">

    <div class="filter-group">

        <label for="reportPeriod">
            Periode Laporan
        </label>

        <select id="reportPeriod" class="filter-select">
            <option value="daily">Harian</option>
            <option value="monthly" selected>Bulanan</option>
            <option value="yearly">Tahunan</option>
        </select>

    </div>


    <div class="filter-group">

        <label for="reportMonth">
            Bulan
        </label>

        <select id="reportMonth" class="filter-select">
            <option>Januari</option>
            <option>Februari</option>
            <option>Maret</option>
            <option>April</option>
            <option>Mei</option>
            <option>Juni</option>
            <option>Juli</option>
            <option selected>Agustus</option>
            <option>September</option>
            <option>Oktober</option>
            <option>November</option>
            <option>Desember</option>
        </select>

    </div>


    <div class="filter-group">

        <label for="reportYear">
            Tahun
        </label>

        <select id="reportYear" class="filter-select">
            <option>2024</option>
            <option>2025</option>
            <option selected>2026</option>
        </select>

    </div>


    <button class="print-button" onclick="window.print()">
        🖨 Cetak Laporan
    </button>

</div>


{{-- RINGKASAN --}}

<div class="report-summary">

    <div class="card report-summary-card">

        <span>Total Penjualan</span>

        <strong>
            Rp 12.450.000
        </strong>

        <small>
            Periode Agustus 2026
        </small>

    </div>


    <div class="card report-summary-card">

        <span>Total Transaksi</span>

        <strong>
            128
        </strong>

        <small>
            Transaksi berhasil
        </small>

    </div>


    <div class="card report-summary-card">

        <span>Total BBM Terjual</span>

        <strong>
            950 L
        </strong>

        <small>
            Pertamax + Dexlite
        </small>

    </div>

</div>


{{-- DIAGRAM --}}

<div class="card sales-chart-card">

    <div class="chart-header">

        <div>
            <h2>Diagram Penjualan</h2>

            <p>
                Statistik penjualan berdasarkan periode.
            </p>
        </div>

        <div class="chart-tabs">

            <button class="chart-tab" data-period="daily">
                Harian
            </button>

            <button class="chart-tab active" data-period="monthly">
                Bulanan
            </button>

            <button class="chart-tab" data-period="yearly">
                Tahunan
            </button>

        </div>

    </div>


    {{-- AREA DIAGRAM SEMENTARA --}}

    <div class="sales-chart">

        <div class="chart-y-axis">

            <span>Rp 2 jt</span>
            <span>Rp 1,5 jt</span>
            <span>Rp 1 jt</span>
            <span>Rp 500 rb</span>
            <span>Rp 0</span>

        </div>


        <div class="chart-area">

            <div class="chart-grid-line"></div>
            <div class="chart-grid-line"></div>
            <div class="chart-grid-line"></div>
            <div class="chart-grid-line"></div>


            <div class="chart-bars">

                <div class="chart-bar" style="height: 55%;">
                    <span>Rp 1,1 jt</span>
                </div>

                <div class="chart-bar" style="height: 72%;">
                    <span>Rp 1,4 jt</span>
                </div>

                <div class="chart-bar" style="height: 48%;">
                    <span>Rp 960 rb</span>
                </div>

                <div class="chart-bar" style="height: 82%;">
                    <span>Rp 1,6 jt</span>
                </div>

                <div class="chart-bar" style="height: 64%;">
                    <span>Rp 1,2 jt</span>
                </div>

                <div class="chart-bar" style="height: 90%;">
                    <span>Rp 1,8 jt</span>
                </div>

            </div>


            <div class="chart-labels">

                <span>Jan</span>
                <span>Feb</span>
                <span>Mar</span>
                <span>Apr</span>
                <span>Mei</span>
                <span>Jun</span>

            </div>

        </div>

    </div>

</div>


{{-- RIWAYAT TRANSAKSI --}}

<div class="card transaction-card">

    <div class="transaction-header">

        <div>
            <h2>Riwayat Transaksi</h2>

            <p>
                Daftar transaksi penjualan BBM.
            </p>
        </div>

        <input
            type="text"
            class="search-input"
            placeholder="Cari transaksi..."
        >

    </div>


    <div class="table-wrapper">

        <table class="transaction-table">

            <thead>

                <tr>
                    <th>ID Transaksi</th>
                    <th>Customer</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                </tr>

            </thead>


            <tbody>

                <tr>

                    <td>TRX001</td>

                    <td>Budi</td>

                    <td>Pertamax</td>

                    <td>10 Liter</td>

                    <td>Rp 129.000</td>

                    <td>BRI VA</td>

                    <td>
                        <span class="status status-success">
                            Selesai
                        </span>
                    </td>

                </tr>


                <tr>

                    <td>TRX002</td>

                    <td>Andi</td>

                    <td>Dexlite</td>

                    <td>5 Liter</td>

                    <td>Rp 71.000</td>

                    <td>Cash</td>

                    <td>
                        <span class="status status-success">
                            Selesai
                        </span>
                    </td>

                </tr>


                <tr>

                    <td>TRX003</td>

                    <td>Sinta</td>

                    <td>Pertamax</td>

                    <td>15 Liter</td>

                    <td>Rp 193.500</td>

                    <td>Transfer Bank</td>

                    <td>
                        <span class="status status-warning">
                            Menunggu
                        </span>
                    </td>

                </tr>


                <tr>

                    <td>TRX004</td>

                    <td>Rudi</td>

                    <td>Dexlite</td>

                    <td>10 Liter</td>

                    <td>Rp 142.000</td>

                    <td>BNI VA</td>

                    <td>
                        <span class="status status-success">
                            Selesai
                        </span>
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>


@endsection