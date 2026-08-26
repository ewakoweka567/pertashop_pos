@extends('layouts.kasir')

@section('title', 'Riwayat Transaksi')

@section('content')

<div class="dashboard-header">
    <h1>Riwayat Transaksi</h1>
    <p>Daftar transaksi penjualan yang dilakukan.</p>
</div>

<div class="card">

    <div class="table-responsive">

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Metode Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($transaksi as $item)

                    <tr>

                        <td>
                            {{ $transaksi->firstItem() + $loop->index }}
                        </td>

                        <td>
                            {{ $item->tanggal_penjualan->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            {{ $item->produk->nama_produk ?? '-' }}
                        </td>

                        <td>
                            {{ number_format($item->jumlah_liter, 2, ',', '.') }}
                            L
                        </td>

                        <td>
                            Rp{{ number_format($item->total_harga, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ strtoupper($item->metode_pembayaran ?? '-') }}
                        </td>

                        <td>

                            <a
                              href="{{ route('kasir.struk', $item->id_penjualan) }}"
                             class="btn-cetak-struk"
                            >
                                🧾 Cetak Struk
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            Belum ada transaksi.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div>
        {{ $transaksi->links() }}
    </div>

</div>

@endsection