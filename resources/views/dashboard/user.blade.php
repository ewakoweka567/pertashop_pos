@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')

<div class="dashboard-header">

    <div>
        <h1>
            Dashboard User
        </h1>

        <p>
            Selamat datang, {{ Auth::user()->nama }}
        </p>
    </div>


    {{-- TOMBOL PESAN BBM KHUSUS DASHBOARD --}}

    <a
        href="#"
        class="quick-action"
        style="
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        "
    >
        🛒 Pesan BBM
    </a>

</div>



{{-- =========================================================
     PESANAN TERAKHIR ANDA
========================================================= --}}

<div class="card">

    <div class="card-header">

        <div>

            <h2>
                Pesanan Terakhir Anda
            </h2>

            <p>
                Ringkasan pesanan BBM terakhir Anda.
            </p>

        </div>

    </div>


    {{-- BELUM ADA PESANAN --}}

    <div
        style="
            padding: 30px 10px;
            text-align: center;
        "
    >

        <div
            style="
                font-size: 42px;
                margin-bottom: 10px;
            "
        >
            ⛽
        </div>

        <h3>
            Belum Ada Pesanan
        </h3>

        <p>
            Anda belum memiliki pesanan BBM.
        </p>


        <a
            href="#"
            class="quick-action"
            style="
                display: inline-block;
                margin-top: 15px;
            "
        >
            🛒 Pesan BBM
        </a>

    </div>

</div>


{{-- =========================================================
     PESANAN TERBARU
========================================================= --}}

<div class="card">

    <div class="card-header">

        <div>

            <h2>
                Pesanan Terbaru
            </h2>

            <p>
                Riwayat pesanan BBM Anda.
            </p>

        </div>


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

@endsection