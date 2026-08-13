@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('content')

<div class="payment-page">

    {{-- HEADER --}}
    <div class="payment-header">
        <h1>Pembayaran</h1>
        <p>Kelola dan konfirmasi pembayaran pelanggan.</p>
    </div>


    {{-- RINGKASAN --}}
    <div class="payment-summary">

        <div class="summary-card">
            <span>Menunggu Pembayaran</span>
            <strong>2</strong>
            <small>Belum melakukan pembayaran</small>
        </div>

        <div class="summary-card">
            <span>Menunggu Konfirmasi</span>
            <strong>3</strong>
            <small>Perlu diperiksa admin</small>
        </div>

        <div class="summary-card">
            <span>Lunas</span>
            <strong>25</strong>
            <small>Pembayaran berhasil</small>
        </div>

    </div>


    {{-- DAFTAR PEMBAYARAN --}}
    <div class="payment-section">

        <div class="section-header">
            <div>
                <h2>Daftar Pembayaran</h2>
                <p>Transaksi yang membutuhkan pemantauan pembayaran.</p>
            </div>
        </div>


        <div class="payment-table-wrapper">

            <table class="payment-table">

                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Metode</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    {{-- TRANSFER --}}
                    <tr>

                        <td>
                            <strong>TRX-001</strong>
                        </td>

                        <td>
                            <strong>Budi Santoso</strong>
                        </td>

                        <td>
                            <span class="payment-method transfer">
                                🏦 Transfer Bank
                            </span>
                        </td>

                        <td>
                            <strong>Rp258.000</strong>
                        </td>

                        <td>
                            <span class="payment-status waiting">
                                Menunggu Konfirmasi
                            </span>
                        </td>

                        <td>

                            <div class="payment-actions">

                                <button
                                    type="button"
                                    class="btn-detail"
                                    onclick="showPaymentDetail('TRX-001')">
                                    Detail
                                </button>

                                <button
                                    type="button"
                                    class="btn-confirm"
                                    onclick="confirmPayment('TRX-001', 'Rp258.000')">
                                    Konfirmasi
                                </button>

                            </div>

                        </td>

                    </tr>


                    {{-- CASH --}}
                    <tr>

                        <td>
                            <strong>TRX-002</strong>
                        </td>

                        <td>
                            <strong>Andi Pratama</strong>
                        </td>

                        <td>
                            <span class="payment-method cash">
                                💵 Cash
                            </span>
                        </td>

                        <td>
                            <strong>Rp150.000</strong>
                        </td>

                        <td>
                            <span class="payment-status unpaid">
                                Menunggu Pembayaran
                            </span>
                        </td>

                        <td>

                            <button
                                type="button"
                                class="btn-confirm"
                                onclick="confirmPayment('TRX-002', 'Rp150.000')">
                                Konfirmasi
                            </button>

                        </td>

                    </tr>


                    {{-- LUNAS --}}
                    <tr>

                        <td>
                            <strong>TRX-003</strong>
                        </td>

                        <td>
                            <strong>Siti Aminah</strong>
                        </td>

                        <td>
                            <span class="payment-method transfer">
                                🏦 Transfer Bank
                            </span>
                        </td>

                        <td>
                            <strong>Rp129.000</strong>
                        </td>

                        <td>
                            <span class="payment-status paid">
                                ✓ Lunas
                            </span>
                        </td>

                        <td>

                            <button
                                type="button"
                                class="btn-detail"
                                onclick="showPaymentDetail('TRX-003')">
                                Lihat Detail
                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- MODAL KONFIRMASI --}}
<div id="confirmModal" class="payment-modal">

    <div class="payment-modal-content">

        <button
            type="button"
            class="modal-close"
            onclick="closeConfirmModal()">
            ×
        </button>

        <h2>Konfirmasi Pembayaran</h2>

        <p>
            Apakah pembayaran transaksi
            <strong id="confirmTransaction"></strong>
            sebesar
            <strong id="confirmAmount"></strong>
            sudah diterima dan sesuai?
        </p>

        <div class="modal-actions">

            <button
                type="button"
                class="btn-cancel"
                onclick="closeConfirmModal()">
                Batal
            </button>

            <button
                type="button"
                class="btn-confirm"
                onclick="processConfirmation()">
                Ya, Konfirmasi
            </button>

        </div>

    </div>

</div>


{{-- MODAL DETAIL --}}
<div id="detailModal" class="payment-modal">

    <div class="payment-modal-content detail-modal">

        <button
            type="button"
            class="modal-close"
            onclick="closeDetailModal()">
            ×
        </button>

        <h2>Detail Pembayaran</h2>

        <div class="detail-list">

            <div>
                <span>ID Transaksi</span>
                <strong id="detailTransaction">TRX-001</strong>
            </div>

            <div>
                <span>Pelanggan</span>
                <strong>Budi Santoso</strong>
            </div>

            <div>
                <span>Produk</span>
                <strong>Pertamax</strong>
            </div>

            <div>
                <span>Jumlah</span>
                <strong>20 Liter</strong>
            </div>

            <div>
                <span>Total</span>
                <strong>Rp258.000</strong>
            </div>

            <div>
                <span>Metode Pembayaran</span>
                <strong>Transfer Bank</strong>
            </div>

        </div>

        <div class="proof-section">

            <h3>Bukti Pembayaran</h3>

            <button
                type="button"
                class="btn-proof">
                📎 Lihat Bukti Transfer
            </button>

        </div>

        <div class="modal-actions">

            <button
                type="button"
                class="btn-cancel"
                onclick="closeDetailModal()">
                Tutup
            </button>

            <button
                type="button"
                class="btn-confirm"
                onclick="confirmPayment('TRX-001', 'Rp258.000')">
                Konfirmasi Pembayaran
            </button>

        </div>

    </div>

</div>


<script>

let selectedTransaction = null;

function confirmPayment(transaction, amount) {

    selectedTransaction = transaction;

    document.getElementById('confirmTransaction').textContent = transaction;
    document.getElementById('confirmAmount').textContent = amount;

    document.getElementById('confirmModal').classList.add('show');
}


function closeConfirmModal() {

    document
        .getElementById('confirmModal')
        .classList.remove('show');

}


function processConfirmation() {

    alert(
        'Pembayaran ' +
        selectedTransaction +
        ' berhasil dikonfirmasi.'
    );

    closeConfirmModal();

}


function showPaymentDetail(transaction) {

    document.getElementById('detailTransaction').textContent = transaction;

    document
        .getElementById('detailModal')
        .classList.add('show');

}


function closeDetailModal() {

    document
        .getElementById('detailModal')
        .classList.remove('show');

}

</script>

@endsection