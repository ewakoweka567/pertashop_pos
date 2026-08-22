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


<div class="card">

    <div class="card-header">

        <div>

            <h2>
                Pesanan Siap Diambil
            </h2>

            <p>
                Pesanan yang pembayaran-nya sudah dikonfirmasi.
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

                            {{ $item->user->nama }}

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

                            <a
                                href="#"
                                class="quick-action"
                            >
                                Lihat Detail
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7">

                            Tidak ada pesanan yang menunggu pengambilan.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection