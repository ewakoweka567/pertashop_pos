@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('content')

<div class="page-header">
    <div>
        <h1>Pembayaran</h1>
        <p>Kelola dan pantau pembayaran transaksi pelanggan.</p>
    </div>
</div>


{{-- RINGKASAN PEMBAYARAN --}}

<div class="payment-summary">

    <div class="card payment-summary-card">
        <span>Menunggu Konfirmasi</span>
        <strong>3</strong>
    </div>

    <div class="card payment-summary-card">
        <span>Sudah Dibayar</span>
        <strong>22</strong>
    </div>

    <div class="card payment-summary-card">
        <span>Total Pembayaran</span>
        <strong>Rp 4.250.000</strong>
    </div>

</div>


{{-- METODE PEMBAYARAN --}}

<div class="card payment-method-card">

    <div class="card-header">
        <h2>Metode Pembayaran</h2>
        <p>Metode pembayaran yang tersedia dalam sistem.</p>
    </div>


    <div class="payment-method-grid">

        {{-- TRANSFER BANK --}}

        <div class="payment-method">

            <div class="payment-method-icon">
                🏦
            </div>

            <div class="payment-method-info">

                <h3>Transfer Bank</h3>

                <p>
                    Pembayaran melalui rekening perusahaan.
                </p>

                <span class="payment-status manual">
                    Konfirmasi Manual
                </span>

            </div>

        </div>


        {{-- BRI VA --}}

        <div class="payment-method">

            <div class="payment-method-icon">
                🏦
            </div>

            <div class="payment-method-info">

                <h3>BRI Virtual Account</h3>

                <p>
                    Pembayaran melalui Virtual Account BRI.
                </p>

                <span class="payment-status automatic">
                    Otomatis
                </span>

            </div>

        </div>


        {{-- BNI VA --}}

        <div class="payment-method">

            <div class="payment-method-icon">
                🏦
            </div>

            <div class="payment-method-info">

                <h3>BNI Virtual Account</h3>

                <p>
                    Pembayaran melalui Virtual Account BNI.
                </p>

                <span class="payment-status automatic">
                    Otomatis
                </span>

            </div>

        </div>


        {{-- CASH --}}

        <div class="payment-method">

            <div class="payment-method-icon">
                💵
            </div>

            <div class="payment-method-info">

                <h3>Cash</h3>

                <p>
                    Pembayaran secara tunai kepada kasir.
                </p>

                <span class="payment-status manual">
                    Konfirmasi Manual
                </span>

            </div>

        </div>

    </div>

</div>


{{-- DAFTAR PEMBAYARAN --}}

<div class="card payment-table-card">

    <div class="card-header">

        <div>
            <h2>Daftar Pembayaran</h2>
            <p>Transaksi yang membutuhkan pemantauan pembayaran.</p>
        </div>

    </div>


    <div class="table-wrapper">

        <table class="data-table">

            <thead>

                <tr>
                    <th>ID Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Metode</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

            </thead>


            <tbody>

                {{-- TRANSAKSI 1 --}}

                <tr>

                    <td>
                        TRX-001
                    </td>

                    <td>
                        Budi
                    </td>

                    <td>
                        Transfer Bank
                    </td>

                    <td>
                        Rp 129.000
                    </td>

                    <td>
                        <span class="badge badge-warning">
                            Menunggu
                        </span>
                    </td>

                    <td>
                        <a href="#" class="btn-table">
                            Periksa
                        </a>
                    </td>

                </tr>


                {{-- TRANSAKSI 2 --}}

                <tr>

                    <td>
                        TRX-002
                    </td>

                    <td>
                        Andi
                    </td>

                    <td>
                        BRI VA
                    </td>

                    <td>
                        Rp 200.000
                    </td>

                    <td>
                        <span class="badge badge-success">
                            Dibayar
                        </span>
                    </td>

                    <td>
                        <a href="#" class="btn-table">
                            Detail
                        </a>
                    </td>

                </tr>


                {{-- TRANSAKSI 3 --}}

                <tr>

                    <td>
                        TRX-003
                    </td>

                    <td>
                        Sinta
                    </td>

                    <td>
                        Cash
                    </td>

                    <td>
                        Rp 142.000
                    </td>

                    <td>
                        <span class="badge badge-warning">
                            Menunggu
                        </span>
                    </td>

                    <td>
                        <a href="#" class="btn-table">
                            Konfirmasi
                        </a>
                    </td>

                </tr>


                {{-- TRANSAKSI 4 --}}

                <tr>

                    <td>
                        TRX-004
                    </td>

                    <td>
                        Rudi
                    </td>

                    <td>
                        BNI VA
                    </td>

                    <td>
                        Rp 250.000
                    </td>

                    <td>
                        <span class="badge badge-success">
                            Dibayar
                        </span>
                    </td>

                    <td>
                        <a href="#" class="btn-table">
                            Detail
                        </a>
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection