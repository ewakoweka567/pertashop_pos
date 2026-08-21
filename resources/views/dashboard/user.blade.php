@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')

<div class="dashboard-header">

    <div>

        <h1>
            Dashboard User
        </h1>

        <p>
            Selamat datang, {{ Auth::user()->nama }}
        </p>

    </div>


    {{-- TOMBOL PESAN BBM --}}

    <a
        href="{{ route('user.pemesanan') }}"
        class="quick-action"
        style="
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        "
    >
        🛒 Pesan BBM
    </a>

</div>



{{-- =========================================================
     PESANAN TERAKHIR ANDA
========================================================= --}}

<div class="card">

    <div class="card-header">

        <div>

            <h2>
                Pesanan Terakhir Anda
            </h2>

            <p>
                Ringkasan pesanan BBM terakhir Anda.
            </p>

        </div>

    </div>


    @if ($pesananTerakhir)


        @php

            switch ($pesananTerakhir->status_pemesanan) {

                case 'menunggu_pembayaran':

                    $statusText =
                        'Menunggu Pembayaran';

                    $statusClass =
                        'badge-warning';

                    break;


                case 'menunggu_verifikasi':

                    $statusText =
                        'Menunggu Konfirmasi';

                    $statusClass =
                        'badge-warning';

                    break;


                case 'menunggu_pengambilan':

                    $statusText =
                        'Menunggu Pengambilan';

                    $statusClass =
                        'badge-warning';

                    break;


                case 'selesai':

                    $statusText =
                        'Selesai';

                    $statusClass =
                        'badge-success';

                    break;


                case 'dibatalkan':

                    $statusText =
                        'Dibatalkan';

                    $statusClass =
                        'badge-danger';

                    break;


                default:

                    $statusText =
                        ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $pesananTerakhir->status_pemesanan
                            )
                        );

                    $statusClass =
                        'badge-warning';

            }

        @endphp


        {{-- PESANAN TERAKHIR --}}

        <div
            style="
                padding: 10px 0;
            "
        >

            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 20px;
                    margin-bottom: 18px;
                "
            >

                <div>

                    <div
                        style="
                            font-size: 13px;
                            color: #64748b;
                            margin-bottom: 5px;
                        "
                    >
                        ID Pesanan
                    </div>

                    <h3>
                        PM-{{
                            str_pad(
                                $pesananTerakhir->id_pemesanan,
                                3,
                                '0',
                                STR_PAD_LEFT
                            )
                        }}
                    </h3>

                </div>


                <span class="badge {{ $statusClass }}">
                    {{ $statusText }}
                </span>

            </div>


            <div
                style="
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 15px;
                "
            >

                <div>

                    <div
                        style="
                            font-size: 12px;
                            color: #64748b;
                            margin-bottom: 4px;
                        "
                    >
                        Produk
                    </div>

                    <strong>
                        {{ $pesananTerakhir->produk->nama_produk }}
                    </strong>

                </div>


                <div>

                    <div
                        style="
                            font-size: 12px;
                            color: #64748b;
                            margin-bottom: 4px;
                        "
                    >
                        Jumlah
                    </div>

                    <strong>
                        {{ number_format(
                            $pesananTerakhir->jumlah_liter,
                            2,
                            ',',
                            '.'
                        ) }}
                        Liter
                    </strong>

                </div>


                <div>

                    <div
                        style="
                            font-size: 12px;
                            color: #64748b;
                            margin-bottom: 4px;
                        "
                    >
                        Total
                    </div>

                    <strong>
                        Rp{{ number_format(
                            $pesananTerakhir->total_harga,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>

            </div>


            <div
                style="
                    margin-top: 15px;
                    font-size: 12px;
                    color: #94a3b8;
                "
            >

                {{ $pesananTerakhir->tanggal_pemesanan
                    ? $pesananTerakhir->tanggal_pemesanan->format(
                        'd M Y, H:i'
                    )
                    : '-'
                }}

            </div>


            <a
    href="{{ route('user.pemesanan', [
        'id_produk' => $pesananTerakhir->id_produk,
        'jumlah_liter' => $pesananTerakhir->jumlah_liter,
        'metode_pembayaran' => optional($pesananTerakhir->pembayaran)->metode_pembayaran,
    ]) }}"
    class="quick-action"
    style="
        display: inline-block;
        margin-top: 18px;
    "
>
    🛒 Pesan Lagi
</a>

        </div>


    @else


        {{-- BELUM ADA PESANAN --}}

        <div
            style="
                padding: 30px 10px;
                text-align: center;
            "
        >

            <div
                style="
                    font-size: 42px;
                    margin-bottom: 10px;
                "
            >
                ⛽
            </div>

            <h3>
                Belum Ada Pesanan
            </h3>

            <p>
                Anda belum memiliki pesanan BBM.
            </p>


            <a
                href="{{ route('user.pemesanan') }}"
                class="quick-action"
                style="
                    display: inline-block;
                    margin-top: 15px;
                "
            >
                🛒 Pesan BBM
            </a>

        </div>

    @endif

</div>



{{-- =========================================================
     PESANAN TERBARU
========================================================= --}}

<div class="card">

    <div class="card-header">

        <div>

            <h2>
                Pesanan Terbaru
            </h2>

            <p>
                Riwayat pesanan BBM Anda.
            </p>

        </div>


        <a href="{{ route('user.pesanan') }}">
            Lihat Semua
        </a>

    </div>


    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>
                        ID Pesanan
                    </th>

                    <th>
                        Produk
                    </th>

                    <th>
                        Jumlah
                    </th>

                    <th>
                        Total
                    </th>

                    <th>
                        Status
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse ($pesananTerbaru as $item)

                    @php

                        switch ($item->status_pemesanan) {

                            case 'menunggu_pembayaran':

                                $statusText =
                                    'Menunggu Pembayaran';

                                $statusClass =
                                    'badge-warning';

                                break;


                            case 'menunggu_verifikasi':

                                $statusText =
                                    'Menunggu Konfirmasi';

                                $statusClass =
                                    'badge-warning';

                                break;


                            case 'menunggu_pengambilan':

                                $statusText =
                                    'Menunggu Pengambilan';

                                $statusClass =
                                    'badge-warning';

                                break;


                            case 'selesai':

                                $statusText =
                                    'Selesai';

                                $statusClass =
                                    'badge-success';

                                break;


                            case 'dibatalkan':

                                $statusText =
                                    'Dibatalkan';

                                $statusClass =
                                    'badge-danger';

                                break;


                            default:

                                $statusText =
                                    ucfirst(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $item->status_pemesanan
                                        )
                                    );

                                $statusClass =
                                    'badge-warning';

                        }

                    @endphp


                    <tr>

                        <td>
                            PM-{{
                                str_pad(
                                    $item->id_pemesanan,
                                    3,
                                    '0',
                                    STR_PAD_LEFT
                                )
                            }}
                        </td>


                        <td>
                            {{ $item->produk->nama_produk }}
                        </td>


                        <td>

                            {{ number_format(
                                $item->jumlah_liter,
                                2,
                                ',',
                                '.'
                            ) }}

                            Liter

                        </td>


                        <td>

                            Rp{{ number_format(
                                $item->total_harga,
                                0,
                                ',',
                                '.'
                            ) }}

                        </td>


                        <td>

                            <span
                                class="badge {{ $statusClass }}"
                            >
                                {{ $statusText }}
                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td>
                            -
                        </td>

                        <td>
                            Belum ada pesanan
                        </td>

                        <td>
                            -
                        </td>

                        <td>
                            -
                        </td>

                        <td>

                            <span class="badge badge-warning">
                                Belum Ada
                            </span>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection