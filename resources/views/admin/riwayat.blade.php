@extends('layouts.admin')

@section('title', 'Riwayat Transaksi')

@section('content')

<div class="page-header">

    <div>
        <h1>Riwayat Transaksi</h1>
        <p>Laporan dan statistik penjualan BBM.</p>
    </div>

</div>


{{-- =========================================================
     FILTER RIWAYAT
========================================================= --}}

<div class="report-filter card">

    <form
        action="{{ route('admin.riwayat') }}"
        method="GET"
        class="report-filter-form"
    >

        {{-- DARI TANGGAL --}}
        <div class="filter-group">

            <label for="dari">
                Dari Tanggal
            </label>

            <input
                type="date"
                id="dari"
                name="dari"
                class="filter-select"
                value="{{ request('dari') }}"
            >

        </div>


        {{-- SAMPAI TANGGAL --}}
        <div class="filter-group">

            <label for="sampai">
                Sampai Tanggal
            </label>

            <input
                type="date"
                id="sampai"
                name="sampai"
                class="filter-select"
                value="{{ request('sampai') }}"
            >

        </div>


        {{-- TAMPILKAN --}}
        <div class="filter-group filter-button-group">

            <label>
                &nbsp;
            </label>

            <button
                type="submit"
                class="filter-button"
            >
                🔎 Tampilkan
            </button>

        </div>


        {{-- CETAK RIWAYAT --}}
        <div class="filter-group filter-button-group">

            <label>
                &nbsp;
            </label>

            <a
                href="{{ route('admin.riwayat.cetak', [
                    'dari' => request('dari'),
                    'sampai' => request('sampai')
                ]) }}"
                target="_blank"
                class="print-button"
            >
                🖨 Cetak Riwayat
            </a>

        </div>

    </form>

</div>


{{-- =========================================================
     RINGKASAN
========================================================= --}}

<div class="report-summary">


    <div class="card report-summary-card">

        <span>
            Total Penjualan
        </span>

        <strong>
            Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
        </strong>

        <small>

            @if ($dari && $sampai)

                {{ $dari->translatedFormat('d F Y') }}
                -
                {{ $sampai->translatedFormat('d F Y') }}

            @else

                Seluruh transaksi

            @endif

        </small>

    </div>


    <div class="card report-summary-card">

        <span>
            Total Transaksi
        </span>

        <strong>
            {{ $totalTransaksi }}
        </strong>

        <small>
            Transaksi tercatat
        </small>

    </div>


    <div class="card report-summary-card">

        <span>
            Total BBM Terjual
        </span>

        <strong>
            {{ number_format($totalLiter, 0, ',', '.') }} L
        </strong>

        <small>
            Total volume penjualan
        </small>

    </div>

</div>


{{-- =========================================================
     DIAGRAM PENJUALAN
========================================================= --}}

<div class="card sales-chart-card">


    <div class="chart-header">

        <div>

            <h2>
                Diagram Penjualan
            </h2>

            <p>
                Statistik penjualan berdasarkan periode.
            </p>

        </div>


        {{-- NAVIGASI DIAGRAM --}}

        <div class="chart-tabs">


            {{-- HARIAN --}}

            <a
                href="{{ route('admin.riwayat', [
                    'dari' => request('dari'),
                    'sampai' => request('sampai'),
                    'search' => request('search'),
                    'chartYear' => $chartYear,
                    'chartMonth' => $chartMonth,
                    'chartDate' => $chartDate,
                    'chartPeriod' => 'daily'
                ]) }}"
                class="chart-tab {{ request('chartPeriod', 'monthly') === 'daily' ? 'active' : '' }}"
            >
                Harian
            </a>


            {{-- BULANAN --}}

            <a
                href="{{ route('admin.riwayat', [
                    'dari' => request('dari'),
                    'sampai' => request('sampai'),
                    'search' => request('search'),
                    'chartYear' => $chartYear,
                    'chartMonth' => $chartMonth,
                    'chartDate' => $chartDate,
                    'chartPeriod' => 'monthly'
                ]) }}"
                class="chart-tab {{ request('chartPeriod', 'monthly') === 'monthly' ? 'active' : '' }}"
            >
                Bulanan
            </a>


            {{-- TAHUNAN --}}

            <a
                href="{{ route('admin.riwayat', [
                    'dari' => request('dari'),
                    'sampai' => request('sampai'),
                    'search' => request('search'),
                    'chartYear' => $chartYear,
                    'chartMonth' => $chartMonth,
                    'chartDate' => $chartDate,
                    'chartPeriod' => 'yearly'
                ]) }}"
                class="chart-tab {{ request('chartPeriod', 'monthly') === 'yearly' ? 'active' : '' }}"
            >
                Tahunan
            </a>

        </div>

    </div>


    {{-- =====================================================
         DIAGRAM
    ====================================================== --}}

    <div class="sales-chart">


        {{-- Y AXIS --}}

        <div class="chart-y-axis">

            <span>Rp 20 jt</span>
            <span>Rp 15 jt</span>
            <span>Rp 10 jt</span>
            <span>Rp 5 jt</span>
            <span>Rp 0</span>

        </div>


        <div class="chart-area">


            {{-- GRID --}}

            <div class="chart-grid-line"></div>
            <div class="chart-grid-line"></div>
            <div class="chart-grid-line"></div>
            <div class="chart-grid-line"></div>


            {{-- ==================================================
                 DIAGRAM HARIAN
            =================================================== --}}

            @if (request('chartPeriod', 'monthly') === 'daily')

                <div class="chart-bars">

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
                            title="{{ sprintf('%02d:00', $jam) }} - Rp {{ number_format($nilai, 0, ',', '.') }}"
                        >

                            @if ($nilai > 0)

                                <span>
                                    Rp {{ number_format($nilai, 0, ',', '.') }}
                                </span>

                            @endif

                        </div>

                    @endfor

                </div>


                <div class="chart-labels">

                    @for ($jam = 0; $jam < 24; $jam++)

                        <span>
                            {{ sprintf('%02d', $jam) }}
                        </span>

                    @endfor

                </div>


            {{-- ==================================================
                 DIAGRAM BULANAN
            =================================================== --}}

            @elseif (request('chartPeriod', 'monthly') === 'monthly')

                <div class="chart-bars">

                    @php
                        $jumlahHari = now()
                            ->setYear($chartYear)
                            ->setMonth($chartMonth)
                            ->daysInMonth;
                    @endphp


                    @for ($hari = 1; $hari <= $jumlahHari; $hari++)

                        @php

                            $nilai = $penjualanBulanan->get(
                                $hari,
                                0
                            );

                            $tanggal = now()
                                ->setYear($chartYear)
                                ->setMonth($chartMonth)
                                ->setDay($hari);

                            $tinggi = $nilai > 0
                                ? min(($nilai / 20000000) * 100, 100)
                                : 0;

                        @endphp


                        <div
                            class="chart-bar"
                            style="height: {{ $tinggi }}%;"
                            title="{{ $tanggal->translatedFormat('D, d F Y') }} - Rp {{ number_format($nilai, 0, ',', '.') }}"
                        >

                            @if ($nilai > 0)

                                <span>
                                    Rp {{ number_format($nilai, 0, ',', '.') }}
                                </span>

                            @endif

                        </div>

                    @endfor

                </div>


                <div class="chart-labels">

                    @for ($hari = 1; $hari <= $jumlahHari; $hari++)

                        @php
                            $tanggal = now()
                                ->setYear($chartYear)
                                ->setMonth($chartMonth)
                                ->setDay($hari);
                        @endphp

                        <span>
                            {{ $tanggal->translatedFormat('D') }}
                            {{ $hari }}
                        </span>

                    @endfor

                </div>


            {{-- ==================================================
                 DIAGRAM TAHUNAN
            =================================================== --}}

            @else

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
                        12 => 'Des',
                    ];

                @endphp


                <div class="chart-bars">

                    @for ($bulan = 1; $bulan <= 12; $bulan++)

                        @php

                            $nilai = $penjualanTahunan->get(
                                $bulan,
                                0
                            );

                            $tinggi = $nilai > 0
                                ? min(($nilai / 20000000) * 100, 100)
                                : 0;

                        @endphp


                        <div
                            class="chart-bar"
                            style="height: {{ $tinggi }}%;"
                            title="{{ $namaBulan[$bulan] }} {{ $chartYear }} - Rp {{ number_format($nilai, 0, ',', '.') }}"
                        >

                            @if ($nilai > 0)

                                <span>
                                    Rp {{ number_format($nilai, 0, ',', '.') }}
                                </span>

                            @endif

                        </div>

                    @endfor

                </div>


                <div class="chart-labels">

                    @foreach ($namaBulan as $bulan)

                        <span>
                            {{ $bulan }}
                        </span>

                    @endforeach

                </div>

            @endif

        </div>

    </div>

</div>


{{-- =========================================================
     RIWAYAT TRANSAKSI
========================================================= --}}

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


        {{-- SEARCH --}}

        <form
            action="{{ route('admin.riwayat') }}"
            method="GET"
        >

            <input
                type="hidden"
                name="dari"
                value="{{ request('dari') }}"
            >

            <input
                type="hidden"
                name="sampai"
                value="{{ request('sampai') }}"
            >

            <input
                type="text"
                name="search"
                class="search-input"
                placeholder="Cari transaksi..."
                value="{{ request('search') }}"
            >

        </form>

    </div>


    <div class="table-wrapper">

        <table class="transaction-table">

            <thead>

                <tr>

                    <th>
                        ID Transaksi
                    </th>

                    <th>
                        Jenis
                    </th>

                    <th>
                        Pelaku
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

                @forelse ($riwayat as $item)

                    <tr>

                        <td>
                            {{ $item['id'] }}
                        </td>

                        <td>
                            {{ $item['jenis'] }}
                        </td>

                        <td>
                            {{ $item['pelaku'] }}
                        </td>

                        <td>
                            {{ $item['produk'] }}
                        </td>

                        <td>
                            {{ number_format(
                                $item['jumlah_liter'],
                                0,
                                ',',
                                '.'
                            ) }}
                            Liter
                        </td>

                        <td>
                            Rp {{ number_format(
                                $item['total_harga'],
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td>
                            {{ ucfirst(
                                str_replace(
                                    '_',
                                    ' ',
                                    $item['metode']
                                )
                            ) }}
                        </td>

                        <td>

                            <span
                                class="status
                                    {{ $item['status'] === 'selesai'
                                        || $item['status'] === 'Selesai'
                                        ? 'status-success'
                                        : 'status-warning'
                                    }}"
                            >

                                {{ ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $item['status']
                                    )
                                ) }}

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            style="text-align: center;"
                        >
                            Belum ada transaksi pada periode tersebut.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


@endsection