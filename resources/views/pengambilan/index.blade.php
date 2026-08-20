@extends('layouts.admin')

@section('title', 'Pesanan Menunggu Pengambilan')

@section('content')

<div class="page-header">

    <div>

        <h1>
            Pesanan Menunggu Pengambilan
        </h1>

        <p>
            Pesanan yang pembayarannya sudah dikonfirmasi dan siap diambil.
        </p>

    </div>

</div>


@if (session('success'))

    <div
        style="
            margin-bottom: 20px;
            padding: 14px 18px;
            border-radius: 10px;
            background: #dcfce7;
            color: #166534;
            font-weight: 600;
        "
    >
        {{ session('success') }}
    </div>

@endif


<div class="card">

    <div class="table-wrapper">

        <table class="transaction-table">

            <thead>

                <tr>

                    <th>
                        ID Pesanan
                    </th>

                    <th>
                        Pelanggan
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

                    <th>
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse ($pesanan as $item)

                    <tr>

                        <td>

                            <strong>
                                PM-{{ str_pad(
                                    $item->id_pemesanan,
                                    3,
                                    '0',
                                    STR_PAD_LEFT
                                ) }}
                            </strong>

                        </td>


                        <td>

                            {{ $item->user->nama ?? '-' }}

                        </td>


                        <td>

                            {{ $item->produk->nama_produk ?? '-' }}

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

                            <strong>

                                Rp{{ number_format(
                                    $item->total_harga,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </strong>

                        </td>


                        <td>

                            <span
                                class="admin-badge pending"
                            >
                                Menunggu Pengambilan
                            </span>

                        </td>


                        <td>

                            @if (auth()->user()->role === 'admin')

                                <form
                                    action="{{ route(
                                        'admin.pesanan.konfirmasi-pengambilan',
                                        $item->id_pemesanan
                                    ) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn-confirm"
                                        onclick="return confirm(
                                            'Pastikan BBM sudah diserahkan kepada pelanggan. Lanjutkan konfirmasi pengambilan?'
                                        )"
                                    >
                                        Konfirmasi Pengambilan
                                    </button>

                                </form>

                            @elseif (auth()->user()->role === 'kasir')

                                <form
                                    action="{{ route(
                                        'kasir.pesanan.konfirmasi-pengambilan',
                                        $item->id_pemesanan
                                    ) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn-confirm"
                                        onclick="return confirm(
                                            'Pastikan BBM sudah diserahkan kepada pelanggan. Lanjutkan konfirmasi pengambilan?'
                                        )"
                                    >
                                        Konfirmasi Pengambilan
                                    </button>

                                </form>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            style="text-align: center;"
                        >
                            Tidak ada pesanan yang menunggu pengambilan.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection