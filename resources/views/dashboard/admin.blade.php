@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<div class="dashboard-header">

    <h1>
        Dashboard Admin
    </h1>

    <p>
        Selamat datang, {{ Auth::user()->nama }}
    </p>

</div>


{{-- =========================================================
     STATISTIK
========================================================= --}}

<div class="admin-stat-grid">


    {{-- PESANAN HARI INI --}}
    <div class="admin-stat-card">

        <div>

            <p>
                Pesanan Hari Ini
            </p>

            <h2>
                {{ $pesananHariIni }}
            </h2>

            <small>
                Pesanan masuk hari ini
            </small>

        </div>

        <div class="admin-stat-icon">
            📋
        </div>

    </div>


    {{-- PERLU KONFIRMASI --}}
    <div class="admin-stat-card">

        <div>

            <p>
                Perlu Konfirmasi
            </p>

            <h2>
                {{ $perluKonfirmasi }}
            </h2>

            <small>
                Segera periksa pembayaran
            </small>

        </div>

        <div class="admin-stat-icon">
            ⚠️
        </div>

    </div>


    {{-- MENUNGGU PENGAMBILAN --}}
<div class="admin-stat-card">

    <div>

        <p>
            Menunggu Pengambilan
        </p>

        <h2>
            {{ $menungguPengambilan }}
        </h2>

        <small>
            Pesanan siap diambil
        </small>

        <a
            href="{{ route('admin.pesanan') }}"
            class="btn-view-orders"
>
             Lihat Pesanan
        </a>

    </div>

    <div class="admin-stat-icon">
        ⛽
    </div>

</div>

</div>


{{-- =========================================================
     AREA INFORMASI
========================================================= --}}

<div class="admin-dashboard-grid">


    {{-- =====================================================
         PERINGATAN PEMBAYARAN
    ====================================================== --}}

    <div class="admin-card">

        <div class="admin-card-header">

            <div>

                <h2>
                    Peringatan Pembayaran
                </h2>

                <p>
                    Pembayaran yang perlu segera diperiksa.
                </p>

            </div>

            <a href="{{ route('admin.pembayaran') }}">
                Lihat Pembayaran
            </a>

        </div>


        <div class="admin-payment-alert-list">

            @forelse ($peringatanPembayaran as $item)

                @php

                    $waktuPembayaran =
                        $item->tanggal_pembayaran;

                    $batasKonfirmasi =
                        $waktuPembayaran
                            ->copy()
                            ->addMinutes(15);

                    $sekarang = now();

                    $selisihDetik =
                        $sekarang->diffInSeconds(
                            $batasKonfirmasi,
                            false
                        );

                    if ($selisihDetik > 0) {

                        $menitTersisa =
                            ceil($selisihDetik / 60);

                        $kelasWaktu = 'warning';

                        $teksWaktu =
                            $menitTersisa .
                            ' menit tersisa';

                    } else {

                        $menitTerlambat =
                            ceil(abs($selisihDetik) / 60);

                        $kelasWaktu = 'danger';

                        $teksWaktu =
                            $menitTerlambat .
                            ' menit terlambat';
                    }

                @endphp


                <div class="admin-payment-alert-item">

                    <div class="admin-payment-alert-info">

                        <strong>
                            TRX-{{ str_pad(
                                $item->id_pembayaran,
                                3,
                                '0',
                                STR_PAD_LEFT
                            ) }}
                        </strong>

                        <span>
                            {{ $item->pemesanan->user->nama
                                ?? 'Pelanggan' }}
                        </span>

                        <small>

                            {{ $item->metode_pembayaran === 'transfer'
                                ? 'Transfer Bank'
                                : 'Cash'
                            }}

                            •

                            Rp{{ number_format(
                                $item->total_pembayaran,
                                0,
                                ',',
                                '.'
                            ) }}

                        </small>

                    </div>


                    <div
                        class="admin-payment-alert-time {{ $kelasWaktu }}"
                    >

                        ⚠️ {{ $teksWaktu }}

                    </div>

                </div>

            @empty

                <div class="admin-payment-alert-empty">

                    <span>
                        ✅
                    </span>

                    <div>

                        <strong>
                            Tidak ada pembayaran yang perlu diperiksa.
                        </strong>

                        <p>
                            Semua pembayaran dalam kondisi aman.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>

    </div>


    {{-- =====================================================
         PEMBAYARAN TERBARU
    ====================================================== --}}

    <div class="admin-card">

        <div class="admin-card-header">

            <div>

                <h2>
                    Pembayaran Terbaru
                </h2>

                <p>
                    Aktivitas pembayaran terbaru.
                </p>

            </div>

            <a href="{{ route('admin.pembayaran') }}">
                Lihat Semua
            </a>

        </div>


        <div class="admin-table-wrapper">

            <table class="admin-table">

                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Pelanggan
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($pembayaranTerbaru as $item)

                        @php

                            $status = $item->status_verifikasi;

                        @endphp

                        <tr>

                            <td>
                                TRX-{{ str_pad(
                                    $item->id_pembayaran,
                                    3,
                                    '0',
                                    STR_PAD_LEFT
                                ) }}
                            </td>

                            <td>
                                {{ $item->pemesanan->user->nama
                                    ?? 'Pelanggan' }}
                            </td>

                            <td>
                                Rp{{ number_format(
                                    $item->total_pembayaran,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </td>

                            <td>

                                @if ($status === 'diterima')

                                    <span class="admin-badge success">
                                        Lunas
                                    </span>

                                @elseif ($status === 'ditolak')

                                    <span class="admin-badge danger">
                                        Ditolak
                                    </span>

                                @else

                                    <span class="admin-badge pending">
                                        Menunggu
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td>
                                -
                            </td>

                            <td colspan="2">
                                Belum ada pembayaran
                            </td>

                            <td>

                                <span class="admin-badge pending">
                                    Belum Ada
                                </span>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
         STOK BBM
    ====================================================== --}}

    <div class="admin-card">

        <div class="admin-card-header">

            <div>

                <h2>
                    Stok BBM
                </h2>

                <p>
                    Persediaan BBM saat ini.
                </p>

            </div>

            <a href="{{ route('admin.stok') }}">
                Kelola
            </a>

        </div>


        @forelse ($stok as $item)

            @php

                if ($item->produk->status !== 'aktif') {

                    $stokTampil = 0;

                    $persentase = 0;

                } else {

                    $stokTampil =
                        $item->jumlah_stok;

                    $batasVisual = 3000;

                    $persentase = min(
                        ($stokTampil / $batasVisual) * 100,
                        100
                    );

                }

            @endphp


            <div class="admin-stock-item">

                <div class="admin-stock-header">

                    <span>
                        {{ $item->produk->nama_produk }}
                    </span>

                    <strong>
                        {{ number_format(
                            $stokTampil,
                            0,
                            ',',
                            '.'
                        ) }}
                        L
                    </strong>

                </div>


                <div class="admin-stock-bar">

                    <div
                        class="admin-stock-progress"
                        style="width: {{ $persentase }}%;">
                    </div>

                </div>

            </div>

        @empty

            <div class="admin-stock-item">

                <div class="admin-stock-header">

                    <span>
                        Belum ada produk
                    </span>

                    <strong>
                        0 L
                    </strong>

                </div>

                <div class="admin-stock-bar">

                    <div
                        class="admin-stock-progress"
                        style="width: 0%;">
                    </div>

                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection