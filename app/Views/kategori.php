<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Kategori</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="mainmenu">Home</a></li>
            <li class="breadcrumb-item active">kategori</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="mt-3 d-flex justify-content-between">
                        <h3>Detail Kategori</h3>
                        <button type="button" class="btn btn-outline-primary btn-container" data-bs-toggle="modal" data-bs-target="#verticalycentered">
                            Tambah Kategori
                        </button>
                        <form action="<?= base_url() . 'newkategori'; ?>" method="post">
                            <div class="modal fade" id="verticalycentered" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Kategori</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label for="nkategori" class="col-md-4 col-lg-3 col-form-label">Nama Kategori</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="nkategori" type="text" class="form-control" id="nkategori" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kategori as $item) : ?>
                                <tr>
                                    <td><?= $item['id_kategori']; ?></td>
                                    <td><?= $item['nkategori']; ?></td>
                                    <td>

                                        <div class="icon">
                                            <button type="button" class="btn btn-primary bi bi-pencil-square" data-bs-toggle="modal" data-bs-target="#editkategori<?= $item['id_kategori']; ?>"></button>
                                            <button type="button" class="btn btn-primary bi bi-trash" data-bs-toggle="modal" data-bs-target="#hapuskategori<?= $item['id_kategori']; ?>"></button>
                                        </div>
                                        <form action="<?= base_url() . 'editkategori'; ?>" method="post">
                                            <div class="modal fade" id="editkategori<?= $item['id_kategori']; ?>" tabindex="-1" aria-labelledby="modal2Label">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal2Label">Edit Kategori</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-3">
                                                                <label for="ekategori" class="col-md-4 col-lg-3 col-form-label">Nama Kategori</label>
                                                                <div class="col-md-8 col-lg-9">
                                                                    <input name="idkategori" type="hidden" class="form-control" id="idkategori" value="<?= $item['id_kategori']; ?>">
                                                                    <input name="ekategori" type="text" class="form-control" id="ekategori" value="<?= $item['nkategori']; ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form action="<?= base_url() . 'hapuskategori'; ?>" method="post">
                                            <div class="modal fade" id="hapuskategori<?= $item['id_kategori']; ?>" tabindex="-1" aria-labelledby="modal2Label">
                                                <div class="modal-dialog modal-dialog-centered ">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal2label">Hapus Kategori</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div>
                                                                <div class="col-md-8 col-lg-9">
                                                                    <input name="idkategori2" type="hidden" class="form-control" id="idkategori2" value=" <?= $item['id_kategori']; ?>">
                                                                    <input name="ekategori2" type="hidden" class="form-control" id="ekategori2" value=" <?= $item['nkategori']; ?>">
                                                                </div>
                                                                <a id="ekategori2 " value=""></a>
                                                                <label>Apakah Anda Ingin Menghapus Kategori <?= $item['nkategori']; ?> ?</label>
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