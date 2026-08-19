<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Dashboard User')
    </title>

    @vite(['resources/css/user.css'])

</head>


<body>

    <div class="user-wrapper">


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
                    href="{{ url('/dashboard/user') }}"
                    class="active"
                >
                    🏠 Dashboard
                </a>


                {{-- PRODUK & STOK --}}

                <a href="#">
                    ⛽ Produk & Stok
                </a>


                {{-- PEMESANAN BBM --}}

                <a href="#">
                    🛒 Pemesanan BBM
                </a>


                {{-- PESANAN SAYA --}}

                <a href="#">
                    📋 Pesanan Saya
                </a>


                {{-- PROFIL --}}

                <a href="{{ route('user.profile') }}">
                    👤 Profil
                </a>

            </nav>


        </aside>



        {{-- =====================================================
             MAIN CONTENT
        ====================================================== --}}

        <div class="main-content">


            {{-- =================================================
                 TOPBAR
            ================================================== --}}

            <header class="topbar">


                {{-- JUDUL HALAMAN --}}

                <div class="topbar-title">

                    @yield(
                        'title',
                        'Dashboard User'
                    )

                </div>


                {{-- AREA KANAN --}}

                <div
                    class="topbar-actions"
                    style="
                        display: flex;
                        align-items: center;
                        gap: 20px;
                    "
                >



                    {{-- PROFILE --}}

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


                </div>


            </header>



            {{-- =================================================
                 CONTENT
            ================================================== --}}

            <main class="content">

                @yield('content')

            </main>


        </div>

    </div>


</body>

</html>