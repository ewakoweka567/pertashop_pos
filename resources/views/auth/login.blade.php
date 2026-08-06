<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Pertashop</title>

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
    <p style="color:red; margin-bottom:15px;">
        {{ $errors->first() }}
    </p>
@endif

        <p>CV Dwi Tirta Agung</p>

        <form method="POST" action="{{ route('login') }}">

    @csrf

            <input
    type="email"
    name="email"
    value="{{ old('email') }}"
    placeholder="Masukkan Email"
    required>

           <input
    type="password"
    name="password"
    placeholder="Masukkan Password"
    required>
            <button type="submit">

    Masuk

</button>

        </form>

        <div class="register">

            Belum punya akun?
<a href="{{ route('register') }}">
    Daftar
</a>

        </div>

    </div>

</div>

</body>
</html>