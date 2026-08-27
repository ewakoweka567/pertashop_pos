<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Transaksi POS | Pertashop POS')
    </title>

    @vite([
        'resources/css/pos.css'
    ])

</head>

<body>

    <div class="pos-fullscreen">

        {{-- TOPBAR POS --}}
        <header class="pos-topbar">

            <a
                href="{{ route('kasir.dashboard') }}"
                class="pos-back-button"
            >
                <span>←</span>
                <span>Kembali ke Dashboard</span>
            </a>


            <div class="pos-brand">

                <strong>
                    PERTASHOP POS
                </strong>

                <span>
                    Transaksi Penjualan
                </span>

            </div>


            <div class="pos-user">

                <div class="pos-user-info">

                    <strong>
                        {{ Auth::user()->nama }}
                    </strong>

                    <span>
                        Kasir
                    </span>

                </div>

                <div class="pos-user-avatar">

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

        <main class="pos-content">

            @yield('content')

        </main>

    </div>

</body>

</html>