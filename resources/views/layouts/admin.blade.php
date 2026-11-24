
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Pertashop POS')</title>

    @vite(['resources/css/admin.css'])

    <style>
        /* Dropdown Logout Admin */
        .profile {
            position: relative;
            cursor: pointer;
        }

        .profile-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            min-width: 150px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 6px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.12);
            z-index: 9999;
        }

        .profile:hover .profile-dropdown,
        .profile:focus-within .profile-dropdown {
            display: block;
        }

        .logout-button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 11px 12px;
            border: none;
            border-radius: 7px;
            background: transparent;
            color: #dc2626;
            font-size: 14px;
            font-weight: 600;
            text-align: left;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .logout-button:hover {
            background: #fee2e2;
        }
    </style>
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

                {{-- PROFILE + LOGOUT --}}
                <div class="profile" tabindex="0">

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

                    {{-- DROPDOWN LOGOUT --}}
                    <div class="profile-dropdown">

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf

                            <button type="submit" class="logout-button">
                    
                                <span>Logout</span>
                            </button>

                        </form>

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
