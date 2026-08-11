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

        <div class="stat-card">

            <div class="stat-header">

                <div>
                    <div class="stat-title">
                        Transaksi Hari Ini
                    </div>

                    <div class="stat-value">
                        0
                    </div>
                </div>

                <div class="stat-icon">
                    🛒
                </div>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-header">

                <div>
                    <div class="stat-title">
                        Penjualan Hari Ini
                    </div>

                    <div class="stat-value">
                        Rp 0
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

            <a href="#">
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
                        <th>Status</th>
                    </tr>

                </thead>


                <tbody>

                    <tr>

                        <td>
                            -
                        </td>

                        <td>
                            Belum ada
                        </td>

                        <td>
                            -
                        </td>

                        <td>

                            <span class="badge badge-warning">
                                Belum ada pesanan
                            </span>

                        </td>

                    </tr>

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


        <div>

            <a href="{{ route('kasir.pos') }}">
              🛒 Mulai Transaksi POS
            </a>

            <br><br>

            <a href="#">
                📋 Lihat Pesanan
            </a>

        </div>

    </div>

@endsection