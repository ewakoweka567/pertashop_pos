@extends('layouts.admin')

@section('title', 'Kelola Stok BBM')

@section('content')

<div class="page-header">

    <div>
        <h1>Kelola Stok BBM</h1>
        <p>Perbarui jumlah stok BBM.</p>
    </div>

</div>

<div class="card product-edit-card">

    <div class="card-header">
        <h2>Informasi Stok</h2>
    </div>

    <form
        action="{{ route('admin.stok.update', $stok->id_stok) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div class="form-group">

            <label for="nama">
                Produk
            </label>

            <input
                type="text"
                id="nama"
                value="{{ $stok->produk->nama_produk }}"
                disabled
            >

        </div>

        <div class="form-group">

            <label for="jumlah_stok">
                Jumlah Stok Saat Ini
            </label>

            <input
                type="number"
                id="jumlah_stok"
                name="jumlah_stok"
                value="{{ number_format($stok->jumlah_stok, 0, '.', '') }}"
                min="0"
                step="0.01"
                required
            >

        </div>

        <div class="form-actions">

            <a
                href="{{ route('admin.stok') }}"
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