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

    <a href="/dashboard/admin"
   class="{{ request()->is('dashboard/admin') ? 'active' : '' }}">
    🏠 Dashboard
</a>

    <a href="/admin/produk"
   class="{{ request()->is('admin/produk') ? 'active' : '' }}">
    📦 Produk
 </a>

    <a href="/admin/stok"
   class="{{ request()->is('admin/stok') ? 'active' : '' }}">
    ⛽ Stok BBM
    </a>

    <a href="/admin/pembayaran"
   class="{{ request()->is('admin/pembayaran') ? 'active' : '' }}">
    💳 Pembayaran
    </a>

  <a href="{{ route('admin.riwayat') }}"
   class="{{ request()->is('admin/riwayat') ? 'active' : '' }}">
    📊 Riwayat Transaksi
</a>

    <a href="{{ route('admin.pengguna') }}"
   class="{{ request()->is('admin/pengguna') ? 'active' : '' }}">
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