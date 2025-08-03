<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Checkout</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('mainmenu') ?>">Home</a></li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <!-- Ringkasan Pesanan -->
        <div class="col-lg-7">
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Ringkasan Pesanan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; ?>
                            <?php foreach ($keranjang as $item): ?>
                                <tr>
                                    <td><?= esc($item['nama']) ?></td>
                                    <td><?= esc($item['jumlah']) ?></td>
                                    <td>IDR <?= number_format($item['harga'], 0, ',', '.') ?></td>
                                    <td>IDR <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></td>
                                </tr>
                                <?php $total += $item['harga'] * $item['jumlah']; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        <h5>Total: IDR <?= number_format($total, 0, ',', '.') ?></h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Pengiriman -->
        <div class="col-lg-5">
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Detail Pengiriman</h3>
                </div>
                <div class="card-body">
                    <form id="checkout-form" method="POST" action="<?= base_url('/processPayment') ?>">
                        <div class="mb-3">
                            <label>Nama Penerima</label>
                            <input type="text" name="nama" class="form-control" value="<?= esc($user['nama']) ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?= esc($user['email']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nomor Telepon</label>
                                <input type="text" name="telepon" class="form-control" value="<?= esc($user['nohp']) ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Alamat Tujuan</label>
                            <input type="text" id="alamat_search" class="form-control" placeholder="Ketik nama kota / kecamatan / desa..." autocomplete="off" required>
                            <div id="alamat_suggestions" class="list-group mt-1" style="position: absolute; z-index: 1000;"></div>
                            <input type="hidden" id="destination_id" name="destination_id">
                        </div>
                        <div class="mb-3">
                            <label>Detail alamat</label>
                            <textarea name="alamat" class="form-control" required><?= esc($user['alamat']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Kurir</label>
                            <select class="form-select" id="kurir" name="kurir" required>
                                <option value="">-- Pilih Kurir --</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS</option>
                                <option value="tiki">TIKI</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Ongkir</label>
                            <input type="text" id="ongkir" name="ongkir" class="form-control" readonly>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">Selesaikan Pesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Autocomplete Alamat
        $("#alamat_search").on("input", function() {
            let keyword = $(this).val().trim();
            if (keyword.length >= 2) {
                $.post("<?= base_url('getAlamatAutocomplete') ?>", {
                    search: keyword
                }, function(res) {
                    let html = "";
                    if (res.data && res.data.length > 0) {
                        res.data.forEach(item => {
                            html += `<a href="#" class="list-group-item list-group-item-action" data-id="${item.id}">${item.label}</a>`;
                        });
                    } else {
                        html = `<div class="list-group-item">Tidak ditemukan</div>`;
                    }
                    $("#alamat_suggestions").html(html).show();
                });
            } else {
                $("#alamat_suggestions").hide();
            }
        });

        // Pilih alamat
        $("#alamat_suggestions").on("click", ".list-group-item", function(e) {
            e.preventDefault();
            const label = $(this).text();
            const id = $(this).data("id");
            $("#alamat_search").val(label);
            $("#destination_id").val(id);
            $("#alamat_suggestions").hide();
            if ($("#kurir").val()) {
                hitungOngkir();
            }
        });

        // Pilih kurir
        $("#kurir").change(function() {
            if ($("#destination_id").val()) {
                hitungOngkir();
            }
        });

        function hitungOngkir() {
            let origin = "31555"; // Sesuaikan asal
            let destination = $("#destination_id").val();
            let weight = 1000; // Berat dalam gram
            let courier = $("#kurir").val();

            $.post("<?= base_url('getOngkir') ?>", {
                origin: origin,
                destination: destination,
                weight: weight,
                courier: courier
            }, function(res) {
                console.log(res); // Untuk debug

                if (res.status === 'success' && Array.isArray(res.data) && res.data.length > 0) {
                    // Ambil ongkir dari item pertama
                    let cost = res.data[0].cost;
                    $("#ongkir").val(cost);
                } else {
                    $("#ongkir").val("Tidak tersedia");
                }
            });
        }


        // Klik luar
        $(document).click(function(e) {
            if (!$(e.target).closest("#alamat_search").length) {
                $("#alamat_suggestions").hide();
            }
        });
    });
</script>

<style>
    #alamat_suggestions .list-group-item {
        cursor: pointer;
    }

    #alamat_suggestions .list-group-item:hover {
        background-color: #f0f0f0;
    }
</style>

<?= $this->endSection(); ?>