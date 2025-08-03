<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>

<style>
    @media print {
        body * {
            visibility: hidden;
            /* Sembunyikan semua elemen */
        }

        .card-body,
        .card-body * {
            visibility: visible;
            /* Tampilkan hanya elemen dalam card-body */
        }

        .card {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            /* Pastikan card mengisi halaman */
        }

        .no-print {
            display: none;
            /* Sembunyikan elemen dengan class no-print */
        }
    }
</style>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between">
            <h3 class="mb-0">Invoice</h3>
            <div class=" d-flex justify-content-end">
                <a href="<?= base_url('transaksi/details/' . $order['id']); ?>" class="btn btn-outline-info ri-arrow-go-back-fill me-2"></a>
                <a href="<?= base_url('transaksi/print/' . $order['id']); ?>" class="btn btn-outline-info bi bi-printer-fill"></a>
            </div>
        </div>

        <div class="card-body">
            <!-- Header -->
            <div class="row mt-4 mb-4">
                <div class="col-md-6">
                    <h4 class="text-uppercase"><strong>Hafa Shoes</strong></h4>
                    <p>Jl. Gribig Raya, Gribig, Gebog, Kudus</p>
                    <p>Telp: 081390950717</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5 class="text-uppercase"><strong>Nota Pemesanan</strong></h5>
                    <p><strong>No Trans.:</strong> #<?= esc($order['id']); ?></p>
                    <p><strong>Tanggal:</strong> <?= date('d-m-y H:i', strtotime($order['tanggal_pesanan'])); ?></p>
                </div>
            </div>

            <!-- Info Pelanggan -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-muted">Nama Pelanggan:</h6>
                    <p class="mb-1"><?= esc($order['nama_user']); ?></p>
                    <h6 class="text-muted">Alamat Pengiriman:</h6>
                    <p><?= esc($order['alamat_pengiriman']); ?></p>
                </div>
            </div>

            <!-- Tabel Produk -->
            <!-- Tabel Produk -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Subtotal</th>
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
                                <td class="text-end">Rp. <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                                <td class="text-end"><?= esc($item['jumlah']); ?></td>
                                <td class="text-end">Rp. <?= number_format($subtotal, 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <!-- Baris Ongkir -->
                        <tr>
                            <td colspan="4" class="text-end"><strong>Ongkir</strong></td>
                            <td class="text-end">
                                Rp. <?= number_format($order['ongkir'] ?? 0, 0, ',', '.'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Total -->
            <div class="text-end mt-3">
                <h5><strong>Grand Total:</strong>
                    Rp. <?= number_format($grandTotal + ($order['ongkir'] ?? 0), 0, ',', '.'); ?>
                </h5>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>