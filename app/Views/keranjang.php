<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Keranjang</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('mainmenu'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Keranjang</li>
        </ol>
    </nav>
</div>

<div class="container">
    <div class="card">
        <div class="container mt-3">
            <div class="d-flex justify-content-between">
                <h3>Detail Keranjang</h3>
                <div class="mb-3 d-flex justify-content-end">
                    <a href="<?= base_url('checkout'); ?>" class="btn btn-outline-warning me-2">Checkout</a>
                    <a href="<?= base_url('keranjang/hapusall'); ?>" class="btn btn-outline-danger me-2">Kosongkan</a>
                    <a href="<?= base_url('mainmenu'); ?>" class="btn btn-outline-primary">Lanjutkan belanja</a>
                </div>
            </div>

            <!-- Tabel Keranjang Belanja -->
            <div class="table-responsive">

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


                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Gambar</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($keranjang)): ?>
                            <?php foreach ($keranjang as $idbarang => $item): ?>
                                <tr>
                                    <td>
                                        <?php
                                        $images = json_decode($item['gmbr'], true);
                                        $firstImage = !empty($images) ? $images[0] : 'default.jpg';
                                        ?>
                                        <img src="<?= base_url('gmbrproduk/' . $firstImage); ?>" alt="..." class="responsive-image">
                                    </td>
                                    <td><?= esc($item['nama']); ?></td>
                                    <td>
                                        <form action="<?= base_url('keranjang/update'); ?>" method="POST" class="d-inline-block d-flex align-items-center">
                                            <input type="hidden" name="id_keranjang" value="<?= esc($item['id']); ?>">
                                            <input type="number" name="jumlah" class="form-control me-2" value="<?= esc($item['jumlah']); ?>" min="1" max="<?= esc($item['stok']); ?>" style="width: 80px;">
                                            <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                                        </form>
                                    </td>

                                    <td>
                                        <span class="text-success">IDR <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary bi bi-trash" data-bs-toggle="modal" data-bs-target="#hapus<?= $item['id']; ?>"></button>
                                        <form action="<?= base_url('keranjang/hapus'); ?>" method="post">
                                            <div class="modal fade" id="hapus<?= $item['id']; ?>" tabindex="-1" aria-labelledby="modal2Label">
                                                <div class="modal-dialog modal-dialog-centered ">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal2label">Hapus produk</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div>
                                                                <div class="col-md-8 col-lg-9">
                                                                    <input name="idkeranjang" type="hidden" class="form-control" id="idkeranjang" value=" <?= $item['id']; ?>">
                                                                    <input name="eproduk" type="hidden" class="form-control" id="eproduk" value=" <?= $item['nama']; ?>">
                                                                </div>
                                                                <a id="eproduk " value=""></a>
                                                                <label>Apakah Anda Ingin Menghapus produk <?= $item['nama']; ?> dari keranjang?</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Ya</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Keranjang belanja Anda kosong.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>