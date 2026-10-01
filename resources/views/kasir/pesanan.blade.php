@extends('layouts.kasir')

@section('title', 'Pesanan')

@section('content')

<div class="dashboard-header">

    <h1>
        Pesanan
    </h1>

    <p>
        Pesanan customer yang siap diambil.
    </p>

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

    <div class="card-header">

        <div>

            <h2>
                Pesanan Siap Diambil
            </h2>

            <p>
                Pesanan yang pembayarannya sudah dikonfirmasi.
            </p>

        </div>

    </div>


    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>
                        ID Pesanan
                    </th>

                    <th>
                        Customer
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

                            L

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

                            <span class="badge badge-warning">

                                Menunggu Pengambilan

                            </span>

                        </td>


                        <td>

                            <form
                                action="{{ route(
                                    'kasir.pesanan.konfirmasi-pengambilan',
                                    $item->id_pemesanan
                                ) }}"
                                method="POST"
                                style="margin: 0;"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="quick-action"
                                    onclick="return confirm(
                                        'Pastikan BBM sudah diserahkan kepada pelanggan. Lanjutkan konfirmasi pengambilan?'
                                    )"
                                >
                                    Konfirmasi Pengambilan
                                </button>

                            </form>

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