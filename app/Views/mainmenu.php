<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <h2>Produk</h2>

        <form method="GET" action="<?= base_url('mainmenu') ?>" class="d-flex">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Cari produk..." value="<?= esc($keyword) ?>">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>
    </div>

    <?php $counter = 0; ?>
    <?php foreach ($produk as $item): ?>
        <?php if ($item['stok'] > 0): ?>
            <?php if ($counter % 4 == 0): ?>
                <div class="row mb-4">
                <?php endif; ?>

                <div class="col-md-3">
                    <div class="card fixed-size">
                        <a href="<?= base_url('detail_produk/' . $item['id']); ?>">
                            <?php
                            $images = json_decode($item['gmbr'], true);
                            $firstImage = !empty($images) ? $images[0] : 'default.jpg';
                            ?>
                            <img src="<?= base_url('gmbrproduk/' . $firstImage); ?>" alt="..." class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= ucwords($item['nama']) ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= esc($item['nkategori']); ?></h6>
                                <p class="card-text">IDR <?= number_format($item['harga'], 0, ',', '.') ?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <?php $counter++; ?>
                <?php if ($counter % 4 == 0): ?>
                </div>
            <?php endif; ?>
        <?php endif; ?> <!-- Tutup cek stok -->
    <?php endforeach; ?>
    <?php if ($counter % 4 != 0): ?>
</div>
<?php endif; ?>
</div>

<?= $this->endSection(); ?>