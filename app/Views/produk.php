<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>


<div class="pagetitle">
    <h1>Produk</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="mainmenu">Home</a></li>
            <li class="breadcrumb-item active">Produk</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="mt-3 d-flex justify-content-between">
                        <h3>Detail produk</h3>
                        <div class="mb-3 d-flex justify-content-end">
                            <a href="<?= base_url('addproduk'); ?>" class="btn btn-outline-primary">Tambah Produk</a>
                        </div>
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
                                <th>Gambar</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                                <!-- <th data-type="date" data-format="YYYY/DD/MM">Start Date</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produk as $item) : ?>
                                <tr>
                                    <td>
                                        <?php
                                        $images = json_decode($item['gmbr'], true);
                                        $firstImage = !empty($images) ? $images[0] : 'default.jpg';
                                        ?>
                                        <img src="<?= base_url('gmbrproduk/' . $firstImage); ?>" alt="..." class="responsive-image">
                                    </td>
                                    <td><?= $item['nama']; ?></td>
                                    <td><?= $item['nkategori']; ?></td>
                                    <td><?= number_format($item['harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?= $item['stok'] > 0 ? $item['stok'] : '<span class="text-danger">Kosong</span>'; ?>
                                    </td>
                                    <td>
                                        <div class="icon">
                                            <a href="<?= base_url('updateproduk/' . $item['id']); ?>" class="btn btn-outline-primary bi bi-pencil-square"></a>
                                            <button type="button" class="btn btn-outline-primary bi bi-trash" data-bs-toggle="modal" data-bs-target="#hapusproduk<?= $item['id']; ?>"></button>
                                        </div>
                                        <form action="<?= base_url() . 'hapusproduk'; ?>" method="post">
                                            <div class="modal fade" id="hapusproduk<?= $item['id']; ?>" tabindex="-1" aria-labelledby="modal2Label">
                                                <div class="modal-dialog modal-dialog-centered ">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal2label">Hapus produk</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div>
                                                                <div class="col-md-8 col-lg-9">
                                                                    <input name="idproduk" type="hidden" class="form-control" id="idproduk" value=" <?= $item['id']; ?>">
                                                                    <input name="eproduk" type="hidden" class="form-control" id="eproduk" value=" <?= $item['nama']; ?>">
                                                                </div>
                                                                <label>Apakah Anda Ingin Menghapus produk <?= $item['nama']; ?> ?</label>
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
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection(); ?>