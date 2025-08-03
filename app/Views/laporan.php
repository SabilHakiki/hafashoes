<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Laporan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('mainmenu') ?>">Home</a></li>
            <li class="breadcrumb-item active">Laporan Penjualan</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-body">
                <div class="mt-3 d-flex justify-content-between">
                    <h1>Laporan Penjualan</h1>
                </div>
                <div class="container mt-5">
                    <form method="GET" action="<?= base_url('laporan') ?>">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label for="filter-month" class="form-label">Pilih Bulan:</label>
                                <select class="form-select" id="filter-month" name="filter-month">
                                    <?php for ($m = 1; $m <= 12; $m++) : ?>
                                        <option value="<?= $m ?>" <?= ($filterMonth == $m) ? 'selected' : '' ?>>
                                            <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="filter-year" class="form-label">Pilih Tahun:</label>
                                <select class="form-select" id="filter-year" name="filter-year">
                                    <?php
                                    $currentYear = date('Y');
                                    for ($y = $currentYear - 5; $y <= $currentYear; $y++) : // Menampilkan 5 tahun terakhir
                                    ?>
                                        <option value="<?= $y ?>" <?= ($filterYear == $y) ? 'selected' : '' ?>><?= $y ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary d-block w-100">Filter</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-5">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Total Penjualan</h5>
                                    <p class="card-text">IDR <?= number_format($totalPenjualan, 0, ',', '.') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Jumlah Produk Terjual</h5>
                                    <p class="card-text"><?= $jumlahProdukTerjual ?> Items</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Jumlah Transaksi</h5>
                                    <p class="card-text"><?= $jumlahTransaksi ?> Transaksi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik Penjualan -->
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div id="areaChart"></div>
                        </div>
                    </div>

                    <!-- Daftar Transaksi -->
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h4>Detail Transaksi</h4>
                            <table class="table datatable table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID Transaksi</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">nama</th>
                                        <th scope="col">Produk</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($transaksi) : ?>
                                        <?php foreach ($transaksi as $trx) : ?>
                                            <tr>
                                                <td><?= $trx['order_number'] ?></td>
                                                <td><?= date('Y-m-d', strtotime($trx['tanggal_pesanan'])) ?></td>
                                                <td><?= $trx['nama_pembeli'] ?></td>
                                                <td><?= $trx['nama_produk'] ?></td>
                                                <td><?= $trx['jumlah'] ?></td>
                                                <td>IDR <?= number_format($trx['subtotal'], 0, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach ?>
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
</div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        new ApexCharts(document.querySelector("#areaChart"), {
            series: [{
                name: "Total Penjualan",
                data: <?= $datagrafik ?>
            }],
            chart: {
                height: 350,
                type: 'area',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // alternating row colors
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: <?= $bulan ?>
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return ' ' + value.toLocaleString('id-ID');
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return 'IDR ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }).render();
    });
</script>




<?= $this->endSection(); ?>