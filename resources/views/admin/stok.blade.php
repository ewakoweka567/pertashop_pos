@extends('layouts.admin')

@section('title', 'Stok BBM')

@section('content')

<div class="page-header">
    <div>
        <h1>Stok BBM</h1>
        <p>Informasi ketersediaan stok bahan bakar minyak.</p>
    </div>
</div>


<div class="stock-grid">

    @foreach ($stok as $item)

        @php
            /*
             * Produk tidak aktif dianggap memiliki stok 0
             * hanya pada tampilan.
             */
            if ($item->produk->status !== 'aktif') {

                $stokTampil = 0;
                $statusClass = 'empty';
                $statusText = 'Tidak Aktif';
                $statusDescription = 'Produk sedang tidak aktif';
                $persentase = 0;

            } else {

                $stokTampil = $item->jumlah_stok;

                // Batas visual indikator, bukan kapasitas tangki sebenarnya
                $batasVisual = 3000;

                $persentase = min(
                    ($stokTampil / $batasVisual) * 100,
                    100
                );

                if ($stokTampil <= 0) {

                    $statusClass = 'empty';
                    $statusText = 'Habis';
                    $statusDescription = 'Stok habis';

                } elseif ($stokTampil < 300) {

                    $statusClass = 'danger';
                    $statusText = 'Kritis';
                    $statusDescription = 'Stok sangat rendah';

                } elseif ($stokTampil < 750) {

                    $statusClass = 'warning';
                    $statusText = 'Perlu Perhatian';
                    $statusDescription = 'Stok mulai menipis';

                } else {

                    $statusClass = 'safe';
                    $statusText = 'Aman';
                    $statusDescription = 'Stok masih aman';
                }
            }
        @endphp


        <div class="card stock-card">

            <div class="stock-card-header">

                <div>

                    <h2>
                        {{ $item->produk->nama_produk }}
                    </h2>

                    <p>
                        {{ $item->produk->status === 'aktif'
                            ? 'Stok tersedia'
                            : 'Produk tidak aktif'
                        }}
                    </p>

                </div>

                <div class="stock-icon">
                    ⛽
                </div>

            </div>


            <div class="stock-value">

                <strong>
                    {{ number_format($stokTampil, 0, ',', '.') }}
                </strong>

                <span>
                    Liter
                </span>

            </div>


            <div class="stock-bar">

                <div
                    class="stock-progress {{ $statusClass }}"
                    style="width: {{ $persentase }}%;">
                </div>

            </div>


            <div class="stock-footer">

                <span>
                    Level indikator
                </span>

                <strong>
                    3.000 Liter
                </strong>

            </div>


            <div class="stock-action">

                @if ($item->produk->status === 'aktif')

                    <a
                        href="{{ route('admin.stok.edit', $item->id_stok) }}"
                        class="btn-edit">
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


{{-- INFORMASI STOK --}}

<div class="card stock-information">

    <div class="card-header">
        <h2>Status Stok</h2>
    </div>


    <div class="stock-status-list">

        @foreach ($stok as $item)

            @php

                if ($item->produk->status !== 'aktif') {

                    $statusClass = 'empty';
                    $statusText = 'Tidak Aktif';
                    $statusDescription = 'Produk sedang tidak aktif';

                } else {

                    $stokSaatIni = $item->jumlah_stok;

                    if ($stokSaatIni <= 0) {

                        $statusClass = 'empty';
                        $statusText = 'Habis';
                        $statusDescription = 'Stok habis';

                    } elseif ($stokSaatIni < 300) {

                        $statusClass = 'danger';
                        $statusText = 'Kritis';
                        $statusDescription = 'Stok sangat rendah';

                    } elseif ($stokSaatIni < 750) {

                        $statusClass = 'warning';
                        $statusText = 'Perlu Perhatian';
                        $statusDescription = 'Stok mulai menipis';

                    } else {

                        $statusClass = 'safe';
                        $statusText = 'Aman';
                        $statusDescription = 'Stok masih aman';
                    }
                }

            @endphp


            <div class="stock-status-item">

                <div>

                    <strong>
                        {{ $item->produk->nama_produk }}
                    </strong>

                    <p>
                        {{ $statusDescription }}
                    </p>

                </div>


                <span class="badge badge-{{ $statusClass }}">
                    {{ $statusText }}
                </span>

            </div>

        @endforeach

    </div>

</div>

@endsection