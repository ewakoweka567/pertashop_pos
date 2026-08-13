@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')

<div class="add-product-page">

    <div class="add-product-header">
        <h1>Tambah Produk BBM</h1>
        <p>Tambahkan produk BBM baru ke dalam sistem.</p>
    </div>

    <div class="add-product-card">

        <form>

            <div class="form-group">
                <label for="name">Nama Produk</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Contoh: Pertamax Turbo">
            </div>

            <div class="form-group">
                <label for="price">Harga per Liter</label>

              <input
                  type="number"
                 id="price"
                 name="price"
                 placeholder="Contoh: 12900">
            </div>

            <div class="form-group">
                <label for="status">Status</label>

                <select id="status" name="status">

                    <option value="aktif" selected>
                        Aktif
                    </option>

                    <option value="nonaktif">
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