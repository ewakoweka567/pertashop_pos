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


    <form>

        <div class="form-group">

            <label for="nama">
                Produk
            </label>

            <input
                type="text"
                id="nama"
                value="{{ $id == 1 ? 'Pertamax' : 'Dexlite' }}"
                disabled
            >

        </div>


        <div class="form-group">

            <label for="stok">
                Jumlah Stok Saat Ini
            </label>

            <input
                type="number"
                id="stok"
                name="stok"
                value="{{ $id == 1 ? 850 : 250 }}"
                min="0"
            >

        </div>


        <div class="form-actions">

            <a href="/admin/stok" class="btn-cancel">
                Batal
            </a>

            <button type="button" class="btn-save">
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection