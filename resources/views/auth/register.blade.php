<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Register Pertashop</title>

    @vite([
        'resources/css/login.css',
        'resources/js/app.js'
    ])

</head>

<body>

<div class="container">

    <div class="card">

        <h1>PERTASHOP POS</h1>
        @if ($errors->any())
    <div style="background:#ffd6d6; color:red; padding:10px; margin-bottom:15px; border-radius:8px;">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

        <p>CV Dwi Tirta Agung</p>

        <form method="POST" action="{{ route('register') }}">

            @csrf

            <input
                type="text"
                name="nama"
                placeholder="Masukkan Nama Lengkap"
                value="{{ old('nama') }}"
                required>

            <input
                type="email"
                name="email"
                placeholder="Masukkan Email"
                value="{{ old('email') }}"
                required>

            <input
                type="text"
                name="no_hp"
                placeholder="Masukkan Nomor HP"
                value="{{ old('no_hp') }}"
                required>

            <input
                type="password"
                name="password"
                placeholder="Masukkan Password"
                required>

            <input
                type="password"
                name="password_confirmation"
                placeholder="Konfirmasi Password"
                required>

            <button type="submit">
                Daftar
            </button>

        </form>

        <div class="register">
            Sudah punya akun?
            <a href="{{ route('login') }}">
                Masuk
            </a>
        </div>

    </div>

</div>

</body>
</html>
