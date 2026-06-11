<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk - {{ $transaction->invoice_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 10px;
            width: 250px; /* Lebar standar struk thermal */
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .line { border-top: 1px dashed #000; margin: 5px 0; }
        .table { width: 100%; border-collapse: collapse; }
        .table td { padding: 2px 0; vertical-align: top; }
        .totals td { font-weight: bold; }
        
        /* Menyembunyikan tombol cetak saat kertas struk diprint */
        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 5px 10px; background: green; color: white; border: none; cursor: pointer;">Print Struk</button>
        <button onclick="window.close();" style="padding: 5px 10px; background: #555; color: white; border: none; cursor: pointer;">Tutup Halaman</button>
        <hr>
    </div>

    <div class="text-center">
        <h3 style="margin: 0; text-transform: uppercase;">MAJOO CLONE KASIR</h3>
        <p style="margin: 2px 0;">Universitas Pelita Bangsa</p>
        <p style="margin: 2px 0;">Telp: 0812-XXXX-XXXX</p>
    </div>

    <div class="line"></div>

    <table class="table">
        <tr>
            <td>Nota: {{ $transaction->invoice_number }}</td>
        </tr>
        <tr>
            <td>Tgl : {{ $transaction->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <table class="table">
        @foreach($transaction->details as $detail)
            <tr>
                <td colspan="3">{{ $detail->product->name }}</td>
            </tr>
            <tr>
                <td>{{ $detail->qty }} x Rp{{ number_format($detail->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="line"></div>

    <table class="table totals">
        <tr>
            <td>TOTAL TAGIHAN:</td>
            <td class="text-right">Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>TUNAI/BAYAR  :</td>
            <td class="text-right">Rp{{ number_format($transaction->total_accepted, 0, ',', '.') }}</td>
        </tr>
        <tr style="font-size: 13px;">
            <td>KEMBALIAN   :</td>
            <td class="text-right">Rp{{ number_format($transaction->total_return, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="text-center" style="margin-top: 15px;">
        <p style="margin: 0;">-- TERIMA KASIH --</p>
        <p style="margin: 5px 0 0 0; font-size: 10px;">Aplikasi POS Margent Sitompul</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>
</html>