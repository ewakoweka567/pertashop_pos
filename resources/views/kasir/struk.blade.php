<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Struk {{ $penjualan->id_penjualan }}
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            background: #f3f4f6;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            color: #111827;
        }


        .receipt-wrapper {
            width: 80mm;

            max-width: 80mm;

            margin: 20px auto;

            padding: 12px;

            background: white;

            box-shadow:
                0 2px 12px
                rgba(0, 0, 0, 0.08);
        }


        .receipt {
            width: 100%;

            font-size: 12px;

            line-height: 1.45;
        }


        .receipt-header {
            text-align: center;

            margin-bottom: 10px;
        }


        .receipt-header h1 {
            margin: 0;

            font-size: 16px;

            font-weight: 700;
        }


        .receipt-header p {
            margin: 2px 0;

            font-size: 11px;
        }


        .divider {
            border-top:
                1px dashed #111827;

            margin: 8px 0;
        }


        .receipt-row {
            display: flex;

            justify-content: space-between;

            gap: 10px;

            margin: 3px 0;
        }


        .receipt-row span:first-child {
            flex: 1;
        }


        .receipt-row span:last-child {
            text-align: right;
        }


        .product {
            margin-top: 8px;
        }


        .product-name {
            font-weight: 700;

            margin-bottom: 3px;
        }


        .product-detail {
            display: flex;

            justify-content: space-between;
        }


        .total {
            margin-top: 8px;

            font-size: 14px;

            font-weight: 700;
        }


        .receipt-footer {
            margin-top: 12px;

            text-align: center;

            font-size: 11px;
        }


        .print-actions {
            display: flex;

            justify-content: center;

            gap: 8px;

            margin-top: 20px;
        }


        .print-button,
        .back-button {
            min-height: 38px;

            padding: 0 14px;

            border: none;

            border-radius: 7px;

            cursor: pointer;

            text-decoration: none;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            font-size: 13px;

            font-weight: 700;
        }


        .print-button {
            background: #dc2626;

            color: white;
        }


        .print-button:hover {
            background: #b91c1c;
        }


        .back-button {
            background: #e5e7eb;

            color: #374151;
        }


        @media print {

            @page {
                size: 80mm auto;

                margin: 0;
            }


            html,
            body {
                width: 80mm;

                margin: 0;

                padding: 0;

                background: white;
            }


            .receipt-wrapper {
                width: 80mm;

                max-width: 80mm;

                margin: 0;

                padding: 8px;

                box-shadow: none;
            }


            .print-actions {
                display: none;
            }

        }

    </style>

</head>


<body>


<div class="receipt-wrapper">

    <div class="receipt">


        {{-- HEADER --}}

        <div class="receipt-header">

            <h1>
                PERTASHOP
            </h1>

            <p>
                CV Dwi Tirta Agung
            </p>

            <p>
                Struk Penjualan
            </p>

        </div>


        <div class="divider"></div>


        {{-- TRANSAKSI --}}

        <div class="receipt-row">

            <span>
                No. Transaksi
            </span>

            <span>
                TRX-{{
                    str_pad(
                        $penjualan->id_penjualan,
                        3,
                        '0',
                        STR_PAD_LEFT
                    )
                }}
            </span>

        </div>


        <div class="receipt-row">

            <span>
                Tanggal
            </span>

            <span>
                {{ $penjualan->tanggal_penjualan
                    ? $penjualan->tanggal_penjualan->format(
                        'd/m/Y H:i'
                    )
                    : '-'
                }}
            </span>

        </div>


        <div class="receipt-row">

            <span>
                Kasir
            </span>

            <span>
                {{ $penjualan->kasir->nama ?? '-' }}
            </span>

        </div>


        <div class="divider"></div>


        {{-- PRODUK --}}

        <div class="product">

            <div class="product-name">

                {{ $penjualan->produk->nama_produk }}

            </div>


            <div class="product-detail">

                <span>

                    {{
                        number_format(
                            $penjualan->jumlah_liter,
                            2,
                            ',',
                            '.'
                        )
                    }}
                    L

                    ×

                    Rp{{
                        number_format(
                            $penjualan->produk->harga_per_liter,
                            0,
                            ',',
                            '.'
                        )
                    }}

                </span>


                <span>

                    Rp{{
                        number_format(
                            $penjualan->total_harga,
                            0,
                            ',',
                            '.'
                        )
                    }}

                </span>

            </div>

        </div>


        <div class="divider"></div>


        {{-- TOTAL --}}

        <div class="receipt-row total">

            <span>
                TOTAL
            </span>

            <span>

                Rp{{
                    number_format(
                        $penjualan->total_harga,
                        0,
                        ',',
                        '.'
                    )
                }}

            </span>

        </div>


        {{-- METODE --}}

        <div class="receipt-row">

            <span>
                Pembayaran
            </span>

            <span>

                @if (
                    $penjualan->metode_pembayaran
                    === 'tunai'
                )

                    Tunai

                @else

                    QRIS

                @endif

            </span>

        </div>


        <div class="divider"></div>


        {{-- FOOTER --}}

        <div class="receipt-footer">

            <p>
                Terima kasih atas pembelian Anda.
            </p>

            <p>
                Simpan struk ini sebagai bukti transaksi.
            </p>

        </div>


    </div>


    {{-- BUTTON --}}

    <div class="print-actions">

        <button
            type="button"
            class="print-button"
            onclick="window.print()"
        >
            🖨 Cetak Struk
        </button>


        <a
            href="{{ route('kasir.pos') }}"
            class="back-button"
        >
            Kembali ke POS
        </a>

    </div>

</div>


</body>

</html>