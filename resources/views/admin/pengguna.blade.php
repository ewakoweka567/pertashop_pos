@extends('layouts.admin')

@section('title', 'Pengguna')

@section('content')

<div class="page-header">

    <div>
        <h1>Pengguna</h1>
        <p>Informasi pengguna yang terdaftar dalam sistem.</p>
    </div>

</div>


<div class="product-grid">

    @foreach ($pengguna as $item)

        <div class="card product-card">

            <div class="product-icon">
                👤
            </div>


            <div class="product-info">

                <h2>{{ $item->nama }}</h2>

                <p class="product-price">
                    {{ $item->email }}
                </p>

                <p class="product-stock">
                    No. HP:
                    <strong>
                        {{ $item->no_hp }}
                    </strong>
                </p>

                <p class="product-stock">
                    Role:
                    <strong>
                        {{ ucfirst($item->role) }}
                    </strong>
                </p>

                <p class="product-stock">
                    Status:
                    <strong>
                        {{ $item->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                    </strong>
                </p>

            </div>


            <div class="product-action">

                <a
                    href="{{ route('admin.pengguna.edit', $item->id_user) }}"
                    class="btn-edit">
                    Edit
                </a>

            </div>

        </div>

    @endforeach

</div>

@endsection