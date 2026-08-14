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

    @foreach ($produk as $item)

        <div class="card product-card">

            <div class="product-icon">
                ⛽
            </div>

            <div class="product-info">

                <h2>{{ $item->nama_produk }}</h2>

                <p class="product-price">
                    Rp {{ number_format($item->harga_per_liter, 0, ',', '.') }}
                    <span>/ Liter</span>
                </p>

                <p class="product-stock">
                    Status:
                    <strong>
                        {{ $item->status === 'aktif' ? 'Tersedia' : 'Tidak Tersedia' }}
                    </strong>
                </p>

            </div>

            <div class="product-action">
                <a
    href="{{ route('admin.produk.edit', $item->id_produk) }}"
    class="btn-edit">
    Edit Harga
</a>
            </div>

        </div>

    @endforeach

</div>

@endsection