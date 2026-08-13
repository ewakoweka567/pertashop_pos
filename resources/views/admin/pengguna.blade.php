@extends('layouts.admin')

@section('title', 'Pengguna')

@section('content')

<div class="page-header">
    <div>
        <h1>Pengguna</h1>
        <p>Kelola akun pengguna sistem.</p>
    </div>
</div>

<div class="card">

    <div class="table-header">
        <h2>Daftar Pengguna</h2>

        <input
            type="text"
            class="search-input"
            placeholder="🔎 Cari pengguna..."
        >
    </div>

    <div class="table-wrapper">
        <table class="user-table">

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

                    <td>
                        <span class="badge badge-admin">
                            Admin
                        </span>
                    </td>

                    <td>
                        <span class="badge badge-active">
                            Aktif
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('admin.pengguna.edit', 1) }}" class="btn-edit">
                             Edit
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>Kasir Test</td>
                    <td>kasir</td>

                    <td>
                        <span class="badge badge-kasir">
                            Kasir
                        </span>
                    </td>

                    <td>
                        <span class="badge badge-active">
                            Aktif
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('admin.pengguna.edit', 1) }}" class="btn-edit">
                         Edit
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>User Test</td>
                    <td>user</td>

                    <td>
                        <span class="badge badge-user">
                            User
                        </span>
                    </td>

                    <td>
                        <span class="badge badge-active">
                            Aktif
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('admin.pengguna.edit', 1) }}" class="btn-edit">
                         Edit
                        </a>
                    </td>
                </tr>

            </tbody>

        </table>
    </div>

</div>

@endsection