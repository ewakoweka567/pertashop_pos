@extends('layouts.user')

@section('title', 'Produk & Stok')

@section('content')

<div class="dashboard-header">

    <div>

        <h1>
            Produk & Stok
        </h1>

        <p>
            Informasi produk dan ketersediaan BBM.
        </p>

    </div>

</div>


<div class="customer-product-grid">

    @forelse ($stok as $item)

        @php

            $stokFisik =
                (float) $item->jumlah_stok;

            $stokReservasi =
                (float) ($item->stok_reservasi ?? 0);

            $stokTersedia =
                max(
                    $stokFisik - $stokReservasi,
                    0
                );

        @endphp


        <div class="customer-product-card">


            {{-- HEADER PRODUK --}}

            <div class="customer-product-header">

                <div>

                    <h2>
                        {{ $item->produk->nama_produk }}
                    </h2>

                    <p>
                        BBM Non Subsidi
                    </p>

                </div>


                <div class="customer-product-icon">
                    ⛽
                </div>

            </div>


            {{-- HARGA --}}

            <div class="customer-product-price">

                Rp{{ number_format(
                    $item->produk->harga_per_liter,
                    0,
                    ',',
                    '.'
                ) }}

                <span>
                    / Liter
                </span>

            </div>


            {{-- STOK TERSEDIA --}}

            <div class="customer-product-stock">

                <strong>

                    {{ number_format(
                        $stokTersedia,
                        2,
                        ',',
                        '.'
                    ) }}

                </strong>

                <span>
                    Liter
                </span>

            </div>


            <p class="customer-product-stock-label">
                Tersedia
            </p>


            {{-- STATUS --}}

            @if ($stokTersedia > 0)

                <div class="customer-product-status available">
                    Tersedia
                </div>

                <a
                    href="{{ route('user.pemesanan') }}"
                    class="customer-product-button"
                >
                    🛒 Pesan BBM
                </a>

            @else

                <div class="customer-product-status unavailable">
                    Tidak Tersedia
                </div>

                <button
                    type="button"
                    class="customer-product-button disabled"
                    disabled
                >
                    Stok Habis
                </button>

            @endif


        </div>

    @empty

        <div class="card">

            <div
                style="
                    padding: 35px;
                    text-align: center;
                "
            >

                <h3>
                    Produk Belum Tersedia
                </h3>

                <p>
                    Belum ada BBM yang dapat ditampilkan.
                </p>

            </div>

        </div>

    @endforelse

</div>

@endsection