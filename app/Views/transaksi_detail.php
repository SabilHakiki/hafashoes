<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Detail Order</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('mainmenu') ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('transaksi') ?>">Transaksi</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <!-- Data Order -->
            <div class="card mb-4">
                <div class="card-header ">
                    <strong>Data Order</strong>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nomor</th>
                            <td><?= esc($order['order_number']) ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td><?= date('l, d F Y', strtotime($order['tanggal_pesanan'])) ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span class="badge bg-info"><?= esc($order['status']) ?></span></td>
                        </tr>
                        <tr>
                            <th>Total Harga</th>
                            <td>IDR <?= number_format($order['grand_total'], 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Kurir</th>
                            <td><?= esc(ucwords($order['kurir'] ?? '-')) ?></td>
                        </tr>
                        <tr>
                            <th>Layanan</th>
                            <td><?= esc(ucwords($order['layanan'] ?? '-')) ?></td>
                        </tr>
                        <tr>
                            <th>Alamat Pengiriman</th>
                            <td><?= esc($order['alamat_pengiriman']) ?></td>
                        </tr>
                        <tr>
                            <?php if ($order['no_resi']): ?>
                                <div class="mb-3">
                                    <th>Nomor Resi</th>
                                    <td><?= esc($order['no_resi']) ?></td>
                                </div>
                            <?php endif; ?>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Barang dalam Pesanan -->
            <div class="card">
                <div class="card-header ">
                    <strong>Barang dalam Pesanan</strong>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderDetails as $item): ?>
                                <tr>
                                    <td><?= esc($item['nama']) ?></td>
                                    <td><?= esc($item['jumlah']) ?></td>
                                    <td>IDR <?= number_format($item['harga'], 0, ',', '.') ?></td>
                                    <td>IDR <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <?php if ($order['ongkir'] > 0): ?>
                                        <td colspan="3">Ongkir</td>
                                        <td>IDR <?= number_format($order['ongkir'], 0, ',', '.') ?></td>
                                    <?php endif; ?>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Data Penerima -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header ">
                    <strong>Data Penerima</strong>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama</th>
                            <td><?= esc($order['nama_pembeli']) ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= esc($customer['email']) ?></td>
                        </tr>
                        <tr>
                            <th>No HP</th>
                            <td><?= esc($customer['nohp']) ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= esc($order['alamat_pengiriman']) ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Tindakan -->
            <div class="card mb-4">
                <div class="card-header ">
                    <strong> </strong>
                </div>
                <div class="card-body">
                    <?php if ($order['status'] == 'Belum Dibayar'): ?>
                        <button class="btn btn-success w-100 mb-2" onclick="bayarSekarang('<?= $order['snap_token']; ?>')">Bayar Sekarang</button>
                    <?php endif; ?>
                    <?php if ($order['status'] != 'Gagal' && $order['status'] != 'Belum Dibayar') : ?>
                        <a href="<?= base_url('transaksi/invoice/' . $order['id']) ?>" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-printer"></i> Cetak Invoice
                        </a>
                    <?php endif; ?>
                    <a href="<?= base_url('transaksi') ?>" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-sQIOvET0PN0icODCdQadnjfn"></script>
<script>
    function bayarSekarang(snaptoken) {
        snap.pay(snaptoken, {
            onSuccess: function(result) {
                console.log('Pembayaran berhasil:', result);
                // Panggil program clear untuk membersihkan data keranjang
                fetch('<?= base_url('clear') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            order_id: result.order_id
                        }),
                    })
                    .then(response => {
                        if (response.ok) {
                            console.log('Keranjang berhasil dibersihkan.');
                        } else {
                            console.error('Gagal membersihkan keranjang.');
                        }
                        // Redirect ke halaman transaksi
                        window.location.href = '<?= base_url('transaksi') ?>';
                    })
                    .catch(error => {
                        console.error('Terjadi kesalahan saat membersihkan keranjang:', error);
                        window.location.href = '<?= base_url('transaksi') ?>';
                    });
            },
            onPending: function(result) {
                console.log('Menunggu pembayaran:', result);
                window.location.href = '<?= base_url('transaksi') ?>';
            },
            onClose: function() {
                console.log("Transaksi dibatalkan.");
            }
        });
    }
</script>

<?= $this->endSection(); ?>