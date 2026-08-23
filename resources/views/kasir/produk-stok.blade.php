@extends('layouts.kasir')

@section('title', 'Produk & Stok')

@section('content')

<div class="dashboard-header">

    <h1>
        Produk & Stok
    </h1>

    <p>
        Informasi ketersediaan BBM untuk operasional kasir.
    </p>

</div>


<div class="kasir-product-grid">

    @forelse ($stok as $item)

        <div class="kasir-product-card">


            {{-- HEADER PRODUK --}}

            <div class="kasir-product-header">

                <div>

                    <h2>
                        {{ $item->produk->nama_produk }}
                    </h2>

                    <p>
                        BBM Non Subsidi
                    </p>

                </div>


                <span class="kasir-product-status">
                    Aktif
                </span>

            </div>


            {{-- STOK TERSEDIA --}}

            <div class="kasir-product-stock">

                <strong>
                    {{ number_format(
                        $item->stok_tersedia,
                        2,
                        ',',
                        '.'
                    ) }}
                </strong>

                <span>
                    L
                </span>

            </div>


            <p class="kasir-product-stock-label">
                Tersedia
            </p>


            {{-- HARGA --}}

            <div class="kasir-product-price">

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


        </div>

    @empty


        <div class="kasir-empty">

            <div class="kasir-empty-icon">
                📦
            </div>

            <h3>
                Belum Ada Produk
            </h3>

            <p>
                Belum ada produk aktif yang tersedia.
            </p>

        </div>


    @endforelse

</div>

@endsection