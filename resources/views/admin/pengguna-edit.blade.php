@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')

<div class="page-header">

    <div>
        <h1>Edit Pengguna</h1>
        <p>Perbarui informasi pengguna.</p>
    </div>

</div>


<div class="card product-edit-card">

    <div class="card-header">
        <h2>Informasi Pengguna</h2>
    </div>


    <form
        action="{{ route('admin.pengguna.update', $pengguna->id_user) }}"
        method="POST">

        @csrf
        @method('PUT')


        <div class="form-group">

            <label for="nama">
                Nama
            </label>

            <input
                type="text"
                id="nama"
                name="nama"
                value="{{ old('nama', $pengguna->nama) }}"
                required
            >

        </div>


        <div class="form-group">

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $pengguna->email) }}"
                required
            >

        </div>


        <div class="form-group">

            <label for="no_hp">
                No. HP
            </label>

            <input
                type="text"
                id="no_hp"
                name="no_hp"
                value="{{ old('no_hp', $pengguna->no_hp) }}"
                maxlength="15"
                required
            >

        </div>


        <div class="form-group">

            <label for="role">
                Role
            </label>

            <select
                id="role"
                name="role"
                required>

                <option
                    value="admin"
                    {{ $pengguna->role === 'admin' ? 'selected' : '' }}>
                    Admin
                </option>

                <option
                    value="kasir"
                    {{ $pengguna->role === 'kasir' ? 'selected' : '' }}>
                    Kasir
                </option>

                <option
                    value="user"
                    {{ $pengguna->role === 'user' ? 'selected' : '' }}>
                    User
                </option>

            </select>

        </div>


        <div class="form-group">

            <label for="status">
                Status
            </label>

            <select
                id="status"
                name="status"
                required>

                <option
                    value="aktif"
                    {{ $pengguna->status === 'aktif' ? 'selected' : '' }}>
                    Aktif
                </option>

                <option
                    value="tidak_aktif"
                    {{ $pengguna->status === 'tidak_aktif' ? 'selected' : '' }}>
                    Tidak Aktif
                </option>

            </select>

        </div>


        <div class="form-actions">

            <a
                href="{{ route('admin.pengguna') }}"
                class="btn-cancel">
                Batal
            </a>

            <button
                type="submit"
                class="btn-save">
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection