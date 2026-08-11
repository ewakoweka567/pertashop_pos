@extends('layouts.kasir')

@section('title', 'Transaksi POS')

@section('content')

<div class="pos-page">

    {{-- HEADER --}}
    <div class="pos-header">

        <div>
            <h1>Transaksi POS</h1>

            <p>
                Silakan pilih produk BBM untuk membuat transaksi.
            </p>
        </div>

    </div>


    {{-- POS AREA --}}
    <div class="pos-container">

        {{-- =========================
             PRODUK
        ========================== --}}

        <div class="pos-products">

            <h2>Pilih Produk</h2>


            <div class="product-list">

                {{-- PERTAMAX --}}

                <div class="pos-product-card">

                    <div class="product-icon">
                        ⛽
                    </div>

                    <div class="product-info">

                        <h3>Pertamax</h3>

                        <p class="product-price">
                            Rp 12.900 / Liter
                        </p>

                        <p class="product-stock">
                            Stok tersedia
                        </p>

                    </div>

                    <button class="btn-add">
                        + Tambah
                    </button>

                </div>


                {{-- DEXLITE --}}

                <div class="pos-product-card">

                    <div class="product-icon">
                        ⛽
                    </div>

                    <div class="product-info">

                        <h3>Dexlite</h3>

                        <p class="product-price">
                            Rp 14.200 / Liter
                        </p>

                        <p class="product-stock">
                            Stok tersedia
                        </p>

                    </div>

                    <button class="btn-add">
                        + Tambah
                    </button>

                </div>

            </div>

        </div>


        {{-- =========================
             KERANJANG
        ========================== --}}

        <div class="pos-cart">

            <h2>Keranjang</h2>


            {{-- ITEM PERTAMAX --}}

            <div class="cart-item">

                <div>

                    <h3>Pertamax</h3>

                    <p>
                        10 Liter × Rp 12.900
                    </p>

                </div>

                <strong>
                    Rp 129.000
                </strong>

            </div>


            {{-- ITEM DEXLITE --}}

            <div class="cart-item">

                <div>

                    <h3>Dexlite</h3>

                    <p>
                        5 Liter × Rp 14.200
                    </p>

                </div>

                <strong>
                    Rp 71.000
                </strong>

            </div>


            {{-- TOTAL --}}

            <div class="cart-total">

                <span>
                    Total
                </span>

                <strong>
                    Rp 200.000
                </strong>

            </div>


            {{-- BAYAR --}}

            <button class="btn-payment">
                Bayar
            </button>

        </div>

    </div>

</div>

@endsection