<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Kasir | Pertashop POS')
    </title>

    @vite([
        'resources/css/kasir.css',
        'resources/css/pos.css'
    ])

</head>


<body>

<div class="kasir-wrapper">


    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    <aside class="sidebar">

        {{-- BRAND --}}

        <div class="brand">

            <h2>
                PERTASHOP POS
            </h2>

            <p>
                CV Dwi Tirta Agung
            </p>

        </div>


        {{-- MENU --}}

        <nav class="menu">


            {{-- DASHBOARD --}}

            <a
                href="{{ route('kasir.dashboard') }}"
                class="{{
                    request()->routeIs('kasir.dashboard')
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    🏠
                </span>

                <span class="menu-text">
                    Dashboard
                </span>

            </a>


            {{-- TRANSAKSI POS --}}

            <a
                href="{{ route('kasir.pos') }}"
                class="{{
                    request()->routeIs('kasir.pos')
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    🛒
                </span>

                <span class="menu-text">
                    Transaksi POS
                </span>

            </a>


            {{-- PESANAN --}}

            @php

                $pesananSiapDiambil =
                    \App\Models\Pemesanan::where(
                        'status_pemesanan',
                        'menunggu_pengambilan'
                    )->count();

            @endphp


            <a
                href="{{ route('kasir.pesanan') }}"
                class="menu-link-with-badge {{
                    request()->routeIs('kasir.pesanan*')
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-link-main">

                    <span class="menu-icon">
                        📋
                    </span>

                    <span class="menu-text">
                        Pesanan
                    </span>

                </span>


                @if ($pesananSiapDiambil > 0)

                    <span class="menu-badge">
                        {{ $pesananSiapDiambil }}
                    </span>

                @endif

            </a>


            {{-- PRODUK & STOK --}}

            <a
                href="#"
                class="{{
                    request()->is('kasir/produk-stok')
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    📦
                </span>

                <span class="menu-text">
                    Produk & Stok
                </span>

            </a>


            {{-- RIWAYAT --}}

            <a
                href="#"
                class="{{
                    request()->is('kasir/riwayat*')
                        ? 'active'
                        : ''
                }}"
            >

                <span class="menu-icon">
                    🧾
                </span>

                <span class="menu-text">
                    Riwayat Transaksi
                </span>

            </a>


        </nav>

    </aside>



    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <div class="main-content">


        {{-- TOPBAR --}}

        <header class="topbar">


            <div class="topbar-title">

                @yield(
                    'title',
                    'Dashboard Kasir'
                )

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

                    {{
                        strtoupper(
                            substr(
                                Auth::user()->nama,
                                0,
                                1
                            )
                        )
                    }}

                </div>

            </div>

        </header>



        {{-- CONTENT --}}

        <main class="content">

            @yield('content')

        </main>


    </div>

</div>

</body>

</html>