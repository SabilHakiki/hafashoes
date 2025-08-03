<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>


<div class="pagetitle">
    <h1>Kurir</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('mainmenu') ?>">Home</a></li>
            <li class="breadcrumb-item active">Kurir</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="mt-3 d-flex justify-content-between">
                        <h3>Daftar Pesanan untuk Dikirim</h3>
                    </div>

                    <!-- Tampilkan pesan sukses atau error -->
                    <?php if (session()->getFlashdata('success1')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="flash-message-success">
                            <?= session()->getFlashdata('success1'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php elseif (session()->getFlashdata('error1')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="flash-message-error">
                            <?= session()->getFlashdata('error1'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <script>
                        setTimeout(function() {
                            let successAlert = document.getElementById('flash-message-success');
                            let errorAlert = document.getElementById('flash-message-error');

                            if (successAlert) {
                                successAlert.classList.remove('show');
                                setTimeout(() => {
                                    successAlert.remove();
                                }, 150); // Waktu tambahan agar efek fade out berjalan mulus
                            }

                            if (errorAlert) {
                                errorAlert.classList.remove('show');
                                setTimeout(() => {
                                    errorAlert.remove();
                                }, 150);
                            }
                        }, 3000); // Tutup pesan setelah 3 detik
                    </script>
                    <!-- --------------- -->

                    <table class="table datatable table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pembeli</th>
                                <th>Alamat</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($pesanan) : ?>
                                <?php foreach ($pesanan as $pesan) : ?>
                                    <tr>
                                        <td><?= $pesan['order_number'] ?></td>
                                        <td><?= $pesan['nama_user'] ?></td>
                                        <td class="text-wrap" style="max-width: 250px;"><?= $pesan['alamat_pengiriman'] ?></td>
                                        <td>IDR <?= number_format($pesan['grand_total'], 0, ',', '.') ?></td>
                                        <td><?= $pesan['status'] ?></td>
                                        <td>
                                            <button type=" button" class="btn btn-primary bi bi-pencil-square " data-bs-toggle="modal" data-bs-target="#viewkurir<?= $pesan['id']; ?>"></button>
                                            <?php if (strtolower($pesan['metode_pembayaran']) !== 'cod'): ?>
                                                <button class="btn btn-outline-warning w-60 " data-bs-toggle="modal" data-bs-target="#inputResiModal<?= $pesan['id']; ?>">Input Resi</button>
                                            <?php endif; ?>
                                            <!-- MODAL-->
                                            <form method="post" action="<?= base_url('/kurir/update_status') ?>">
                                                <div class="modal fade" id="viewkurir<?= $pesan['id']; ?>" tabindex="-1" aria-labelledby="modal2Label">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modal2Label">Detail Pesanan</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col-lg-3 col-md-4 label">Nama Pembeli</div>
                                                                    <div class="col-lg-9 col-md-8">: <?= $pesan['nama_user']; ?></div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-lg-3 col-md-4 label">Nomor telepon</div>
                                                                    <div class="col-lg-9 col-md-8">: <?= $pesan['nohp']; ?></div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                                                                    <div class="col-lg-9 col-md-8">: <?= $pesan['alamat_pengiriman']; ?></div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-lg-3 col-md-4 label">Total Harga</div>
                                                                    <div class="col-lg-9 col-md-8">: IDR <?= number_format($pesan['total_harga'], 0, ',', '.') ?></div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-lg-3 col-md-4 label">Ongkir</div>
                                                                    <div class="col-lg-9 col-md-8">: IDR <?= number_format($pesan['ongkir'], 0, ',', '.') ?></div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-lg-3 col-md-4 label">Ekspedisi</div>
                                                                    <div class="col-lg-9 col-md-8">: <?= $pesan['kurir']; ?> - <?= $pesan['layanan']; ?></div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-lg-3 col-md-4 label">Metode Pembayaran</div>
                                                                    <div class="col-lg-9 col-md-8">: <?= $pesan['metode_pembayaran']; ?></div>
                                                                </div>
                                                                <?php if ($pesan['metode_pembayaran'] !== 'COD'): ?>
                                                                    <div class="row mb-3">
                                                                        <div class="col-lg-3 col-md-4 label">No Resi</div>
                                                                        <div class="col-lg-9 col-md-8">: <?= $pesan['no_resi']; ?></div>

                                                                    </div>
                                                                <?php endif; ?>

                                                                <!-- Tabel Detail Produk -->
                                                                <table class="table table-borderless">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Produk</th>
                                                                            <th>Jumlah</th>
                                                                            <th>Harga</th>
                                                                            <th>Subtotal</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $total = 0;
                                                                        $orderDetails = $orderDetailModel->getDetailsByOrderId($pesan['id']);
                                                                        ?>
                                                                        <?php foreach ($orderDetails as $item): ?>
                                                                            <tr>
                                                                                <td><?= esc(ucwords($item['nama'])); ?></td>
                                                                                <td><?= esc($item['jumlah']); ?> Box</td>
                                                                                <td>IDR <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                                                                                <td>IDR <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></td>
                                                                            </tr>
                                                                            <?php $total += $item['harga'] * $item['jumlah']; ?>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>

                                                                <!-- Form Update Status -->

                                                                <input type="hidden" name="order_id" value="<?= $pesan['id'] ?>">
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status Pengiriman</label>
                                                                    <select name="status" class="form-select" id="status">
                                                                        <option value="Dalam Proses" <?= $pesan['status'] === 'Dalam Proses' ? 'selected' : '' ?>>Dalam Proses</option>
                                                                        <option value="Sedang Dikirim" <?= $pesan['status'] === 'Sedang Dikirim' ? 'selected' : '' ?>>Sedang Dikirim</option>
                                                                        <option value="Selesai" <?= $pesan['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary mt-2">Update Status</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- RESI -->
                                            <div class="modal fade" id="inputResiModal<?= $pesan['id']; ?>" tabindex="-1" aria-labelledby="inputResiModalLabel<?= $pesan['id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="<?= base_url('transaksi/inputResi/' . $pesan['id']) ?>" method="post">
                                                            <?= csrf_field() ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="inputResiModalLabel<?= $pesan['id']; ?>">Input Nomor Resi</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="no_resi" class="form-label">Nomor Resi</label>
                                                                    <input type="text" class="form-control" id="no_resi" name="no_resi" value="<?= $pesan['no_resi']; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan Resi</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal -->
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada pesanan untuk dikirim</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="mt-3 d-flex justify-content-between">
                        <h3>Pesanan Belum Diambil</h3>
                    </div>

                    <!-- Tampilkan pesan sukses atau error -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="flash-message-success">
                            <?= session()->getFlashdata('success'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php elseif (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="flash-message-error">
                            <?= session()->getFlashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <script>
                        setTimeout(function() {
                            let successAlert = document.getElementById('flash-message-success');
                            let errorAlert = document.getElementById('flash-message-error');

                            if (successAlert) {
                                successAlert.classList.remove('show');
                                setTimeout(() => {
                                    successAlert.remove();
                                }, 150); // Waktu tambahan agar efek fade out berjalan mulus
                            }

                            if (errorAlert) {
                                errorAlert.classList.remove('show');
                                setTimeout(() => {
                                    errorAlert.remove();
                                }, 150);
                            }
                        }, 3000); // Tutup pesan setelah 3 detik
                    </script>
                    <!-- --------------- -->

                    <table class="table datatable table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pembeli</th>
                                <th>Alamat</th>
                                <th>Total Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ambil as $pesan): ?>
                                <?php if (is_null($pesan['kurir_id'])): // Hanya pesanan yang belum diambil 
                                ?>
                                    <tr>
                                        <td><?= $pesan['order_number']; ?></td>
                                        <td><?= esc($pesan['nama_user']); ?></td>
                                        <td class="text-wrap" style="max-width: 250px;"><?= esc($pesan['alamat_pengiriman']); ?></td>
                                        <td>IDR <?= number_format($pesan['grand_total'], 0, ',', '.'); ?></td>
                                        <td>
                                            <form method="post" action="<?= base_url('/kurir/ambilPesanan'); ?>">
                                                <input type="hidden" name="order_id" value="<?= $pesan['id']; ?>">
                                                <button type="submit" class="btn btn-success">Ambil Pesanan</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mt-3 d-flex justify-content-between">
                <h3>Riwayat Pengiriman</h3>
            </div>
            <table class="table datatable table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pembeli</th>
                        <th>Alamat</th>
                        <th>Total Harga</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Kurir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $od) : ?>
                        <tr>
                            <td><?= $od['order_number'] ?></td>
                            <td><?= $od['nama_user'] ?></td>
                            <td class="text-wrap" style="max-width: 250px;"><?= $od['alamat_pengiriman'] ?></td>
                            <td>IDR <?= number_format($od['Grand_total'], 0, ',', '.') ?></td>
                            <td><?= date('Y-m-d', strtotime($od['tanggal_pengiriman'])) ?></td>
                            <td><?= $od['kurir'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>



<?= $this->endSection(); ?>

<!-- Modal Detail Pesanan dengan Update Status -->
<form method="post" action="<?= base_url('/kurir/update_status') ?>">
    <div class="modal fade" id="viewkurir<?= $pesan['id']; ?>" tabindex="-1" aria-labelledby="modal2Label">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal2Label">Detail Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-4 label">Nama Pembeli</div>
                        <div class="col-lg-9 col-md-8">: <?= $pesan['nama_user']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-4 label">Nomor telepon</div>
                        <div class="col-lg-9 col-md-8">: <?= $pesan['nohp']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-4 label">Alamat</div>
                        <div class="col-lg-9 col-md-8">: <?= $pesan['alamat_pengiriman']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-4 label">Total Harga</div>
                        <div class="col-lg-9 col-md-8">: IDR <?= number_format($pesan['total_harga'], 0, ',', '.') ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-4 label">Ongkir</div>
                        <div class="col-lg-9 col-md-8">: IDR <?= number_format($pesan['ongkir'], 0, ',', '.') ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-4 label">Kurir</div>
                        <div class="col-lg-9 col-md-8">: <?= $pesan['kurir']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-4 label">Layanan</div>
                        <div class="col-lg-9 col-md-8">: <?= $pesan['layanan']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-4 label">Metode Pembayaran</div>
                        <div class="col-lg-9 col-md-8">: <?= $pesan['metode_pembayaran']; ?></div>
                    </div>

                    <!-- Tabel Detail Produk -->
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            $orderDetails = $orderDetailModel->getDetailsByOrderId($pesan['id']);
                            ?>
                            <?php foreach ($orderDetails as $item): ?>
                                <tr>
                                    <td><?= esc(ucwords($item['nama'])); ?></td>
                                    <td><?= esc($item['jumlah']); ?> Box</td>
                                    <td>IDR <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                                    <td>IDR <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></td>
                                </tr>
                                <?php $total += $item['harga'] * $item['jumlah']; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Form Update Status -->

                    <input type="hidden" name="order_id" value="<?= $pesan['id'] ?>">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Pengiriman</label>
                        <select name="status" class="form-select" id="status">
                            <option value="Dalam Proses" <?= $pesan['status'] === 'Dalam Proses' ? 'selected' : '' ?>>Dalam Proses</option>
                            <option value="Sedang Dikirim" <?= $pesan['status'] === 'Sedang Dikirim' ? 'selected' : '' ?>>Sedang Dikirim</option>
                            <option value="Selesai" <?= $pesan['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary mt-2">Update Status</button>

                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal -->