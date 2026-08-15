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
            $kapasitas = 1000;
            $persentase = min(($item->jumlah_stok / $kapasitas) * 100, 100);

            if ($persentase <= 25) {
                $statusClass = 'warning';
                $statusText = 'Perlu Perhatian';
                $statusDescription = 'Stok mulai menipis';
            } else {
                $statusClass = 'safe';
                $statusText = 'Aman';
                $statusDescription = 'Stok masih aman';
            }
        @endphp

        <div class="card stock-card">

            <div class="stock-card-header">

                <div>
                    <h2>{{ $item->produk->nama_produk }}</h2>
                    <p>Stok tersedia</p>
                </div>

                <div class="stock-icon">
                    ⛽
                </div>

            </div>

            <div class="stock-value">
                <strong>{{ number_format($item->jumlah_stok, 0, ',', '.') }}</strong>
                <span>Liter</span>
            </div>

            <div class="stock-bar">

                <div
                    class="stock-progress {{ $statusClass }}"
                    style="width: {{ $persentase }}%;">
                </div>

            </div>

            <div class="stock-footer">
                <span>Kapasitas</span>
                <strong>{{ number_format($kapasitas, 0, ',', '.') }} Liter</strong>
            </div>

            <div class="stock-action">
                <a
                    href="/admin/stok/{{ $item->id_stok }}/edit"
                    class="btn-edit">
                    Kelola Stok
                </a>
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
                $persentase = min(($item->jumlah_stok / 1000) * 100, 100);

                if ($persentase <= 25) {
                    $badgeClass = 'badge-warning';
                    $statusText = 'Perlu Perhatian';
                    $description = 'Stok mulai menipis';
                } else {
                    $badgeClass = 'badge-success';
                    $statusText = 'Aman';
                    $description = 'Stok masih aman';
                }
            @endphp

            <div class="stock-status-item">

                <div>
                    <strong>{{ $item->produk->nama_produk }}</strong>
                    <p>{{ $description }}</p>
                </div>

                <span class="badge {{ $badgeClass }}">
                    {{ $statusText }}
                </span>

            </div>

        @endforeach

    </div>

</div>

@endsection