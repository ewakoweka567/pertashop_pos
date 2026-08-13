@extends('layouts.admin')

@section('title', 'Produk')

@section('content')

<div class="page-header">
    <div>
        <h1>Produk BBM</h1>
        <p>Informasi harga dan ketersediaan produk BBM.</p>
    </div>

    <a href="{{ route('admin.produk.create') }}" class="btn-add-product">
     + Tambah Produk
    </a>
</div>

<div class="product-grid">

    {{-- Pertamax --}}
    <div class="card product-card">

        <div class="product-icon">
            ⛽
        </div>

        <div class="product-info">
            <h2>Pertamax</h2>

            <p class="product-price">
                Rp 12.900 <span>/ Liter</span>
            </p>

            <p class="product-stock">
                Stok: <strong>Tersedia</strong>
            </p>
        </div>

        <div class="product-action">
            <a href="/admin/produk/1/edit" class="btn-edit">
              Edit Harga
            </a>
        </div>

    </div>


    {{-- Dexlite --}}
    <div class="card product-card">

        <div class="product-icon">
            ⛽
        </div>

        <div class="product-info">
            <h2>Dexlite</h2>

            <p class="product-price">
                Rp 14.200 <span>/ Liter</span>
            </p>

            <p class="product-stock">
                Stok: <strong>Tersedia</strong>
            </p>
        </div>

        <div class="product-action">
            <a href="/admin/produk/2/edit" class="btn-edit">
               Edit Harga
            </a>
        </div>

    </div>

</div>

@endsection