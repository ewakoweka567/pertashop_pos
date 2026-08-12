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


    <form>

        <div class="form-group">

            <label for="nama">
                Nama Produk
            </label>

            <input
                type="text"
                id="nama"
                value="{{ $id == 1 ? 'Pertamax' : 'Dexlite' }}"
                disabled
            >

        </div>


        <div class="form-group">

            <label for="harga">
                Harga per Liter
            </label>

            <input
                type="number"
                id="harga"
                name="harga"
                value="{{ $id == 1 ? 12900 : 14200 }}"
            >

        </div>


        <div class="form-actions">

            <a href="/admin/produk" class="btn-cancel">
                Batal
            </a>

            <button type="button" class="btn-save">
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection