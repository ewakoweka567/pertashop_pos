<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Pertashop POS')</title>

    @vite(['resources/css/admin.css'])
</head>

<body>

    <div class="admin-wrapper">

        {{-- SIDEBAR --}}
        <aside class="sidebar">

            <div class="brand">
                <h2>PERTASHOP POS</h2>
                <p>CV Dwi Tirta Agung</p>
            </div>

            <nav class="menu">

                <div class="menu-title">
                    Menu Utama
                </div>

                <a href="/dashboard/admin" class="active">
                    🏠 Dashboard
                </a>

                <a href="#">
                    📦 Produk
                </a>

                <a href="#">
                    ⛽ Stok BBM
                </a>

                <a href="#">
                    🛒 Pemesanan
                </a>

                <a href="#">
                    💳 Pembayaran
                </a>


                <div class="menu-title">
                    Laporan
                </div>

                <a href="#">
                    📊 Riwayat Transaksi
                </a>


                <div class="menu-title">
                    Pengelolaan
                </div>

                <a href="#">
                    👥 Pengguna
                </a>

            </nav>

        </aside>


        {{-- AREA UTAMA --}}
        <div class="main-content">

            {{-- TOPBAR --}}
            <header class="topbar">

                <div class="topbar-title">
                    @yield('title', 'Dashboard')
                </div>

                <div class="profile">

                    <div class="profile-info">

                        <div class="profile-name">
                            {{ Auth::user()->nama }}
                        </div>

                        <div class="profile-role">
                            {{ Auth::user()->role }}
                        </div>

                    </div>

                    <div class="profile-avatar">
                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                    </div>

                </div>

            </header>


            {{-- ISI HALAMAN --}}
            <main class="content">

                @yield('content')

            </main>

        </div>

    </div>

</body>

</html>