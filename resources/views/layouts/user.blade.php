<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard User')</title>

    @vite(['resources/css/user.css'])
</head>

<body>

    <div class="user-wrapper">

        {{-- =========================
             SIDEBAR
        ========================== --}}

        <aside class="sidebar">

            <div class="brand">

                <h2>PERTASHOP POS</h2>

                <p>CV Dwi Tirta Agung</p>

            </div>


            <nav class="menu">

                <div class="menu-title">
                    Menu Utama
                </div>


                {{-- Dashboard --}}

                <a href="/dashboard/user" class="active">
                    🏠 Dashboard
                </a>


                {{-- Produk BBM --}}

                <a href="#">
                    ⛽ Produk & Stok
                </a>


                {{-- Pemesanan --}}

                <a href="#">
                    🛒 Pemesanan BBM
                </a>


                {{-- Pesanan --}}

                <a href="#">
                    📋 Pesanan Saya
                </a>


                {{-- Pembayaran --}}

                <a href="#">
                    💳 Pembayaran
                </a>


                <div class="menu-title">
                    Akun
                </div>


                {{-- Profil --}}

                <a href="{{ route('user.profile') }}">
                👤  Profil
                </a>

            </nav>


            {{-- LOGOUT --}}

            <div class="logout">

                <form action="#" method="POST">

                    @csrf

                    <button type="submit">
                        🚪 Logout
                    </button>

                </form>

            </div>

        </aside>



        {{-- =========================
             MAIN CONTENT
        ========================== --}}

        <div class="main-content">


            {{-- TOPBAR --}}

            <header class="topbar">

                <div class="topbar-title">

                    @yield('title', 'Dashboard User')

                </div>


                <div class="profile">

                    <div class="profile-info">

                        <div class="profile-name">

                            {{ Auth::user()->nama }}

                        </div>

                        <div class="profile-role">

                            User

                        </div>

                    </div>


                    <div class="profile-avatar">

                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}

                    </div>

                </div>

            </header>



            {{-- =========================
                 CONTENT
            ========================== --}}

            <main class="content">

                @yield('content')

            </main>


        </div>

    </div>

</body>

</html>