@extends('layouts.admin')

@section('title', 'Stok BBM')

@section('content')

<div class="page-header">

    <div>

        <h1>
            Stok BBM
        </h1>

        <p>
            Informasi ketersediaan stok bahan bakar minyak.
        </p>

    </div>

</div>


{{-- =========================================================
     RINGKASAN STOK
========================================================= --}}

<div class="stock-summary-grid">

    @foreach ($stok as $item)

        @php

            /*
            |--------------------------------------------------------------------------
            | STATUS PRODUK
            |--------------------------------------------------------------------------
            */

            $produkAktif =
                $item->produk->status === 'aktif';


            /*
            |--------------------------------------------------------------------------
            | DATA YANG DITAMPILKAN
            |--------------------------------------------------------------------------
            |
            | Jika produk aktif:
            |   stok fisik     = jumlah stok database
            |   reservasi      = stok reservasi database
            |
            | Jika produk nonaktif:
            |   semua ditampilkan 0
            |
            | Catatan:
            | database asli tidak disentuh.
            |
            */

            if ($produkAktif) {

                $stokFisik =
                    (float) $item->jumlah_stok;

                $stokReservasi =
                    (float) ($item->stok_reservasi ?? 0);

            } else {

                $stokFisik = 0;
                $stokReservasi = 0;

            }

        @endphp


        <div class="stock-summary-card">


            {{-- HEADER PRODUK --}}

            <div class="stock-summary-header">

                <div>

                    <h2>
                        {{ $item->produk->nama_produk }}
                    </h2>

                    <p>
                        {{ $produkAktif
                            ? 'Ringkasan stok saat ini'
                            : 'Produk tidak aktif'
                        }}
                    </p>

                </div>


                <div class="stock-summary-icon">
                    ⛽
                </div>

            </div>


            {{-- DATA RINGKAS --}}

            <div class="stock-summary-data">


                {{-- STOK FISIK --}}

                <div class="stock-summary-data-item">

                    <span>
                        Stok Fisik
                    </span>

                    <strong>
                        {{ number_format(
                            $stokFisik,
                            2,
                            ',',
                            '.'
                        ) }}
                        L
                    </strong>

                </div>


                {{-- RESERVASI --}}

                <div class="stock-summary-data-item reserved">

                    <span>
                        Sedang Reservasi
                    </span>

                    <strong>
                        {{ number_format(
                            $stokReservasi,
                            2,
                            ',',
                            '.'
                        ) }}
                        L
                    </strong>

                </div>


            </div>

        </div>

    @endforeach

</div>



{{-- =========================================================
     INFORMASI STOK DETAIL
========================================================= --}}

<div class="card stock-information">


    <div class="card-header">

        <h2>
            Status Stok
        </h2>

    </div>


    <div class="stock-status-list">


        @foreach ($stok as $item)

            @php

                /*
                |--------------------------------------------------------------------------
                | STATUS PRODUK
                |--------------------------------------------------------------------------
                */

                $produkAktif =
                    $item->produk->status === 'aktif';


                /*
                |--------------------------------------------------------------------------
                | DATA STOK
                |--------------------------------------------------------------------------
                */

                if ($produkAktif) {

                    $stokFisik =
                        (float) $item->jumlah_stok;

                    $stokReservasi =
                        (float) ($item->stok_reservasi ?? 0);

                    /*
                     * Stok yang benar-benar bisa dipesan.
                     */
                    $stokTersedia = max(
                        $stokFisik - $stokReservasi,
                        0
                    );

                } else {

                    /*
                     * Produk nonaktif ditampilkan 0.
                     */
                    $stokFisik = 0;
                    $stokReservasi = 0;
                    $stokTersedia = 0;

                }


                /*
                |--------------------------------------------------------------------------
                | INDIKATOR VISUAL
                |--------------------------------------------------------------------------
                */

                $batasVisual = 3000;

                $persentase =
                    $produkAktif
                        ? min(
                            ($stokTersedia / $batasVisual) * 100,
                            100
                        )
                        : 0;


                /*
                |--------------------------------------------------------------------------
                | STATUS STOK
                |--------------------------------------------------------------------------
                */

                if (!$produkAktif) {

                    $statusClass =
                        'empty';

                    $statusText =
                        'Tidak Aktif';

                    $statusDescription =
                        'Produk sedang tidak tersedia';

                } elseif ($stokTersedia <= 0) {

                    $statusClass =
                        'empty';

                    $statusText =
                        'Habis';

                    $statusDescription =
                        'Tidak ada stok yang tersedia untuk dipesan';

                } elseif ($stokTersedia < 300) {

                    $statusClass =
                        'danger';

                    $statusText =
                        'Kritis';

                    $statusDescription =
                        'Stok tersedia sangat rendah';

                } elseif ($stokTersedia < 750) {

                    $statusClass =
                        'warning';

                    $statusText =
                        'Perlu Perhatian';

                    $statusDescription =
                        'Stok tersedia mulai menipis';

                } else {

                    $statusClass =
                        'safe';

                    $statusText =
                        'Aman';

                    $statusDescription =
                        'Stok tersedia masih aman';

                }

            @endphp


            <div class="card stock-card">


                {{-- =================================================
                     HEADER PRODUK
                ================================================== --}}

                <div class="stock-card-header">

                    <div>

                        <h2>
                            {{ $item->produk->nama_produk }}
                        </h2>

                        <p>
                            {{ $produkAktif
                                ? 'Stok tersedia'
                                : 'Produk tidak aktif'
                            }}
                        </p>

                    </div>


                    <div class="stock-icon">
                        ⛽
                    </div>

                </div>



                {{-- =================================================
                     STOK TERSEDIA
                ================================================== --}}

                <div class="stock-value">

                    <strong>
                        {{ number_format(
                            $stokTersedia,
                            2,
                            ',',
                            '.'
                        ) }}
                    </strong>

                    <span>
                        Liter
                    </span>

                </div>


                <p class="stock-available-label">
                    {{ $produkAktif
                        ? 'Tersedia untuk dipesan'
                        : 'Produk tidak tersedia'
                    }}
                </p>



                {{-- =================================================
                     PROGRESS BAR
                ================================================== --}}

                <div class="stock-bar">

                    <div
                        class="stock-progress {{ $statusClass }}"
                        style="width: {{ $persentase }}%;"
                    >
                    </div>

                </div>



                {{-- =================================================
                     RINGKASAN STOK
                ================================================== --}}

                <div class="stock-summary">


                    {{-- STOK FISIK --}}

                    <div class="stock-summary-item">

                        <span>
                            Stok fisik
                        </span>

                        <strong>
                            {{ number_format(
                                $stokFisik,
                                2,
                                ',',
                                '.'
                            ) }}
                            L
                        </strong>

                    </div>


                    {{-- RESERVASI --}}

                    <div class="stock-summary-item reserved">

                        <span>
                            Sedang reservasi
                        </span>

                        <strong>
                            {{ number_format(
                                $stokReservasi,
                                2,
                                ',',
                                '.'
                            ) }}
                            L
                        </strong>

                    </div>


                    {{-- TERSEDIA --}}

                    <div class="stock-summary-item available">

                        <span>
                            Tersedia
                        </span>

                        <strong>
                            {{ number_format(
                                $stokTersedia,
                                2,
                                ',',
                                '.'
                            ) }}
                            L
                        </strong>

                    </div>


                </div>



                {{-- =================================================
                     LEVEL INDIKATOR
                ================================================== --}}

                <div class="stock-footer">

                    <span>
                        Level indikator
                    </span>

                    <strong>
                        3.000 Liter
                    </strong>

                </div>



                {{-- =================================================
                     STATUS
                ================================================== --}}

                <div class="stock-status">

                    <span class="badge badge-{{ $statusClass }}">
                        {{ $statusText }}
                    </span>

                    <small>
                        {{ $statusDescription }}
                    </small>

                </div>



                {{-- =================================================
                     AKSI
                ================================================== --}}

                <div class="stock-action">

                    @if ($produkAktif)

                        <a
                            href="{{ route(
                                'admin.stok.edit',
                                $item->id_stok
                            ) }}"
                            class="btn-edit"
                        >
                            Kelola Stok
                        </a>

                    @else

                        <span class="btn-edit">
                            Tidak Aktif
                        </span>

                    @endif

                </div>


            </div>

        @endforeach


    </div>

</div>


@endsection