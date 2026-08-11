@extends('layouts.admin')

@section('title', 'Pengguna')

@section('content')

<div class="page-header">
    <div>
        <h1>Pengguna</h1>
        <p>Kelola pengguna dan hak akses sistem.</p>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h2>Daftar Pengguna</h2>
    </div>

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>Administrator</td>
                    <td>admin</td>
                    <td>Admin</td>
                    <td>
                        <span class="badge badge-success">
                            Aktif
                        </span>
                    </td>
                    <td>
                        <a href="#">Edit</a>
                    </td>
                </tr>

                <tr>
                    <td>Kasir Test</td>
                    <td>kasir</td>
                    <td>Kasir</td>
                    <td>
                        <span class="badge badge-success">
                            Aktif
                        </span>
                    </td>
                    <td>
                        <a href="#">Edit</a>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection