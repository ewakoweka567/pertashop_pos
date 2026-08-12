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

    {{-- Pertamax --}}
    <div class="card stock-card">

        <div class="stock-card-header">

            <div>
                <h2>Pertamax</h2>
                <p>Stok tersedia</p>
            </div>

            <div class="stock-icon">
                ⛽
            </div>

        </div>


        <div class="stock-value">
            <strong>850</strong>
            <span>Liter</span>
        </div>


        <div class="stock-bar">

            <div
                class="stock-progress safe"
                style="width: 85%;">
            </div>

        </div>


        <div class="stock-footer">
            <span>Kapasitas</span>
            <strong>1.000 Liter</strong>
        </div>
        <div class="stock-action">
            <a href="/admin/stok/1/edit" class="btn-edit">
                Kelola Stok
            </a>
        </div>

    </div>


    {{-- Dexlite --}}
    <div class="card stock-card">

        <div class="stock-card-header">

            <div>
                <h2>Dexlite</h2>
                <p>Stok tersedia</p>
            </div>

            <div class="stock-icon">
                ⛽
            </div>

        </div>


        <div class="stock-value">
            <strong>250</strong>
            <span>Liter</span>
        </div>


        <div class="stock-bar">

            <div
                class="stock-progress warning"
                style="width: 25%;">
            </div>

        </div>


        <div class="stock-footer">
            <span>Kapasitas</span>
            <strong>1.000 Liter</strong>
        </div>

        <div class="stock-action">
            <a href="/admin/stok/1/edit" class="btn-edit">
                 Kelola Stok
            </a>
        </div>

    </div>

</div>


{{-- INFORMASI STOK --}}

<div class="card stock-information">

    <div class="card-header">
        <h2>Status Stok</h2>
    </div>

    <div class="stock-status-list">

        <div class="stock-status-item">

            <div>
                <strong>Pertamax</strong>
                <p>Stok masih aman</p>
            </div>

            <span class="badge badge-success">
                Aman
            </span>

        </div>


        <div class="stock-status-item">

            <div>
                <strong>Dexlite</strong>
                <p>Stok mulai menipis</p>
            </div>

            <span class="badge badge-warning">
                Perlu Perhatian
            </span>

        </div>

    </div>

</div>

@endsection