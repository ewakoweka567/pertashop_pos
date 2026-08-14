@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')

<div class="page-header">

    <div>
        <h1>Edit Produk</h1>
        <p>Perbarui informasi produk BBM.</p>
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
                name="nama_produk"
                value="{{ $produk->nama_produk }}"
                required
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

        <div class="form-group">

            <label for="status">
                Status
            </label>

            <select
                id="status"
                name="status"
                required
            >

                <option
                    value="aktif"
                    {{ $produk->status === 'aktif' ? 'selected' : '' }}
                >
                    Aktif
                </option>

                <option
                    value="tidak_aktif"
                    {{ $produk->status === 'tidak_aktif' ? 'selected' : '' }}
                >
                    Tidak Aktif
                </option>

            </select>

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