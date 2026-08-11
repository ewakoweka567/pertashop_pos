@extends('layouts.admin')

@section('title', 'Riwayat Transaksi')

@section('content')

<div class="page-header">
    <div>
        <h1>Riwayat Transaksi</h1>
        <p>Daftar seluruh transaksi penjualan BBM.</p>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h2>Daftar Transaksi</h2>
    </div>

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td>Belum ada transaksi</td>
                    <td>-</td>
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