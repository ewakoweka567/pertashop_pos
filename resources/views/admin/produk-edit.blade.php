@extends('layouts.admin')

@section('title', 'Edit Harga Produk')

@section('content')

<div class="page-header">

    <div>
        <h1>Edit Harga Produk</h1>
        <p>Perbarui harga jual produk BBM.</p>
    </div>

</div>

<div class="card product-edit-card">

    <div class="card-header">
        <h2>Informasi Produk</h2>
    </div>

    <form
        action="{{ route('admin.produk.update', $produk->id_produk) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div class="form-group">

            <label for="nama_produk">
                Nama Produk
            </label>

            <input
                type="text"
                id="nama_produk"
                value="{{ $produk->nama_produk }}"
                disabled
            >

        </div>

        <div class="form-group">

            <label for="harga_per_liter">
                Harga per Liter
            </label>

            <input
                type="number"
                id="harga_per_liter"
                name="harga_per_liter"
                value="{{ $produk->harga_per_liter }}"
                required
            >

        </div>

        <div class="form-actions">

            <a
                href="{{ route('admin.produk') }}"
                class="btn-cancel"
            >
                Batal
            </a>

            <button
                type="submit"
                class="btn-save"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection