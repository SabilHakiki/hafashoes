<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>


<section class="section profile">
    <div class="row justify-content-center">
        <div class="col-xl-8  ">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Tambah Produk</button>
                        </li>
                    </ul>

                    <form action="<?= base_url() . 'newproduk'; ?>" method="post" enctype="multipart/form-data">
                        <div class="tab-pane fade profile-edit pt-2 active show" id="profile-edit">
                            <div class="row mb-3">
                                <label for="nbarang" class="col-md-4 col-lg-3 col-form-label">Nama Barang</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="nbarang" type="text" class="form-control <?= isset($valid['nbarang']) ? 'is-invalid' : ''; ?>" id="nbarang" value="<?= old('nbarang'); ?>">
                                    <div class="invalid-feedback">
                                        <?= isset($valid['nbarang']) ? $valid['nbarang'] : '' ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="kategori" class="col-md-4 col-lg-3 col-form-label">Kategori</label>
                                <div class="col-md-8 col-lg-9">
                                    <select name="kategori" class="form-select <?= isset($valid['kategori']) ? 'is-invalid' : ''; ?>" id="kategori">
                                        <option value="">Pilih</option> <!-- Nilai default untuk memvalidasi pilihan -->
                                        <?php foreach ($kategori as $kat): ?>
                                            <option value="<?= $kat['id_kategori']; ?>" <?= old('kategori') == $kat['id_kategori'] ? 'selected' : '' ?>>
                                                <?= $kat['nkategori']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= isset($valid['kategori']) ? $valid['kategori'] : '' ?>
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="harga" class="col-md-4 col-lg-3 col-form-label">Harga</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="harga" type="number" class="form-control <?= isset($valid['harga']) ? 'is-invalid' : ''; ?>" id="harga" value="<?= old('harga'); ?>">
                                    <div class="invalid-feedback"> <?= isset($valid['harga']) ? $valid['harga'] : '' ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="stok" class="col-md-4 col-lg-3 col-form-label">Stok</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="stok" type="number" class="form-control <?= isset($valid['stok']) ? 'is-invalid' : ''; ?>" id="stok" value="<?= old('stok'); ?>">
                                    <div class="invalid-feedback"> <?= isset($valid['stok']) ? $valid['stok'] : '' ?></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="deskripsi" class="col-md-4 col-lg-3 col-form-label">Deskripsi</label>
                                <div class="col-md-8 col-lg-9">
                                    <textarea name="deskripsi" type="text" class="form-control" id="deskripsi" style="height: 100px">
Produk dijual dalam satuan ¼ kodi / 1 box
1 box berisi 5 pasang sepatu
ukuran 39-43
Bahan menggunakan kulit sintetis
                                    </textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="gambar" class="col-md-4 col-lg-3 col-form-label">Gambar</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="gambar[]" class="form-control <?= isset($valid['gambar']) ? 'is-invalid' : ''; ?>" type="file" id="gambar" accept="image/*" multiple onchange="previewImages()">
                                    <div class="invalid-feedback"><?= $valid['gambar'] ?? ''; ?></div>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <label for="stok" class="col-md-4 col-lg-3 col-form-label"></label>
                            <div class="col-md-8 col-lg-9">
                                <div id="image-carousel" class="carousel slide mt-2" data-bs-ride="carousel" style="display: none;">
                                    <div class="carousel-inner" id="carousel-inner"></div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#image-carousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#image-carousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function previewImages() {
        const carousel = document.getElementById('image-carousel');
        const carouselInner = document.getElementById('carousel-inner');
        const files = document.getElementById('gambar').files;

        // Hapus konten carousel sebelumnya
        carouselInner.innerHTML = '';

        if (files.length > 0) {
            // Tampilkan carousel
            carousel.style.display = 'block';

            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Buat item carousel baru
                    const div = document.createElement('div');
                    div.classList.add('carousel-item');
                    if (i === 0) {
                        div.classList.add('active'); // Set slide pertama sebagai aktif
                    }

                    // Buat elemen gambar
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('d-block', 'w-100', 'h-100');
                    img.style.objectFit = 'cover'; // Gambar mengisi seluruh area

                    div.appendChild(img);

                    // Tambahkan ke carousel-inner
                    carouselInner.appendChild(div);
                };
                reader.readAsDataURL(files[i]);
            }
        } else {
            // Sembunyikan carousel jika tidak ada gambar
            carousel.style.display = 'none';
        }
    }
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->endSection(); ?>