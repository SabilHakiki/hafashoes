<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Transaksi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('mainmenu') ?>">Home</a></li>
            <li class="breadcrumb-item active">Transaksi</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="mt-3 d-flex justify-content-between">
                        <?php if ($user['role'] === 'admin'): ?>
                            <h3>Semua Transaksi</h3>
                        <?php else: ?>
                            <h3>Riwayat Transaksi</h3>
                        <?php endif; ?>

                    </div>

                    <ul class="nav nav-tabs nav-tabs-bordered d-flex" role="tablist">
                        <li class="nav-item flex-fill">
                            <button class="nav-link active w-100" data-bs-toggle="tab" data-bs-target="#belum_dibayar" type="button">Belum Dibayar</button>
                        </li>
                        <li class="nav-item flex-fill">
                            <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#menunggu_konfirmasi" type="button">Menunggu Konfirmasi</button>
                        </li>
                        <li class="nav-item flex-fill">
                            <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#dalam_proses" type="button">Dalam Proses</button>
                        </li>
                        <li class="nav-item flex-fill">
                            <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#sedang_dikirim" type="button">Sedang Dikirim</button>
                        </li>
                        <li class="nav-item flex-fill">
                            <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#selesai" type="button">Selesai</button>
                        </li>
                        <li class="nav-item flex-fill">
                            <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#gagal" type="button">Gagal</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                        <div class="tab-pane fade show active" id="belum_dibayar" role="tabpanel">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($belum_dibayar): ?>
                                        <?php foreach ($belum_dibayar as $item): ?>
                                            <tr>
                                                <td><?= esc($item['order_number']); ?></td>
                                                <td><?= date('Y-m-d', strtotime($item['tanggal_pesanan'])); ?></td>
                                                <td>IDR <?= number_format($item['grand_total'], 0, ',', '.'); ?></td>
                                                <td class="text-wrap" style="max-width: 250px;"><?= esc($item['alamat_pengiriman']); ?></td>
                                                <td>
                                                    <a href="<?= base_url('transaksi/details/' . $item['id']); ?>" class="btn btn-outline-info bi bi-caret-down-square"></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada transaksi ditemukan</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade " id="menunggu_konfirmasi" role="tabpanel" aria-labelledby="dikirim-tab">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($menunggu_konfirmasi) : ?>
                                        <?php foreach ($menunggu_konfirmasi as $item): ?>
                                            <tr>
                                                <td><?= esc($item['order_number']); ?></td>
                                                <td><?= date('Y-m-d', strtotime($item['tanggal_pesanan'])); ?></td>
                                                <td>IDR <?= number_format($item['total_harga'], 0, ',', '.'); ?></td>
                                                <td class="text-wrap" style="max-width: 250px;"><?= esc($item['alamat_pengiriman']); ?></td>
                                                <td>
                                                    <a href="<?= base_url('transaksi/details/' . $item['id']); ?>" class="btn btn-outline-info bi bi-caret-down-square"></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada transaksi ditemukan</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade " id="dalam_proses" role="tabpanel" aria-labelledby="proses-tab">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($dalam_proses) : ?>
                                        <?php foreach ($dalam_proses as $item): ?>
                                            <tr>
                                                <td><?= esc($item['order_number']); ?></td>
                                                <td><?= date('Y-m-d', strtotime($item['tanggal_pesanan'])); ?></td>
                                                <td>IDR <?= number_format($item['total_harga'], 0, ',', '.'); ?></td>
                                                <td class="text-wrap" style="max-width: 250px;"><?= esc($item['alamat_pengiriman']); ?></td>
                                                <td>
                                                    <a href="<?= base_url('transaksi/details/' . $item['id']); ?>" class="btn btn-outline-info bi bi-caret-down-square"></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada transaksi ditemukan</td>
                                        </tr>
                                    <?php endif ?>


                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="sedang_dikirim" role="tabpanel" aria-labelledby="dikirim-tab">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($sedang_dikirim) : ?>
                                        <?php foreach ($sedang_dikirim as $item): ?>
                                            <tr>
                                                <td><?= esc($item['order_number']); ?></td>
                                                <td><?= date('Y-m-d', strtotime($item['tanggal_pesanan'])); ?></td>
                                                <td>IDR <?= number_format($item['grand_total'], 0, ',', '.'); ?></td>
                                                <td class="text-wrap" style="max-width: 250px;"><?= esc($item['alamat_pengiriman']); ?></td>
                                                <td>
                                                    <a href="<?= base_url('transaksi/details/' . $item['id']); ?>" class="btn btn-outline-info bi bi-caret-down-square"></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada transaksi ditemukan</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                            <table class="table datatable table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($selesai) : ?>
                                        <?php foreach ($selesai as $item): ?>
                                            <tr>
                                                <td><?= esc($item['order_number']); ?></td>
                                                <td><?= date('Y-m-d', strtotime($item['tanggal_pesanan'])); ?></td>
                                                <td>IDR <?= number_format($item['total_harga'], 0, ',', '.'); ?></td>
                                                <td class="text-wrap" style="max-width: 250px;"><?= esc($item['alamat_pengiriman']); ?></td>
                                                <td>
                                                    <a href="<?= base_url('transaksi/details/' . $item['id']); ?>" class="btn btn-outline-info bi bi-caret-down-square"></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada transaksi ditemukan</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="gagal" role="tabpanel" aria-labelledby="gagal-tab">
                            <table class="table datatable table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($gagal) : ?>
                                        <?php foreach ($gagal as $item): ?>
                                            <tr>
                                                <td><?= esc($item['order_number']); ?></td>
                                                <td><?= date('Y-m-d', strtotime($item['tanggal_pesanan'])); ?></td>
                                                <td>IDR <?= number_format($item['total_harga'], 0, ',', '.'); ?></td>
                                                <td class="text-wrap" style="max-width: 250px;"><?= esc($item['alamat_pengiriman']); ?></td>
                                                <td>
                                                    <a href="<?= base_url('transaksi/details/' . $item['id']); ?>" class="btn btn-outline-info bi bi-caret-down-square"></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada transaksi ditemukan</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection(); ?>