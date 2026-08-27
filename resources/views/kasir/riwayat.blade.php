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
<div class="riwayat-pagination">

    <div class="pagination-info">
        Menampilkan
        {{ $transaksi->firstItem() ?? 0 }}
        sampai
        {{ $transaksi->lastItem() ?? 0 }}
        dari
        {{ $transaksi->total() }}
        transaksi
    </div>


    <div class="pagination-buttons">

        {{-- PREVIOUS --}}
        @if ($transaksi->onFirstPage())

            <span class="pagination-button disabled">
                ‹ Previous
            </span>

        @else

            <a
                href="{{ $transaksi->previousPageUrl() }}"
                class="pagination-button"
            >
                ‹ Previous
            </a>

        @endif


        {{-- NOMOR HALAMAN --}}
        @for (
            $page = 1;
            $page <= $transaksi->lastPage();
            $page++
        )

            @if ($page == $transaksi->currentPage())

                <span class="pagination-button active">
                    {{ $page }}
                </span>

            @else

                <a
                    href="{{ $transaksi->url($page) }}"
                    class="pagination-button"
                >
                    {{ $page }}
                </a>

            @endif

        @endfor


        {{-- NEXT --}}
        @if ($transaksi->hasMorePages())

            <a
                href="{{ $transaksi->nextPageUrl() }}"
                class="pagination-button"
            >
                Next ›
            </a>

        @else

            <span class="pagination-button disabled">
                Next ›
            </span>

        @endif

    </div>

</div>
</div>

@endsection