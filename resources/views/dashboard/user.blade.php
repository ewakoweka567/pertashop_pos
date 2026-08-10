@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')

    {{-- =========================
         HEADER
    ========================== --}}

    <div class="dashboard-header">

        <h1>
            Dashboard User
        </h1>

        <p>
            Selamat datang, {{ Auth::user()->nama }}
        </p>

    </div>


    {{-- =========================
         PRODUK BBM
    ========================== --}}

    <div class="product-grid">

        {{-- PERTAMAX --}}

        <div class="product-card">

            <div class="product-header">

                <div class="product-name">
                    Pertamax
                </div>

                <div class="product-icon">
                    ⛽
                </div>

            </div>


            <div class="product-price">
                Rp 12.900
            </div>

            <div class="product-unit">
                per Liter
            </div>


            <div class="product-stock">

                Stok:

                <span class="stock-available">
                    Tersedia
                </span>

            </div>

        </div>


        {{-- DEXLITE --}}

        <div class="product-card">

            <div class="product-header">

                <div class="product-name">
                    Dexlite
                </div>

                <div class="product-icon">
                    ⛽
                </div>

            </div>


            <div class="product-price">
                Rp 14.200
            </div>

            <div class="product-unit">
                per Liter
            </div>


            <div class="product-stock">

                Stok:

                <span class="stock-available">
                    Tersedia
                </span>

            </div>

        </div>

    </div>



    {{-- =========================
         PESANAN TERBARU
    ========================== --}}

    <div class="card">

        <div class="card-header">

            <h2>
                Pesanan Terbaru
            </h2>

            <a href="#">
                Lihat Semua
            </a>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            ID Pesanan
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
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <tr>

                        <td>
                            -
                        </td>

                        <td>
                            Belum ada pesanan
                        </td>

                        <td>
                            -
                        </td>

                        <td>
                            -
                        </td>

                        <td>

                            <span class="badge badge-warning">
                                Belum Ada
                            </span>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>



    {{-- =========================
         AKSI CEPAT
    ========================== --}}

    <div class="card">

        <div class="card-header">

            <h2>
                Aksi Cepat
            </h2>

        </div>


        <a href="#" class="quick-action">
            🛒 Pesan BBM
        </a>


        <a href="#" class="quick-action">
            📋 Pesanan Saya
        </a>

    </div>

@endsection