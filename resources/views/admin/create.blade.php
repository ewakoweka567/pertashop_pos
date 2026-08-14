@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')

<div class="add-product-page">

    <div class="add-product-header">
        <h1>Tambah Produk BBM</h1>
        <p>Tambahkan produk BBM baru ke dalam sistem.</p>
    </div>

    <div class="add-product-card">

        <form action="{{ route('admin.produk.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>

                <input
                    type="text"
                    id="nama_produk"
                    name="nama_produk"
                    placeholder="Contoh: Pertamax Turbo"
                    required>
            </div>

            <div class="form-group">
                <label for="harga_per_liter">Harga per Liter</label>

                <input
                    type="number"
                    id="harga_per_liter"
                    name="harga_per_liter"
                    placeholder="Contoh: 12900"
                    min="0"
                    required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>

                <select id="status" name="status">

                    <option value="aktif" selected>
                        Aktif
                    </option>

                    <option value="tidak_aktif">
                        Nonaktif
                    </option>

                </select>
            </div>

            <div class="form-actions">

                <a
                    href="{{ url('/admin/produk') }}"
                    class="btn-cancel-product">
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn-save-product">
                    Simpan Produk
                </button>

            </div>

        </form>

    </div>

</div>

@endsection