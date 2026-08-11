@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<div class="dashboard-header">
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, {{ Auth::user()->nama }}</p>
</div>


{{-- =========================
    STATISTIK
========================= --}}

<div class="admin-stat-grid">

    {{-- PENJUALAN HARI INI --}}
    <div class="admin-stat-card">
        <div>
            <p>Penjualan Hari Ini</p>
            <h2>Rp 0</h2>
        </div>

        <div class="admin-stat-icon">
            💰
        </div>
    </div>


    {{-- TOTAL TRANSAKSI --}}
    <div class="admin-stat-card">
        <div>
            <p>Total Transaksi</p>
            <h2>0</h2>
        </div>

        <div class="admin-stat-icon">
            🛒
        </div>
    </div>


    {{-- PESANAN HARI INI --}}
    <div class="admin-stat-card">
        <div>
            <p>Pesanan Hari Ini</p>
            <h2>0</h2>
        </div>

        <div class="admin-stat-icon">
            📋
        </div>
    </div>


    {{-- TOTAL STOK BBM --}}
    <div class="admin-stat-card">
        <div>
            <p>Total Stok BBM</p>
            <h2>0 L</h2>
        </div>

        <div class="admin-stat-icon">
            ⛽
        </div>
    </div>

</div>


{{-- =========================
    INFORMASI DASHBOARD
========================= --}}

<div class="admin-dashboard-grid">

    {{-- TRANSAKSI TERBARU --}}
    <div class="admin-card">

        <div class="admin-card-header">

            <div>
                <h2>Transaksi Terbaru</h2>
                <p>Transaksi yang baru dilakukan</p>
            </div>

            <a href="#">
                Lihat Semua
            </a>

        </div>


        <div class="admin-table-wrapper">

            <table class="admin-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>-</td>

                        <td colspan="2">
                            Belum ada transaksi
                        </td>

                        <td>
                            <span class="admin-badge pending">
                                Belum Ada
                            </span>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>


    {{-- STOK BBM --}}
    <div class="admin-card">

        <div class="admin-card-header">

            <div>
                <h2>Stok BBM</h2>
                <p>Persediaan BBM saat ini</p>
            </div>

            <a href="#">
                Kelola
            </a>

        </div>


        {{-- PERTAMAX --}}
        <div class="admin-stock-item">

            <div class="admin-stock-header">
                <span>Pertamax</span>
                <strong>0 L</strong>
            </div>

            <div class="admin-stock-bar">

                <div
                    class="admin-stock-progress"
                    style="width: 0%;">
                </div>

            </div>

        </div>


        {{-- DEXLITE --}}
        <div class="admin-stock-item">

            <div class="admin-stock-header">
                <span>Dexlite</span>
                <strong>0 L</strong>
            </div>

            <div class="admin-stock-bar">

                <div
                    class="admin-stock-progress"
                    style="width: 0%;">
                </div>

            </div>

        </div>

    </div>

</div>

@endsection