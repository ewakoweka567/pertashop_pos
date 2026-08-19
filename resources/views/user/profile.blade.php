@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')

<div class="page-header">

    <div>

        <h1>
            Profil Saya
        </h1>

        <p>
            Kelola informasi akun dan keamanan profil Anda.
        </p>

    </div>

</div>


@if (session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


@if ($errors->any())

    <div class="alert alert-danger">

        <strong>
            Periksa kembali data yang dimasukkan.
        </strong>

        <ul>

            @foreach ($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


<div class="card profile-card">

    <div class="card-header">

        <div>

            <h2>
                Informasi Profil
            </h2>

            <p>
                Data akun yang sedang digunakan.
            </p>

        </div>

    </div>


    <form
        action="{{ route('user.profile.update') }}"
        method="POST"
        class="profile-form"
    >

        @csrf

        @method('PUT')


        {{-- NAMA --}}

        <div class="form-group">

            <label for="nama">
                Nama
            </label>

            <input
                type="text"
                id="nama"
                name="nama"
                value="{{ old('nama', $user->nama) }}"
                required
            >

        </div>


        {{-- EMAIL --}}

        <div class="form-group">

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                required
            >

        </div>


        {{-- NO HP --}}

        <div class="form-group">

            <label for="no_hp">
                No. HP
            </label>

            <input
                type="text"
                id="no_hp"
                name="no_hp"
                value="{{ old('no_hp', $user->no_hp) }}"
                placeholder="Masukkan nomor HP"
            >

        </div>


        {{-- ROLE --}}

        <div class="form-group">

            <label>
                Role
            </label>

            <input
                type="text"
                value="{{ ucfirst($user->role) }}"
                disabled
            >

        </div>


        <hr>


        {{-- PASSWORD --}}

        <div class="card-header">

            <div>

                <h2>
                    Ubah Password
                </h2>

                <p>
                    Kosongkan jika tidak ingin mengubah password.
                </p>

            </div>

        </div>


        <div class="form-group">

            <label for="password">
                Password Baru
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Minimal 8 karakter"
            >

        </div>


        <div class="form-group">

            <label for="password_confirmation">
                Konfirmasi Password
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="Ulangi password baru"
            >

        </div>


        {{-- TOMBOL --}}

        <div class="profile-actions">

            <button
                type="submit"
                class="btn-save"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>


{{-- LOGOUT --}}

<div class="card profile-logout-card">

    <div>

        <h2>
            Keluar dari Akun
        </h2>

        <p>
            Anda akan keluar dari akun user ini.
        </p>

    </div>


    <form
        action="{{ route('logout') }}"
        method="POST"
    >

        @csrf

        <button
            type="submit"
            class="btn-logout"
            onclick="return confirm(
                'Yakin ingin keluar dari akun?'
            )"
        >
            Logout
        </button>

    </form>

</div>

@endsection