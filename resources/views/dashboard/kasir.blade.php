@extends('layouts.kasir')

@section('title', 'Dashboard Kasir')

@section('content')

    {{-- HEADER --}}
    <div class="dashboard-header">

        <h1>Dashboard Kasir</h1>

        <p>
            Selamat datang, {{ Auth::user()->nama }}
        </p>

    </div>


    {{-- STATISTIK --}}
    <div class="stat-grid">

        {{-- TRANSAKSI HARI INI --}}
        <div class="stat-card">

            <div class="stat-header">

                <div>

                    <div class="stat-title">
                        Transaksi Hari Ini
                    </div>

                    <div class="stat-value">
                        {{ $transaksiHariIni }}
                    </div>

                </div>

                <div class="stat-icon">
                    🛒
                </div>

            </div>

        </div>


        {{-- PENJUALAN HARI INI --}}
        <div class="stat-card">

            <div class="stat-header">

                <div>

                    <div class="stat-title">
                        Penjualan Hari Ini
                    </div>

                    <div class="stat-value">
                        Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}
                    </div>

                </div>

                <div class="stat-icon">
                    💰
                </div>

            </div>

        </div>


    </div>


    {{-- PESANAN PERLU DIPROSES --}}
    <div class="card">

        <div class="card-header">

            <h2>
                Pesanan Perlu Diproses
            </h2>

            <a href="{{ route('kasir.pesanan') }}">
                Lihat Semua
            </a>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>ID Pesanan</th>
                        <th>Customer</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Status</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($pesananPerluDiproses as $pesanan)

                        <tr>

                            <td>
                                #{{ $pesanan->id_pemesanan }}
                            </td>

                            <td>
                                {{ $pesanan->user->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $pesanan->produk->nama_produk ?? '-' }}
                            </td>

                            <td>
                                {{ number_format($pesanan->jumlah_liter, 2, ',', '.') }} L
                            </td>

                            <td>

                                <span class="badge badge-warning">
                                    Menunggu Pengambilan
                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5">

                                Belum ada pesanan yang perlu diproses.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- AKSI CEPAT --}}
    <div class="card">

        <div class="card-header">

            <h2>
                Aksi Cepat
            </h2>

        </div>


        <div class="quick-action">

    <a
        href="{{ route('kasir.pos') }}"
        class="btn-mulai-pos"
    >
        <span class="btn-pos-icon">🛒</span>

        <span class="btn-pos-text">
            Mulai Transaksi POS
        </span>

     </a>

        </div>

    </div>

@endsection