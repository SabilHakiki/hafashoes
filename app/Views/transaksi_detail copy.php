<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Transaksi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('mainmenu') ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('transaksi') ?>">Transaksi</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Detail Order</h3>
        </div>
        <div class="card-body">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($orderDetails as $item): ?>
                        <tr>
                            <td><?= esc(ucwords($item['nama'])); ?></td>
                            <td>IDR <?= number_format($item['harga'], 0, ',', '.'); ?>/-</td>
                            <td><?= esc($item['jumlah']); ?> Items</td>
                            <td>IDR <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php $total += $item['harga'] * $item['jumlah']; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <h5>Total Harga: <strong>IDR <?= number_format($total, 0, ',', '.'); ?></strong></h5>
            </div>

            <hr>
            <div class="mt-4">
                <div class="d-flex align-items-center">
                    <h5 class="me-3">Status:</h5>
                    <div class="progress flex-grow-1" style="height: 30px;">
                        <?php
                        $progressPercentage = 0;
                        switch ($order['status']) {
                            case 'Menunggu Konfirmasi':
                                $progressPercentage = 25;
                                break;
                            case 'Dalam Proses':
                                $progressPercentage = 50;
                                break;
                            case 'Sedang Dikirim':
                                $progressPercentage = 75;
                                break;
                            case 'Selesai':
                                $progressPercentage = 100;
                                break;
                        }
                        ?>
                        <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar"
                            style="width: <?= $progressPercentage ?>%;" aria-valuenow="<?= $progressPercentage ?>"
                            aria-valuemin="0" aria-valuemax="100">
                            <?= ucfirst($order['status']); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-warning mt-3">
                <strong>Notice</strong>
                <p>Ada kendala saat transaksi? Segera hubungi Customer Service hubunginya <a href="<?= base_url('contact'); ?>" class="text-primary">disini</a>.</p>
            </div>

            <a href="<?= base_url('transaksi') ?>" class="btn btn-secondary">Back</a>
            <a href="<?= base_url('transaksi/invoice/' . $order['id']); ?>" class="btn btn-primary">Invoice</a>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>