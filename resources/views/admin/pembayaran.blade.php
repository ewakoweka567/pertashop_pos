@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('content')

<div class="page-header">
    <div>
        <h1>Pembayaran</h1>
        <p>Kelola dan lihat status pembayaran transaksi.</p>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h2>Daftar Pembayaran</h2>
    </div>

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>-</td>
                    <td>Belum ada transaksi</td>
                    <td>-</td>
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