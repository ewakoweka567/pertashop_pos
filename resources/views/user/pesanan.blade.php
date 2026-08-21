@extends('layouts.user')

@section('title', 'Pesanan Saya')

@section('content')

<div class="dashboard-header">

    <div>

        <h1>
            Pesanan Saya
        </h1>

        <p>
            Riwayat dan status pemesanan BBM Anda.
        </p>

    </div>

</div>


<div class="card">

    @if ($pesanan->count() > 0)

        <div class="user-order-list">

            @foreach ($pesanan as $item)

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | STATUS PESANAN
                    |--------------------------------------------------------------------------
                    */

                    switch ($item->status_pemesanan) {

                        case 'menunggu_pembayaran':

                            $statusClass =
                                'warning';

                            $statusIcon =
                                '⏳';

                            $statusText =
                                'Menunggu Pembayaran';

                            break;


                        case 'menunggu_verifikasi':

                            $statusClass =
                                'pending';

                            $statusIcon =
                                '🔍';

                            $statusText =
                                'Menunggu Konfirmasi';

                            break;


                        case 'menunggu_pengambilan':

                            $statusClass =
                                'pickup';

                            $statusIcon =
                                '📦';

                            $statusText =
                                'Menunggu Pengambilan';

                            break;


                        case 'selesai':

                            $statusClass =
                                'success';

                            $statusIcon =
                                '✓';

                            $statusText =
                                'Selesai';

                            break;


                        case 'dibatalkan':

                            $statusClass =
                                'danger';

                            $statusIcon =
                                '✕';

                            $statusText =
                                'Dibatalkan';

                            break;


                        default:

                            $statusClass =
                                'warning';

                            $statusIcon =
                                '•';

                            $statusText =
                                ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $item->status_pemesanan
                                    )
                                );

                            break;
                    }

                @endphp


                <div class="user-order-item">


                    {{-- KIRI --}}

                    <div class="user-order-main">


                        <div class="user-order-top">

                            <strong class="user-order-id">

                                PM-{{
                                    str_pad(
                                        $item->id_pemesanan,
                                        3,
                                        '0',
                                        STR_PAD_LEFT
                                    )
                                }}

                            </strong>


                            <span
                                class="user-order-status {{ $statusClass }}"
                            >

                                {{ $statusIcon }}

                                {{ $statusText }}

                            </span>

                        </div>


                        <h3>
                            {{ $item->produk->nama_produk }}
                        </h3>


                        <div class="user-order-meta">

                            <span>
                                {{ number_format(
                                    $item->jumlah_liter,
                                    2,
                                    ',',
                                    '.'
                                ) }}
                                Liter
                            </span>


                            <span>
                                •
                            </span>


                            <span>
                                Rp{{ number_format(
                                    $item->total_harga,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </span>

                        </div>


                        <div class="user-order-date">

                            {{ $item->tanggal_pemesanan
                                ? $item->tanggal_pemesanan->format(
                                    'd M Y, H:i'
                                )
                                : '-'
                            }}

                        </div>

                    </div>


                    {{-- KANAN --}}

                    <div class="user-order-action">

                        <a
    href="{{ route(
        'user.pesanan.detail',
        $item->id_pemesanan
    ) }}"
    class="user-order-detail"
>
    Lihat Detail
</a>

                    </div>


                </div>

            @endforeach

        </div>

    @else

        <div class="user-empty-orders">

            <div class="user-empty-icon">
                📋
            </div>

            <h3>
                Belum Ada Pesanan
            </h3>

            <p>
                Anda belum memiliki riwayat pemesanan BBM.
            </p>


            <a
                href="{{ route('user.pemesanan') }}"
                class="quick-action"
            >
                🛒 Pesan BBM
            </a>

        </div>

    @endif

</div>

@endsection