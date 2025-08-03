<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>

<section class="section ">
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Produk</button>
                        </li>
                    </ul>

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

                    <form action="<?= base_url('editproduk'); ?>" method="post" enctype="multipart/form-data">
                        <div class="tab-pane fade profile-edit pt-2 active show" id="profile-edit">
                            <input name="idbarang" type="hidden" class="form-control" id="idbarang" value="<?= $produk['id']; ?>">
                            <div class="row mb-3">
                                <label for="nbarang" class="col-md-4 col-lg-3 col-form-label">Nama Barang</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="nbarang" type="text" class="form-control <?= isset($valid['nbarang']) ? 'is-invalid' : ''; ?>" id="nbarang" value="<?= $produk['nama']; ?>">
                                    <div class="invalid-feedback"><?= isset($valid['nbarang']) ? $valid['nbarang'] : '' ?></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="kategori" class="col-md-4 col-lg-3 col-form-label">Kategori</label>
                                <div class="col-md-8 col-lg-9">
                                    <select name="kategori" class="form-select <?= isset($valid['kategori']) ? 'is-invalid' : ''; ?>" id="kategori">
                                        <option value="">Pilih</option>
                                        <?php foreach ($kategori as $kat): ?>
                                            <option value="<?= $kat['id_kategori']; ?>" <?= set_select('kategori', $kat['id_kategori'], $produk['kategori'] == $kat['id_kategori']); ?>>
                                                <?= $kat['nkategori']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback"><?= isset($valid['kategori']) ? $valid['kategori'] : '' ?></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="harga" class="col-md-4 col-lg-3 col-form-label">Harga</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="harga" type="number" class="form-control <?= isset($valid['harga']) ? 'is-invalid' : ''; ?>" id="harga" value="<?= $produk['harga']; ?>">
                                    <div class="invalid-feedback"><?= isset($valid['harga']) ? $valid['harga'] : '' ?></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="stok" class="col-md-4 col-lg-3 col-form-label">Stok</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="stok" type="number" class="form-control <?= isset($valid['stok']) ? 'is-invalid' : ''; ?>" id="stok" value="<?= $produk['stok']; ?>">
                                    <div class="invalid-feedback"><?= isset($valid['stok']) ? $valid['stok'] : '' ?></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="deskripsi" class="col-md-4 col-lg-3 col-form-label">Deskripsi</label>
                                <div class="col-md-8 col-lg-9">
                                    <textarea name="deskripsi" class="form-control" id="deskripsi" style="height: 100px"><?= $produk['deskripsi']; ?></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="gambar" class="col-md-4 col-lg-3 col-form-label">Gambar</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="gambar_lama" type="hidden" id="gambar_lama" value='<?= isset($produk['gmbr']) ? json_encode(json_decode($produk['gmbr'])) : "[]"; ?>'>
                                    <input name="gambar[]" class="form-control <?= isset($valid['gambar']) ? 'is-invalid' : ''; ?>" type="file" id="gambar" accept="image/*" multiple onchange="previewImages()">
                                    <div class="invalid-feedback"><?= $valid['gambar'] ?? ''; ?></div>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-3"> <!-- CAROUSEL -->
                            <label for="stok" class="col-md-4 col-lg-3 col-form-label"></label>
                            <div class="col-md-8 col-lg-9">
                                <!-- Carousel untuk menampilkan gambar lama -->
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
                    <form action="<?= base_url('deleteimage'); ?>" method="post">
                        <input type="hidden" name="idbarang" value="<?= $produk['id']; ?>">
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Hapus Semua Gambar</button>
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
            // Tampilkan carousel dengan gambar baru
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
            // Tampilkan gambar lama jika tidak ada gambar baru yang di-upload
            loadOldImages();
        }
    }

    // Fungsi untuk memuat gambar lama
    function loadOldImages() {
        const carousel = document.getElementById('image-carousel');
        const carouselInner = document.getElementById('carousel-inner');
        const oldImages = JSON.parse(document.getElementById('gambar_lama').value || '[]');

        // Jika ada gambar lama, tampilkan mereka
        if (oldImages.length > 0) {
            carousel.style.display = 'block';

            oldImages.forEach((image, index) => {
                const div = document.createElement('div');
                div.classList.add('carousel-item');
                if (index === 0) {
                    div.classList.add('active'); // Set slide pertama sebagai aktif
                }

                const img = document.createElement('img');
                img.src = `<?= base_url('gmbrproduk/'); ?>${image}`;
                img.classList.add('d-block', 'w-100', 'h-100');
                img.style.objectFit = 'cover';

                div.appendChild(img);
                carouselInner.appendChild(div);
            });
        } else {
            // Jika tidak ada gambar lama, sembunyikan carousel
            carousel.style.display = 'none';
        }
    }

    // Fungsi untuk menghapus semua gambar
    function deleteAllImages() {
        if (confirm('Apakah Anda yakin ingin menghapus semua gambar?')) {
            const idbarang = document.getElementById('idbarang').value;

            fetch('<?= base_url('deleteallimages'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        idbarang: idbarang
                    }) // Pastikan ID barang dikirim
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Debugging respons server
                    if (data.success) {
                        // Kosongkan carousel dan sembunyikan
                        const carouselInner = document.getElementById('carousel-inner');
                        carouselInner.innerHTML = '';
                        document.getElementById('image-carousel').style.display = 'none';
                        alert('Semua gambar berhasil dihapus.');
                    } else {
                        alert('Gagal menghapus gambar: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                    alert('Terjadi kesalahan saat menghapus gambar.');
                });
        }
    }


    // Panggil loadOldImages() saat halaman dimuat
    window.onload = loadOldImages;
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->endSection(); ?>