@extends('layouts.admin')

@section('title', 'Riwayat Transaksi')

@section('content')

<div class="page-header">

    <div>
        <h1>Riwayat Transaksi</h1>
        <p>Laporan dan statistik penjualan BBM.</p>
    </div>

</div>


{{-- =========================
     FILTER LAPORAN
========================= --}}

<div class="report-filter card">

    <div class="filter-group">

        <label for="reportPeriod">
            Periode Laporan
        </label>

        <select id="reportPeriod" class="filter-select">

            <option value="daily">
                Harian
            </option>

            <option value="monthly" selected>
                Bulanan
            </option>

            <option value="yearly">
                Tahunan
            </option>

        </select>

    </div>


    <div class="filter-group">

        <label for="reportMonth">
            Bulan
        </label>

        <select id="reportMonth" class="filter-select">

            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
            <option value="4">April</option>
            <option value="5">Mei</option>
            <option value="6">Juni</option>
            <option value="7">Juli</option>

            <option value="8" selected>
                Agustus
            </option>

            <option value="9">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>

        </select>

    </div>


    <div class="filter-group">

        <label for="reportYear">
            Tahun
        </label>

        <select id="reportYear" class="filter-select">

            <option value="2024">
                2024
            </option>

            <option value="2025">
                2025
            </option>

            <option value="2026" selected>
                2026
            </option>

        </select>

    </div>


    <button
        class="print-button"
        onclick="window.print()"
    >
        🖨 Cetak Laporan
    </button>

</div>


{{-- =========================
     RINGKASAN
========================= --}}

<div class="report-summary">


    {{-- TOTAL PENJUALAN --}}

    <div class="card report-summary-card">

        <span>
            Total Penjualan
        </span>

        <strong>
            Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
        </strong>

        <small>
            Periode {{ now()->translatedFormat('F Y') }}
        </small>

    </div>


    {{-- TOTAL TRANSAKSI --}}

    <div class="card report-summary-card">

        <span>
            Total Transaksi
        </span>

        <strong>
            {{ $totalTransaksi }}
        </strong>

        <small>
            Transaksi berhasil
        </small>

    </div>


    {{-- TOTAL BBM --}}

    <div class="card report-summary-card">

        <span>
            Total BBM Terjual
        </span>

        <strong>
            {{ number_format($totalLiter, 0, ',', '.') }} L
        </strong>

        <small>
            Total BBM terjual
        </small>

    </div>

</div>


{{-- =========================
     DIAGRAM PENJUALAN
========================= --}}

<div class="card sales-chart-card">


    {{-- HEADER DIAGRAM --}}

    <div class="chart-header">

        <div>

            <h2>
                Diagram Penjualan
            </h2>

            <p>
                Statistik penjualan berdasarkan periode.
            </p>

        </div>


        {{-- TOMBOL PERIODE --}}

        <div class="chart-tabs">

            <button
                type="button"
                class="chart-tab"
                data-period="daily"
            >
                Harian
            </button>

            <button
                type="button"
                class="chart-tab active"
                data-period="monthly"
            >
                Bulanan
            </button>

            <button
                type="button"
                class="chart-tab"
                data-period="yearly"
            >
                Tahunan
            </button>

        </div>

    </div>


    {{-- =========================
         AREA DIAGRAM
    ========================= --}}

    <div class="sales-chart">


        {{-- Y AXIS --}}

        <div class="chart-y-axis">

            <span>
                Rp 20 jt
            </span>

            <span>
                Rp 15 jt
            </span>

            <span>
                Rp 10 jt
            </span>

            <span>
                Rp 5 jt
            </span>

            <span>
                Rp 0
            </span>

        </div>


        {{-- =========================
             AREA GRAFIK
        ========================= --}}

        <div class="chart-area">


            {{-- GRID --}}

            <div class="chart-grid-line"></div>
            <div class="chart-grid-line"></div>
            <div class="chart-grid-line"></div>
            <div class="chart-grid-line"></div>


            {{-- ==================================================
                 DIAGRAM HARIAN
            ================================================== --}}

            <div
                class="chart-bars chart-period"
                id="chart-daily"
                style="display: none;"
            >

                @for ($jam = 0; $jam < 24; $jam++)

                    @php

                        $nilai = $penjualanHarian->get($jam, 0);

                        $tinggi = $nilai > 0
                            ? min(($nilai / 20000000) * 100, 100)
                            : 0;

                    @endphp


                    <div
                        class="chart-bar"
                        style="height: {{ $tinggi }}%;"
                        title="Jam {{ sprintf('%02d', $jam) }}:00 - Rp {{ number_format($nilai, 0, ',', '.') }}"
                    >

                        @if ($nilai > 0)

                            <span>
                                Rp {{ number_format($nilai, 0, ',', '.') }}
                            </span>

                        @endif

                    </div>

                @endfor

            </div>


            {{-- ==================================================
                 DIAGRAM BULANAN
            ================================================== --}}

            <div
                class="chart-bars chart-period"
                id="chart-monthly"
            >

                @for ($hari = 1; $hari <= now()->daysInMonth; $hari++)

                    @php

                        $nilai = $penjualanBulanan->get($hari, 0);

                        $tinggi = $nilai > 0
                            ? min(($nilai / 20000000) * 100, 100)
                            : 0;

                    @endphp


                    <div
                        class="chart-bar"
                        style="height: {{ $tinggi }}%;"
                        title="Tanggal {{ $hari }}: Rp {{ number_format($nilai, 0, ',', '.') }}"
                    >

                        @if ($nilai > 0)

                            <span>
                                Rp {{ number_format($nilai, 0, ',', '.') }}
                            </span>

                        @endif

                    </div>

                @endfor

            </div>


            {{-- ==================================================
                 DIAGRAM TAHUNAN
            ================================================== --}}

            <div
                class="chart-bars chart-period"
                id="chart-yearly"
                style="display: none;"
            >

                @php

                    $namaBulan = [
                        1 => 'Jan',
                        2 => 'Feb',
                        3 => 'Mar',
                        4 => 'Apr',
                        5 => 'Mei',
                        6 => 'Jun',
                        7 => 'Jul',
                        8 => 'Agu',
                        9 => 'Sep',
                        10 => 'Okt',
                        11 => 'Nov',
                        12 => 'Des'
                    ];

                @endphp


                @for ($bulan = 1; $bulan <= 12; $bulan++)

                    @php

                        $nilai = $penjualanTahunan->get($bulan, 0);

                        $tinggi = $nilai > 0
                            ? min(($nilai / 20000000) * 100, 100)
                            : 0;

                    @endphp


                    <div
                        class="chart-bar"
                        style="height: {{ $tinggi }}%;"
                        title="{{ $namaBulan[$bulan] }}: Rp {{ number_format($nilai, 0, ',', '.') }}"
                    >

                        @if ($nilai > 0)

                            <span>
                                Rp {{ number_format($nilai, 0, ',', '.') }}
                            </span>

                        @endif

                    </div>

                @endfor

            </div>


            {{-- ==================================================
                 LABEL HARIAN
            ================================================== --}}

            <div
                class="chart-labels"
                id="labels-daily"
                style="display: none;"
            >

                @for ($jam = 0; $jam < 24; $jam++)

                    <span>
                        {{ sprintf('%02d', $jam) }}
                    </span>

                @endfor

            </div>


            {{-- ==================================================
                 LABEL BULANAN
            ================================================== --}}

            <div
                class="chart-labels"
                id="labels-monthly"
            >

                @for ($hari = 1; $hari <= now()->daysInMonth; $hari++)

                    <span>
                        {{ $hari }}
                    </span>

                @endfor

            </div>


            {{-- ==================================================
                 LABEL TAHUNAN
            ================================================== --}}

            <div
                class="chart-labels"
                id="labels-yearly"
                style="display: none;"
            >

                @foreach ($namaBulan as $bulan)

                    <span>
                        {{ $bulan }}
                    </span>

                @endforeach

            </div>

        </div>

    </div>

</div>


{{-- =========================
     RIWAYAT TRANSAKSI
========================= --}}

<div class="card transaction-card">


    <div class="transaction-header">

        <div>

            <h2>
                Riwayat Transaksi
            </h2>

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

                    <th>
                        ID Transaksi
                    </th>

                    <th>
                        Kasir
                    </th>

                    <th>
                        Produk
                    </th>

                    <th>
                        Jumlah
                    </th>

                    <th>
                        Total
                    </th>

                    <th>
                        Metode
                    </th>

                    <th>
                        Status
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse ($transaksi as $item)

                    <tr>

                        <td>
                            TRX{{ str_pad($item->id_penjualan, 3, '0', STR_PAD_LEFT) }}
                        </td>


                        <td>
                            {{ $item->kasir->nama }}
                        </td>


                        <td>
                            {{ $item->produk->nama_produk }}
                        </td>


                        <td>
                            {{ number_format($item->jumlah_liter, 0, ',', '.') }}
                            Liter
                        </td>


                        <td>
                            Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                        </td>


                        <td>

                            {{ $item->metode_pembayaran === 'tunai'
                                ? 'Tunai'
                                : 'Non Tunai' }}

                        </td>


                        <td>

                            <span class="status status-success">
                                Selesai
                            </span>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="7"
                            style="text-align: center;"
                        >
                            Belum ada transaksi.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


@endsection


{{-- =========================================================
     JAVASCRIPT DIAGRAM
========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {


    const tabs = document.querySelectorAll('.chart-tab');


    const charts = {

        daily: document.getElementById('chart-daily'),

        monthly: document.getElementById('chart-monthly'),

        yearly: document.getElementById('chart-yearly')

    };


    const labels = {

        daily: document.getElementById('labels-daily'),

        monthly: document.getElementById('labels-monthly'),

        yearly: document.getElementById('labels-yearly')

    };


    tabs.forEach(function (tab) {


        tab.addEventListener('click', function () {


            const period = this.dataset.period;


            /*
            |--------------------------------------------------------------------------
            | UBAH TOMBOL AKTIF
            |--------------------------------------------------------------------------
            */

            tabs.forEach(function (item) {

                item.classList.remove('active');

            });


            this.classList.add('active');


            /*
            |--------------------------------------------------------------------------
            | SEMBUNYIKAN SEMUA DIAGRAM
            |--------------------------------------------------------------------------
            */

            Object.values(charts).forEach(function (chart) {

                if (chart) {

                    chart.style.display = 'none';

                }

            });


            /*
            |--------------------------------------------------------------------------
            | SEMBUNYIKAN SEMUA LABEL
            |--------------------------------------------------------------------------
            */

            Object.values(labels).forEach(function (label) {

                if (label) {

                    label.style.display = 'none';

                }

            });


            /*
            |--------------------------------------------------------------------------
            | TAMPILKAN DIAGRAM TERPILIH
            |--------------------------------------------------------------------------
            */

            if (charts[period]) {

                charts[period].style.display = 'flex';

            }


            /*
            |--------------------------------------------------------------------------
            | TAMPILKAN LABEL TERPILIH
            |--------------------------------------------------------------------------
            */

            if (labels[period]) {

                labels[period].style.display = 'flex';

            }

        });

    });

});

</script>