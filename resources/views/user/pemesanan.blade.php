@extends('layouts.user')

@section('title', 'Pemesanan BBM')

@section('content')

<div class="dashboard-header">

    <h1>
        Pemesanan BBM
    </h1>

    <p>
        Pilih produk dan jumlah BBM yang ingin dipesan.
    </p>

</div>


<div class="card">

    <form
        action="{{ route('user.pemesanan.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf


        {{-- PRODUK --}}

        <div class="form-group">

            <label for="id_produk">
                Produk BBM
            </label>

            <select
                name="id_produk"
                id="id_produk"
                required
            >

                <option value="">
    Pilih Produk
</option>

@foreach ($stok as $item)

    @php

        $stokTersedia = max(
            $item->jumlah_stok - $item->stok_reservasi,
            0
        );

    @endphp

    <option
        value="{{ $item->id_produk }}"
        data-harga="{{ $item->produk->harga_per_liter }}"
        data-stok="{{ $stokTersedia }}"
        @selected(
            old('id_produk', $produkDipilih)
            == $item->id_produk
        )
    >
        {{ $item->produk->nama_produk }}
        -
        Rp{{ number_format(
            $item->produk->harga_per_liter,
            0,
            ',',
            '.'
        ) }}/L
        -
        Stok {{ number_format(
            $stokTersedia,
            0,
            ',',
            '.'
        ) }} L
    </option>

@endforeach

            </select>

        </div>


        {{-- JUMLAH --}}

        <div class="form-group">

            <label for="jumlah_liter">
                Jumlah Liter
            </label>

            <input
    type="number"
    name="jumlah_liter"
    id="jumlah_liter"
    min="1"
    step="0.01"
    value="{{ old('jumlah_liter', $jumlahDipilih) }}"
    required
>

            <small id="stockInfo">
                Pilih produk terlebih dahulu.
            </small>

        </div>


        {{-- TOTAL --}}

        <div class="form-group">

            <label>
                Total Harga
            </label>

            <strong id="totalHarga">
                Rp0
            </strong>

        </div>


        {{-- METODE PEMBAYARAN --}}

        <div class="form-group">

            <label>
                Metode Pembayaran
            </label>


            <label>

                <input
                    type="radio"
                    name="metode_pembayaran"
                    value="transfer"
                    required
                >

                Transfer Bank

            </label>


            <label>

                <input
                    type="radio"
                    name="metode_pembayaran"
                    value="tunai"
                >

                Cash

            </label>

        </div>


        {{-- TRANSFER --}}

        <div
            id="transferSection"
            style="display: none;"
        >

            <div class="card">

                <h3>
                    Pembayaran Transfer
                </h3>


                <p>
                    Silakan transfer ke rekening BRI:
                </p>

                <strong>
                    789601024567539
                </strong>


                <div class="form-group">

                    <label for="bukti_transfer">
                        Lampirkan Bukti Pembayaran
                    </label>

                    <input
                        type="file"
                        name="bukti_transfer"
                        id="bukti_transfer"
                        accept="image/*"
                    >

                </div>

            </div>

        </div>


        {{-- CASH --}}

        <div
            id="cashSection"
            style="display: none;"
        >

            <div class="card">

                <h3>
                    Pembayaran Cash
                </h3>

                <p>
                    Silakan melakukan pembayaran cash
                    kepada admin. Pembayaran akan
                    menunggu konfirmasi admin.
                </p>

            </div>

        </div>


        {{-- SUBMIT --}}

        <button
            type="submit"
            class="quick-action"
        >
            🛒 Buat Pesanan
        </button>

    </form>

</div>


<script>

    const produkSelect =
        document.getElementById('id_produk');

    const jumlahInput =
        document.getElementById('jumlah_liter');

    const totalHarga =
        document.getElementById('totalHarga');

    const stockInfo =
        document.getElementById('stockInfo');

    const transferSection =
        document.getElementById('transferSection');

    const cashSection =
        document.getElementById('cashSection');

    const buktiTransfer =
        document.getElementById('bukti_transfer');


    /*
    |--------------------------------------------------------------------------
    | HITUNG TOTAL
    |--------------------------------------------------------------------------
    */

    function hitungTotal()
    {
        const option =
            produkSelect.options[
                produkSelect.selectedIndex
            ];

        if (!option || !option.value) {

            totalHarga.textContent = 'Rp0';

            stockInfo.textContent =
                'Pilih produk terlebih dahulu.';

            return;
        }


        const harga =
            Number(
                option.dataset.harga
            );

        const stok =
            Number(
                option.dataset.stok
            );

        const jumlah =
            Number(
                jumlahInput.value
            );


        stockInfo.textContent =
            'Stok tersedia: '
            + stok.toLocaleString('id-ID')
            + ' Liter';


        if (jumlah > stok) {

            stockInfo.textContent =
                'Stok tidak mencukupi. Tersedia '
                + stok.toLocaleString('id-ID')
                + ' Liter.';

        }


        const total =
            harga * jumlah;


        totalHarga.textContent =
            'Rp'
            + total.toLocaleString('id-ID');
    }


    /*
    |--------------------------------------------------------------------------
    | METODE PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            'input[name="metode_pembayaran"]'
        )
        .forEach(function (radio) {

            radio.addEventListener(
                'change',
                function () {

                    if (
                        this.value === 'transfer'
                    ) {

                        transferSection
                            .style
                            .display = 'block';

                        cashSection
                            .style
                            .display = 'none';

                        buktiTransfer.required = true;

                    } else {

                        transferSection
                            .style
                            .display = 'none';

                        cashSection
                            .style
                            .display = 'block';

                        buktiTransfer.required = false;

                    }

                }
            );

        });


produkSelect.addEventListener(
    'change',
    hitungTotal
);

jumlahInput.addEventListener(
    'input',
    hitungTotal
);


/*
|--------------------------------------------------------------------------
| INISIALISASI SAAT HALAMAN DIBUKA
|--------------------------------------------------------------------------
*/

hitungTotal();


const metodeTerpilih =
    document.querySelector(
        'input[name="metode_pembayaran"]:checked'
    );

if (metodeTerpilih) {

    metodeTerpilih.dispatchEvent(
        new Event('change')
    );

}

</script>

@endsection