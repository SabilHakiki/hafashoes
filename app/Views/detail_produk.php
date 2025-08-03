<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="mt-3 d-flex justify-content-between">
                <h1>Detail Produk</h1>
                <div class="mb-3 d-flex justify-content-end">
                    <a href="<?= base_url('mainmenu'); ?>" class="btn btn-outline-primary">Kembali</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="product-detail-container row mt-4 align-items-start">
                        <!-- Gambar Produk -->
                        <div class="col-md-5">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <?php foreach ($gambarproduk as $key => $gambar): ?>
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $key ?>" class="<?= $key == 0 ? 'active' : '' ?>" aria-current="true"></button>
                                    <?php endforeach; ?>
                                </div>
                                <div class="carousel-inner">
                                    <?php foreach ($gambarproduk as $key => $gambar): ?>
                                        <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                                            <img src="<?= base_url('gmbrproduk/' . $gambar) ?>" class="d-block w-100" alt="Gambar Produk <?= $key + 1 ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>

                        <!-- Informasi Produk -->
                        <div class="col-md-7 product-info">
                            <h2><?= esc($produk['nama']) ?></h2>
                            <h5>IDR <?= number_format($produk['harga'], 0, ',', '.') ?> <small class="text-muted">per 1⁄4 Kodi</small></h5>
                            <p><?= $produk['stok'] > 0 ? 'Produk tersedia untuk pembelian.' : 'Produk tidak tersedia.' ?></p>
                            <p><strong>Kategori :</strong> <?= $produk['nkategori']; ?></p>
                            <p><strong>Stok :</strong> <?= esc($produk['stok']) ?> box</p>

                            <!-- Form Tambah Ke Keranjang -->
                            <?php if ($produk['stok'] <= 0): ?>
                                <p class="text-danger"><strong>Stok Habis</strong></p>
                                <button class="btn btn-secondary" disabled>Tambah</button>
                            <?php else: ?>
                                <form action="<?= base_url('keranjang/tambah') ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="idbarang" value="<?= esc($produk['id']) ?>">
                                    <input type="hidden" name="nama" value="<?= esc($produk['nama']) ?>">
                                    <input type="hidden" name="harga" value="<?= esc($produk['harga']) ?>">
                                    <input type="hidden" name="gmbr" value="<?= esc($produk['gmbr']) ?>">

                                    <!-- Input Spinner -->
                                    <div class="form-group">
                                        <div class="input-spinner">
                                            <button id="decrease" type="button">−</button>
                                            <input id="spinnerInput" name="jumlah" type="text" value="1" readonly>
                                            <button id="increase" type="button">+</button>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            <?php endif; ?>

                            <div class="product-description mt-3">
                                <h5><strong>Deskripsi:</strong></h5>
                                <p><?= nl2br(esc($produk['deskripsi'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const maxStock = <?= json_encode($produk['stok']) ?>;
    const input = document.getElementById('spinnerInput');
    const decreaseButton = document.getElementById('decrease');
    const increaseButton = document.getElementById('increase');

    decreaseButton.addEventListener('click', function() {
        let value = parseInt(input.value, 10);
        if (value > 1) {
            input.value = value - 1;
        }
    });

    increaseButton.addEventListener('click', function() {
        let value = parseInt(input.value, 10);
        if (value < maxStock) {
            input.value = value + 1;
        }
    });
</script>

<?= $this->endSection(); ?>