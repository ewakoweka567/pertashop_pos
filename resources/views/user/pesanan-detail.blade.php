@extends('layouts.user')

@section('title', 'Detail Pesanan')

@section('content')

<div class="dashboard-header">

    <div>

        <h1>
            Detail Pesanan
        </h1>

        <p>
            Informasi lengkap pesanan BBM Anda.
        </p>

    </div>

</div>


@php

    switch ($pesanan->status_pemesanan) {

        case 'menunggu_pembayaran':

            $statusText = 'Menunggu Pembayaran';
            $statusClass = 'warning';

            break;

        case 'menunggu_verifikasi':

            $statusText = 'Menunggu Konfirmasi';
            $statusClass = 'pending';

            break;

        case 'menunggu_pengambilan':

            $statusText = 'Menunggu Pengambilan';
            $statusClass = 'pickup';

            break;

        case 'selesai':

            $statusText = 'Selesai';
            $statusClass = 'success';

            break;

        case 'dibatalkan':

            $statusText = 'Dibatalkan';
            $statusClass = 'danger';

            break;

        default:

            $statusText = ucfirst(
                str_replace(
                    '_',
                    ' ',
                    $pesanan->status_pemesanan
                )
            );

            $statusClass = 'warning';

    }

@endphp


<div class="card">

    {{-- HEADER --}}

    <div class="card-header">

        <div>

            <h2>

                PM-{{
                    str_pad(
                        $pesanan->id_pemesanan,
                        3,
                        '0',
                        STR_PAD_LEFT
                    )
                }}

            </h2>

            <p>
                {{ $pesanan->tanggal_pemesanan
                    ? $pesanan->tanggal_pemesanan->format(
                        'd M Y, H:i'
                    )
                    : '-'
                }}
            </p>

        </div>


        <span class="user-order-status {{ $statusClass }}">

            {{ $statusText }}

        </span>

    </div>


    {{-- INFORMASI PESANAN --}}

    <div class="detail-list">

        <div>

            <span>
                Produk
            </span>

            <strong>
                {{ $pesanan->produk->nama_produk }}
            </strong>

        </div>


        <div>

            <span>
                Jumlah
            </span>

            <strong>
                {{ number_format(
                    $pesanan->jumlah_liter,
                    2,
                    ',',
                    '.'
                ) }}
                Liter
            </strong>

        </div>


        <div>

            <span>
                Harga per Liter
            </span>

            <strong>
                Rp{{ number_format(
                    $pesanan->produk->harga_per_liter,
                    0,
                    ',',
                    '.'
                ) }}
            </strong>

        </div>


        <div>

            <span>
                Total Harga
            </span>

            <strong>
                Rp{{ number_format(
                    $pesanan->total_harga,
                    0,
                    ',',
                    '.'
                ) }}
            </strong>

        </div>

    </div>


    {{-- PEMBAYARAN --}}

    <div class="user-detail-section">

        <h3>
            Pembayaran
        </h3>


        @if ($pesanan->pembayaran)

            <div class="detail-list">

                <div>

                    <span>
                        Metode Pembayaran
                    </span>

                    <strong>

                        {{
                            $pesanan->pembayaran->metode_pembayaran
                                === 'transfer'
                                ? 'Transfer Bank'
                                : 'Cash'
                        }}

                    </strong>

                </div>


                <div>

                    <span>
                        Status Pembayaran
                    </span>

                    <strong>

                        @if (
                            $pesanan->pembayaran->status_verifikasi
                            === 'diterima'
                        )

                            Lunas

                        @elseif (
                            $pesanan->pembayaran->status_verifikasi
                            === 'ditolak'
                        )

                            Ditolak

                        @else

                            Menunggu Verifikasi

                        @endif

                    </strong>

                </div>

            </div>

        @else

            <p>
                Data pembayaran belum tersedia.
            </p>

        @endif

    </div>


    {{-- TOMBOL --}}

    <div style="margin-top: 25px;">

        <a
            href="{{ route('user.pesanan') }}"
            class="quick-action"
        >
            Kembali ke Pesanan Saya
        </a>

    </div>

</div>

@endsection