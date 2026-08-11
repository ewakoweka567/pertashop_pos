<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard Kasir')</title>

    @vite(['resources/css/kasir.css', 'resources/css/pos.css'])
    
</head>

<body>

    <div class="kasir-wrapper">

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

                <a href="/dashboard/kasir" class="active">
                    🏠 Dashboard
                </a>

                <a href="{{ route('kasir.pos') }}">
                     🛒 Transaksi POS
                </a>

                <a href="#">
                    📋 Pesanan
                </a>

                <a href="#">
                    📦 Produk & Stok
                </a>

                <div class="menu-title">
                    Transaksi
                </div>

                <a href="#">
                    🧾 Riwayat Transaksi
                </a>

            </nav>

        </aside>


        {{-- AREA UTAMA --}}
        <div class="main-content">

            {{-- TOPBAR --}}
            <header class="topbar">

                <div class="topbar-title">
                    @yield('title', 'Dashboard Kasir')
                </div>


                <div class="profile">

                    <div class="profile-info">

                        <div class="profile-name">
                            {{ Auth::user()->nama }}
                        </div>

                        <div class="profile-role">
                            Kasir
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