<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Struk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        .container {
            width: 100%;
            max-width: 21cm;
            /* A5 size width */
            min-height: 14.8cm;
            /* A5 size height */
            margin: 0 auto;
            padding: 10mm;
        }

        .header,
        .footer {
            text-align: center;
            font-weight: bold;
        }

        .header {
            font-size: 16px;
        }

        .footer {
            font-size: 12px;
            margin-top: 10mm;
        }

        .details,
        .items-table {
            width: 100%;
            margin-top: 10mm;
        }

        .details td {
            padding: 5px 0;
        }

        .details td:first-child {
            font-weight: bold;
            width: 40%;
        }

        .items-table {
            margin-top: 10mm;
            border-collapse: collapse;
            width: 100%;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .items-table th {
            background-color: #f2f2f2;
        }

        .total-row td {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h3>STRUK PEMBAYARAN</h3>
        </div>

        <table class="details">
            <tr>
                <td>Nama Pasien:</td>
                <td>{{ $detail->patient_name }}</td>
            </tr>
            <tr>
                <td>Dokter:</td>
                <td>{{ $detail->doctor_name }}</td>
            </tr>
            <tr>
                <td>Total Tagihan:</td>
                <td>Rp. {{ number_format($detail->total_invoice, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tagihan yang Sudah Dibayarkan:</td>
                <td>Rp. {{ number_format($detail->total_pay, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Kembalian:</td>
                <td>Rp. {{ number_format($detail->total_change, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tanggal Pembayaran:</td>
                <td>{{ date('Y-m-d H:i:s', strtotime($detail->payment_date)) }}</td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->medicine_name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp. {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($item->qty * $item->unit_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;">Total Harga:</td>
                    <td>Rp.
                        {{ number_format($items->sum(function ($item) {return $item->qty * $item->unit_price;}),0,',','.') }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p>Terima kasih telah berkunjung ke klinik kami!</p>
        </div>
    </div>

</body>

</html>
