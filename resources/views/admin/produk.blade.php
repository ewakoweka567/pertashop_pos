@extends('layouts.admin')

@section('title', 'Produk')

@section('content')

<div class="page-header">
    <div>
        <h1>Produk</h1>
        <p>Kelola produk BBM dan harga jual per liter.</p>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h2>Daftar Produk BBM</h2>
    </div>

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga / Liter</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>Pertamax</td>

                    <td>
                        Rp 12.900
                    </td>

                    <td>
                        <span class="badge badge-success">
                            Aktif
                        </span>
                    </td>

                    <td>
                        <a href="#">
                            Edit
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>Dexlite</td>

                    <td>
                        Rp 14.200
                    </td>

                    <td>
                        <span class="badge badge-success">
                            Aktif
                        </span>
                    </td>

                    <td>
                        <a href="#">
                            Edit
                        </a>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection