@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | DATA DETAIL PEMBAYARAN UNTUK MODAL
    |--------------------------------------------------------------------------
    */

    $detailPembayaran = $pembayaran->mapWithKeys(function ($item) {

        $namaPelanggan =
            $item->pemesanan->user->nama ?? 'Pelanggan';

        $namaProduk =
            $item->pemesanan->produk->nama_produk ?? '-';

        $jumlahLiter =
            $item->pemesanan->jumlah_liter ?? 0;

        $bukti =
            $item->bukti_transfer
            ? asset('storage/' . ltrim($item->bukti_transfer, '/'))
            : null;

        return [

            $item->id_pembayaran => [

                'transaksi' => 'TRX-' . str_pad(
                    $item->id_pembayaran,
                    3,
                    '0',
                    STR_PAD_LEFT
                ),

                'pelanggan' => $namaPelanggan,

                'produk' => $namaProduk,

                'jumlah' => $jumlahLiter,

                'total' => $item->total_pembayaran,

                'metode' => $item->metode_pembayaran,

                'status' => $item->status_verifikasi,

                'bukti' => $bukti,

            ],

        ];

    })->toArray();

@endphp


<div class="payment-page">


    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="payment-header">

        <h1>
            Pembayaran
        </h1>

        <p>
            Kelola dan konfirmasi pembayaran pelanggan.
        </p>

    </div>


    {{-- =========================================================
         RINGKASAN
    ========================================================== --}}

    <div class="payment-summary">


        {{-- MENUNGGU PEMBAYARAN --}}

        <div class="summary-card">

            <span>
                Menunggu Pembayaran
            </span>

            <strong>
                {{ $menungguPembayaran }}
            </strong>

            <small>
                Belum melakukan pembayaran
            </small>

        </div>


        {{-- MENUNGGU KONFIRMASI --}}

        <div class="summary-card">

            <span>
                Menunggu Konfirmasi
            </span>

            <strong>
                {{ $menungguKonfirmasi }}
            </strong>

            <small>
                Perlu diperiksa admin
            </small>

        </div>


        {{-- LUNAS --}}

        <div class="summary-card">

            <span>
                Lunas
            </span>

            <strong>
                {{ $lunas }}
            </strong>

            <small>
                Pembayaran berhasil
            </small>

        </div>

    </div>


    {{-- =========================================================
         PESAN BERHASIL
    ========================================================== --}}

    @if (session('success'))

        <div class="payment-alert success">

            {{ session('success') }}

        </div>

    @endif


    {{-- =========================================================
         DAFTAR PEMBAYARAN
    ========================================================== --}}

    <div class="payment-section">


        <div class="section-header">

            <div>

                <h2>
                    Daftar Pembayaran
                </h2>

                <p>
                    Transaksi yang membutuhkan pemantauan pembayaran.
                </p>

            </div>

        </div>


        <div class="payment-table-wrapper">


            <table class="payment-table">


                <thead>

                    <tr>

                        <th>
                            ID Transaksi
                        </th>

                        <th>
                            Pelanggan
                        </th>

                        <th>
                            Metode
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @forelse ($pembayaran as $item)

                        @php

                            $idTransaksi =
                                'TRX-' . str_pad(
                                    $item->id_pembayaran,
                                    3,
                                    '0',
                                    STR_PAD_LEFT
                                );

                            $namaPelanggan =
                                $item->pemesanan->user->nama
                                ?? 'Pelanggan';

                            $metode =
                                $item->metode_pembayaran;

                            $status =
                                $item->status_verifikasi;

                        @endphp


                        <tr>


                            {{-- ID TRANSAKSI --}}

                            <td>

                                <strong>
                                    {{ $idTransaksi }}
                                </strong>

                            </td>


                            {{-- PELANGGAN --}}

                            <td>

                                <strong>
                                    {{ $namaPelanggan }}
                                </strong>

                            </td>


                            {{-- METODE --}}

                            <td>

                                @if ($metode === 'transfer')

                                    <span class="payment-method transfer">
                                        🏦 Transfer Bank
                                    </span>

                                @else

                                    <span class="payment-method cash">
                                        💵 Cash
                                    </span>

                                @endif

                            </td>


                            {{-- TOTAL --}}

                            <td>

                                <strong>

                                    Rp{{ number_format(
                                        $item->total_pembayaran,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </strong>

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if ($status === 'menunggu')


                                    @if ($metode === 'transfer')

                                        <span class="payment-status waiting">
                                            Menunggu Konfirmasi
                                        </span>

                                    @else

                                        <span class="payment-status unpaid">
                                            Menunggu Pembayaran
                                        </span>

                                    @endif


                                @elseif ($status === 'diterima')

                                    <span class="payment-status paid">
                                        ✓ Lunas
                                    </span>


                                @else

                                    <span class="payment-status rejected">
                                        Ditolak
                                    </span>

                                @endif

                            </td>


                            {{-- =================================================
                                 AKSI
                            ================================================== --}}

                            <td>


                                <div class="payment-actions">


                                    {{-- DETAIL --}}

                                    <button
                                        type="button"
                                        class="btn-detail"
                                        onclick="showPaymentDetail({{ $item->id_pembayaran }})"
                                    >
                                        {{ $status === 'menunggu'
                                            ? 'Detail'
                                            : 'Lihat Detail'
                                        }}
                                    </button>


                                    {{-- =================================================
                                         PEMBAYARAN MENUNGGU
                                    ================================================== --}}

                                    @if ($status === 'menunggu')


                                        {{-- KONFIRMASI --}}

                                        <form
                                            action="{{ route(
                                                'admin.pembayaran.konfirmasi',
                                                $item->id_pembayaran
                                            ) }}"
                                            method="POST"
                                            style="display: inline;"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn-confirm"
                                                onclick="return confirm(
                                                    'Konfirmasi pembayaran transaksi ini?'
                                                )"
                                            >
                                                Konfirmasi
                                            </button>

                                        </form>


                                        {{-- TOLAK --}}

                                        <form
                                            action="{{ route(
                                                'admin.pembayaran.tolak',
                                                $item->id_pembayaran
                                            ) }}"
                                            method="POST"
                                            style="display: inline;"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn-reject"
                                                onclick="return confirm(
                                                    'Tolak pembayaran ini? Reservasi stok akan dikembalikan.'
                                                )"
                                            >
                                                Tolak
                                            </button>

                                        </form>


                                    @endif


                                </div>

                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="6"
                                style="text-align: center;"
                            >

                                Belum ada data pembayaran.

                            </td>

                        </tr>


                    @endforelse


                </tbody>


            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     MODAL DETAIL PEMBAYARAN
========================================================= --}}

<div
    id="detailModal"
    class="payment-modal"
>

    <div
        class="payment-modal-content detail-modal"
    >


        <button
            type="button"
            class="modal-close"
            onclick="closeDetailModal()"
        >
            ×
        </button>


        <h2>
            Detail Pembayaran
        </h2>


        <div class="detail-list">


            <div>

                <span>
                    ID Transaksi
                </span>

                <strong id="detailTransaction">
                    -
                </strong>

            </div>


            <div>

                <span>
                    Pelanggan
                </span>

                <strong id="detailCustomer">
                    -
                </strong>

            </div>


            <div>

                <span>
                    Produk
                </span>

                <strong id="detailProduct">
                    -
                </strong>

            </div>


            <div>

                <span>
                    Jumlah
                </span>

                <strong id="detailQuantity">
                    -
                </strong>

            </div>


            <div>

                <span>
                    Total
                </span>

                <strong id="detailTotal">
                    -
                </strong>

            </div>


            <div>

                <span>
                    Metode Pembayaran
                </span>

                <strong id="detailMethod">
                    -
                </strong>

            </div>


            <div>

                <span>
                    Status
                </span>

                <strong id="detailStatus">
                    -
                </strong>

            </div>


        </div>


        {{-- =====================================================
             BUKTI TRANSFER
        ====================================================== --}}

        <div class="proof-section">

            <h3>
                Bukti Pembayaran
            </h3>


            <a
                id="detailProof"
                href="#"
                target="_blank"
                class="btn-proof"
                style="display: none;"
            >
                📎 Lihat Bukti Transfer
            </a>


            <p id="noProof">
                Tidak ada bukti transfer.
            </p>

        </div>


        {{-- TOMBOL TUTUP --}}

        <div class="modal-actions">

            <button
                type="button"
                class="btn-cancel"
                onclick="closeDetailModal()"
            >
                Tutup
            </button>

        </div>


    </div>

</div>


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

<script>

    /*
    |--------------------------------------------------------------------------
    | DATA PEMBAYARAN DARI DATABASE
    |--------------------------------------------------------------------------
    */

    const paymentData = @json($detailPembayaran);


    /*
    |--------------------------------------------------------------------------
    | DETAIL PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    function showPaymentDetail(paymentId)
    {
        const data = paymentData[paymentId];

        if (!data) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | ID TRANSAKSI
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            'detailTransaction'
        ).textContent = data.transaksi;


        /*
        |--------------------------------------------------------------------------
        | PELANGGAN
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            'detailCustomer'
        ).textContent = data.pelanggan;


        /*
        |--------------------------------------------------------------------------
        | PRODUK
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            'detailProduct'
        ).textContent = data.produk;


        /*
        |--------------------------------------------------------------------------
        | JUMLAH
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            'detailQuantity'
        ).textContent =
            Number(data.jumlah).toLocaleString('id-ID')
            + ' Liter';


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            'detailTotal'
        ).textContent =
            'Rp'
            + Number(data.total).toLocaleString('id-ID');


        /*
        |--------------------------------------------------------------------------
        | METODE
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            'detailMethod'
        ).textContent =
            data.metode === 'transfer'
                ? 'Transfer Bank'
                : 'Cash';


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        let statusText = '-';


        if (data.status === 'menunggu') {

            statusText =
                data.metode === 'transfer'
                    ? 'Menunggu Konfirmasi'
                    : 'Menunggu Pembayaran';

        }
        else if (data.status === 'diterima') {

            statusText = 'Lunas';

        }
        else if (data.status === 'ditolak') {

            statusText = 'Ditolak';

        }


        document.getElementById(
            'detailStatus'
        ).textContent = statusText;


        /*
        |--------------------------------------------------------------------------
        | BUKTI TRANSFER
        |--------------------------------------------------------------------------
        */

        const proof =
            document.getElementById('detailProof');

        const noProof =
            document.getElementById('noProof');


        if (
            data.metode === 'transfer'
            && data.bukti
        ) {

            proof.href = data.bukti;

            proof.style.display =
                'inline-flex';

            noProof.style.display =
                'none';

        }
        else {

            proof.removeAttribute('href');

            proof.style.display =
                'none';

            noProof.style.display =
                'block';

        }


        /*
        |--------------------------------------------------------------------------
        | BUKA MODAL
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('detailModal')
            .classList.add('show');
    }


    /*
    |--------------------------------------------------------------------------
    | TUTUP MODAL DETAIL
    |--------------------------------------------------------------------------
    */

    function closeDetailModal()
    {
        document
            .getElementById('detailModal')
            .classList.remove('show');
    }

</script>


{{-- =========================================================
     STYLE TAMBAHAN UNTUK AKSI
========================================================= --}}

<style>

    .payment-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }


    .payment-actions form {
        margin: 0;
    }


    .btn-reject {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        padding: 9px 14px;

        border: none;
        border-radius: 8px;

        background: #6b7280;
        color: #ffffff;

        font-size: 13px;
        font-weight: 600;

        cursor: pointer;

        white-space: nowrap;

    }


    .btn-reject:hover {
        background: #4b5563;
    }


    .payment-alert.success {

        margin-bottom: 20px;

        padding: 14px 18px;

        border-radius: 10px;

        background: #dcfce7;

        color: #166534;

        font-size: 14px;

        font-weight: 600;

    }


    .btn-proof {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        padding: 10px 14px;

        border-radius: 8px;

        background: #f3f4f6;

        color: #1f3b64;

        text-decoration: none;

        font-size: 13px;

        font-weight: 600;

    }


    .btn-proof:hover {
        background: #e5e7eb;
    }

</style>


@endsection