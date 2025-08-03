<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 20px auto;
            width: 90%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header .left {
            text-align: left;
        }

        .header .left h2 {
            margin: 0;
            font-size: 24px;
        }

        .header .left p {
            margin: 3px 0;
            font-size: 14px;
        }

        .header .right {
            text-align: right;
        }

        .header .right h3 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }

        .header .right p {
            margin: 3px 0;
            font-size: 14px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .table .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="left">
                <h2>Hafa Shoes</h2>
                <p>Jl. Gribig Raya, Gribig, Gebog, Kudus</p>
                <p>Telp: 081390950717</p>
                <p><strong>Nama Pelanggan:</strong> <?= esc($order['nama_user']); ?></p>
                <p><strong>Alamat:</strong> <?= esc($order['alamat_pengiriman']); ?></p>
            </div>
            <div class="right">
                <h3>NOTA PEMESANAN</h3>
                <p><strong>No Trans.:</strong> #<?= esc($order['id']); ?></p>
                <p><strong>Tanggal:</strong> <?= date('d-m-y H:i', strtotime($order['tanggal_pesanan'])); ?></p>
            </div>
        </div>




        <!-- Informasi Nota -->
        <div class="container">
            <!-- Produk -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $grandTotal = 0; ?>
                    <?php foreach ($orderDetails as $item): ?>
                        <?php $subtotal = $item['harga'] * $item['jumlah']; ?>
                        <?php $grandTotal += $subtotal; ?>
                        <tr>
                            <td><?= esc($item['id_produk']); ?></td>
                            <td><?= esc($item['nama']); ?></td>
                            <td class="text-right">Rp. <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                            <td class="text-right"><?= esc($item['jumlah']); ?></td>
                            <td class="text-right">Rp. <?= number_format($subtotal, 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Total -->
            <table class="table">
                <tr>
                    <td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
                    <td class="text-right">Rp. <?= number_format($grandTotal, 0, ',', '.'); ?></td>
                </tr>
            </table>
        </div>
</body>

</html>