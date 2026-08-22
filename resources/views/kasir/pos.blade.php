@extends('layouts.kasir')

@section('title', 'Transaksi POS')

@section('content')

<div class="pos-page">

    <div class="dashboard-header">

        <h1>
            Transaksi POS
        </h1>

        <p>
            Input transaksi penjualan langsung.
        </p>

    </div>


    {{-- SUCCESS --}}

    @if (request()->has('sukses'))

        @php
            $transaksiBerhasil =
                \App\Models\PenjualanPos::with('produk')
                    ->find(request('sukses'));
        @endphp


        @if ($transaksiBerhasil)

            <div class="pos-success">

                <div>

                    <strong>
                        ✓ Transaksi berhasil disimpan
                    </strong>

                    <p>
                        {{
                            $transaksiBerhasil->produk->nama_produk
                        }}
                        ·
                        {{
                            number_format(
                                $transaksiBerhasil->jumlah_liter,
                                2,
                                ',',
                                '.'
                            )
                        }}
                        Liter
                        ·
                        Rp{{ number_format(
                            $transaksiBerhasil->total_harga,
                            0,
                            ',',
                            '.'
                        ) }}
                    </p>

                </div>


                <div class="pos-success-actions">

                    <a
    href="{{ route(
        'kasir.struk',
        $transaksiBerhasil->id_penjualan
    ) }}"
    class="pos-secondary-button"
>
    🖨 Cetak Struk
</a>


                    <a
                        href="{{ route('kasir.pos') }}"
                        class="pos-primary-button"
                    >
                        + Transaksi Baru
                    </a>

                </div>

            </div>

        @endif

    @endif


    <div class="pos-layout">


        {{-- =================================================
             FORM POS
        ================================================== --}}

        <div class="pos-main-card">

            <form
                action="{{ route('kasir.pos.store') }}"
                method="POST"
                id="posForm"
            >

                @csrf


                {{-- PRODUK --}}

                <div class="pos-form-group">

                    <label for="id_produk">
                        Produk
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
                                    $item->jumlah_stok
                                    - $item->stok_reservasi,
                                    0
                                );

                            @endphp


                            <option
                                value="{{ $item->id_produk }}"
                                data-harga="{{ $item->produk->harga_per_liter }}"
                                data-stok="{{ $stokTersedia }}"
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
                                Stok
                                {{ number_format(
                                    $stokTersedia,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                                L

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- JUMLAH --}}

                <div class="pos-form-group">

                    <label for="jumlah_liter">
                        Jumlah Liter
                    </label>

                    <input
                        type="number"
                        name="jumlah_liter"
                        id="jumlah_liter"
                        min="0.01"
                        step="0.01"
                        placeholder="0"
                        required
                    >


                    <small id="posStockInfo">
                        Pilih produk terlebih dahulu.
                    </small>

                </div>


                {{-- HARGA --}}

                <div class="pos-total-box">

                    <div class="pos-total-label">
                        Total
                    </div>

                    <div
                        class="pos-total-value"
                        id="posTotal"
                    >
                        Rp0
                    </div>

                </div>


                {{-- METODE --}}

                <input
                    type="hidden"
                    name="metode_pembayaran"
                    id="metodePembayaran"
                    value="tunai"
                >


                {{-- TOMBOL --}}

                <div class="pos-actions">

                    <button
                        type="submit"
                        class="pos-primary-button"
                        id="btnSimpan"
                    >
                        💾 Simpan Transaksi
                    </button>


                    <button
                        type="button"
                        class="pos-qris-button"
                        id="btnQris"
                    >
                        ▣ QRIS
                    </button>

                </div>

            </form>

        </div>


        {{-- =================================================
             INFO SINGKAT
        ================================================== --}}

        <div class="pos-side-card">

            <h2>
                Informasi Transaksi
            </h2>

            <div class="pos-info-row">

                <span>
                    Metode
                </span>

                <strong id="metodeInfo">
                    Tunai
                </strong>

            </div>


            <div class="pos-info-row">

                <span>
                    Stok tersedia
                </span>

                <strong id="stokInfo">
                    -
                </strong>

            </div>


            <div class="pos-info-row">

                <span>
                    Harga / Liter
                </span>

                <strong id="hargaInfo">
                    -
                </strong>

            </div>

        </div>

    </div>
    {{-- =========================================================
     MODAL QRIS
========================================================= --}}

<div
    id="qrisModal"
    class="qris-modal"
    aria-hidden="true"
>

    <div class="qris-modal-box">

        <button
            type="button"
            class="qris-close"
            id="qrisClose"
        >
            ×
        </button>


        <div class="qris-header">

            <h2>
                Pembayaran QRIS
            </h2>

            <p>
                Scan QRIS menggunakan aplikasi pembayaran Anda.
            </p>

        </div>


        <div class="qris-amount">

            <span>
                Total Pembayaran
            </span>

            <strong id="qrisAmount">
                Rp0
            </strong>

        </div>


        <div class="qris-code">

            {{-- GANTI DENGAN QRIS MILIK TOKO --}}

            <img
                src="{{ asset('images/qris-pertashop.jpeg') }}"
                alt="QRIS Pertashop"
            >

        </div>


        <p class="qris-note">
            Pastikan nominal pembayaran sesuai dengan total transaksi.
        </p>


        <div class="qris-actions">

            <button
                type="button"
                class="qris-success-button"
                id="qrisPaid"
            >
                ✓ Pembayaran Berhasil
            </button>


            <button
                type="button"
                class="qris-cancel-button"
                id="qrisCancel"
            >
                Batal
            </button>

        </div>

    </div>

</div>

</div>


<script>

    /* =========================================================
       ELEMENT POS
    ========================================================= */

    const produkSelect =
        document.getElementById('id_produk');

    const jumlahInput =
        document.getElementById('jumlah_liter');

    const posTotal =
        document.getElementById('posTotal');

    const posStockInfo =
        document.getElementById('posStockInfo');

    const stokInfo =
        document.getElementById('stokInfo');

    const hargaInfo =
        document.getElementById('hargaInfo');

    const metodeInfo =
        document.getElementById('metodeInfo');

    const metodePembayaran =
        document.getElementById('metodePembayaran');

    const btnSimpan =
        document.getElementById('btnSimpan');

    const btnQris =
        document.getElementById('btnQris');

    const posForm =
        document.getElementById('posForm');


    /* =========================================================
       ELEMENT MODAL QRIS
    ========================================================= */

    const qrisModal =
        document.getElementById('qrisModal');

    const qrisAmount =
        document.getElementById('qrisAmount');

    const qrisClose =
        document.getElementById('qrisClose');

    const qrisCancel =
        document.getElementById('qrisCancel');

    const qrisPaid =
        document.getElementById('qrisPaid');


    /* =========================================================
       HITUNG POS
    ========================================================= */

    function hitungPOS()
    {
        const option =
            produkSelect.options[
                produkSelect.selectedIndex
            ];


        const jumlah =
            Number(
                jumlahInput.value
            ) || 0;


        /* -----------------------------------------------------
           BELUM PILIH PRODUK
        ----------------------------------------------------- */

        if (
            !option ||
            !option.value
        ) {

            posTotal.textContent =
                'Rp0';

            posStockInfo.textContent =
                'Pilih produk terlebih dahulu.';

            stokInfo.textContent =
                '-';

            hargaInfo.textContent =
                '-';

            btnSimpan.disabled =
                true;

            btnQris.disabled =
                true;

            return;
        }


        /* -----------------------------------------------------
           DATA PRODUK
        ----------------------------------------------------- */

        const harga =
            Number(
                option.dataset.harga
            );


        const stok =
            Number(
                option.dataset.stok
            );


        stokInfo.textContent =
            stok.toLocaleString('id-ID')
            + ' L';


        hargaInfo.textContent =
            'Rp'
            + harga.toLocaleString('id-ID');


        posStockInfo.textContent =
            'Stok tersedia: '
            + stok.toLocaleString('id-ID')
            + ' Liter';


        /* -----------------------------------------------------
           VALIDASI JUMLAH
        ----------------------------------------------------- */

        if (
            jumlah <= 0 ||
            jumlah > stok
        ) {

            posTotal.textContent =
                'Rp0';


            if (jumlah > stok) {

                posStockInfo.textContent =
                    '⚠ Stok tidak mencukupi. Maksimal '
                    + stok.toLocaleString('id-ID')
                    + ' Liter.';

            }


            btnSimpan.disabled =
                true;

            btnQris.disabled =
                true;

            return;
        }


        /* -----------------------------------------------------
           HITUNG TOTAL
        ----------------------------------------------------- */

        const total =
            harga * jumlah;


        posTotal.textContent =
            'Rp'
            + total.toLocaleString('id-ID');


        btnSimpan.disabled =
            false;

        btnQris.disabled =
            false;
    }


    /* =========================================================
       EVENT PRODUK
    ========================================================= */

    produkSelect.addEventListener(
        'change',
        hitungPOS
    );


    jumlahInput.addEventListener(
        'input',
        hitungPOS
    );


    /* =========================================================
       TOMBOL QRIS
    ========================================================= */

    btnQris.addEventListener(
        'click',
        function () {

            const option =
                produkSelect.options[
                    produkSelect.selectedIndex
                ];


            const jumlah =
                Number(
                    jumlahInput.value
                ) || 0;


            /* Validasi */

            if (
                !option ||
                !option.value ||
                jumlah <= 0
            ) {

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


            if (jumlah > stok) {

                return;
            }


            const total =
                harga * jumlah;


            /* Tampilkan nominal di modal */

            qrisAmount.textContent =
                'Rp'
                + total.toLocaleString('id-ID');


            /* Buka modal */

            qrisModal.classList.add(
                'show'
            );

            qrisModal.setAttribute(
                'aria-hidden',
                'false'
            );

        }
    );


    /* =========================================================
       TUTUP MODAL QRIS
    ========================================================= */

    function tutupQris()
    {
        qrisModal.classList.remove(
            'show'
        );

        qrisModal.setAttribute(
            'aria-hidden',
            'true'
        );
    }


    qrisClose.addEventListener(
        'click',
        tutupQris
    );


    qrisCancel.addEventListener(
        'click',
        tutupQris
    );


    /* =========================================================
       PEMBAYARAN QRIS BERHASIL
    ========================================================= */

    qrisPaid.addEventListener(
    'click',
    function () {

        metodePembayaran.value = 'qris';

        metodeInfo.textContent = 'QRIS';

        if (!posForm.checkValidity()) {
            posForm.reportValidity();
            return;
        }

        tutupQris();

        posForm.requestSubmit();
    }
);


    /* =========================================================
       SIMPAN TRANSAKSI TUNAI
    ========================================================= */

    posForm.addEventListener(
        'submit',
        function () {

            /*
            | Kalau user tidak lewat QRIS,
            | otomatis dianggap tunai.
            */

            if (
                metodePembayaran.value
                !== 'qris'
            ) {

                metodePembayaran.value =
                    'tunai';

            }

        }
    );


    /* =========================================================
       INISIALISASI
    ========================================================= */

    hitungPOS();

</script>

@endsection