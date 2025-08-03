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
                    <div class="d-flex justify-content-end">
                        <h5 id="ongkir_label">Ongkir: -</h5>
                    </div>
                    <div class="d-flex justify-content-end">
                        <h5 id="grand_total">Grand Total: IDR <?= number_format($total, 0, ',', '.') ?></h5>
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
                        <div class="mb-3">
                            <label>Nomor Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="<?= esc($user['nohp']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Alamat Tujuan <small class="text-muted">(Pilih kecamatan/kota)</small></label>
                            <input type="text" id="alamat_search" name="destination_label" class="form-control" placeholder="Ketik nama kota / kecamatan / desa..." autocomplete="off" value="<?= esc($user['destination_label'] ?? '') ?>" required>
                            <div id="alamat_suggestions" class="list-group mt-1" style="position: absolute; z-index: 1000;"></div>
                            <input type="hidden" id="destination_id" name="destination_id" value="<?= esc($user['destination_id'] ?? '') ?>">
                            <!-- <input type="hidden" id="destination_label" name="destination_label" value="<?= esc($user['destination_label'] ?? '') ?>"> -->
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
                                <option value="toko">Pengiriman Toko (Mobil Box)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Ongkir / Layanan Pengiriman</label>
                            <select id="ongkir" name="ongkir" class="form-select" required>
                                <option value="">-- Pilih layanan pengiriman --</option>
                            </select>
                        </div>
                        <div class="mb-3" id="metode-pembayaran-container">
                        </div>

                        <input type="hidden" id="totalItem" value="<?= $totalItem ?>">
                        <input type="hidden" id="ongkir_service" name="ongkir_service">
                        <input type="hidden" name="email" class="form-control" value="<?= esc($user['email']) ?>" required>

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
            $("#destination_label").val(label);
            $("#alamat_suggestions").hide();
            if ($("#kurir").val()) {
                hitungOngkir();
            }
        });

        // Pilih kurir
        $("#kurir").change(function() {
            let courier = $(this).val();
            const metodeContainer = $("#metode-pembayaran-container");

            if (courier === "toko") {
                let allowedAreas = ["Kudus", "Demak", "Semarang"];
                let destinationLabel = $("#alamat_search").val();

                let areaMatched = allowedAreas.some(area => destinationLabel.toLowerCase().includes(area.toLowerCase()));
                if (areaMatched) {
                    // Tampilkan radio button
                    metodeContainer.html(`
                <label>Metode Pembayaran</label><br>
                <label><input type="radio" name="metode_pembayaran" value="VA" checked> Virtual Account</label><br>
                <label><input type="radio" name="metode_pembayaran" value="COD"> Cash on Delivery (COD)</label>
            `);
                    // Set ongkir Rp0
                    $("#ongkir").html('<option value="0" data-service="Pengiriman Toko">Gratis Pengiriman (Mobil Box)</option>').prop("disabled", false);
                    $("#ongkir").val(0).trigger("change");
                } else {
                    alert("Wilayah tidak terjangkau pengiriman toko.");
                    $("#ongkir").html('<option value="">-- Pilih layanan pengiriman --</option>').prop("disabled", true);
                    metodeContainer.html(""); // Bersihkan metode
                }
            } else if (courier) {
                metodeContainer.html(``);
                metodeContainer.append(`<input type="hidden" name="metode_pembayaran" value="VA">`);

                if ($("#destination_id").val()) {
                    hitungOngkir();
                }
            } else {
                metodeContainer.html("");
            }
        });



        function hitungOngkir() {
            let origin = "65364"; // ID Lokasi Toko
            let destination = $("#destination_id").val();
            let totalItem = parseInt($("#totalItem").val());
            let weight = totalItem * 500;
            let courier = $("#kurir").val();

            $.post("<?= base_url('getOngkir') ?>", {
                origin: origin,
                destination: destination,
                weight: weight,
                courier: courier
            }, function(res) {
                console.log(res);

                if (res.status === 'success' && Array.isArray(res.data) && res.data.length > 0) {
                    let html = '<option value="">-- Pilih layanan pengiriman --</option>';
                    let minCost = null;
                    let minService = '';

                    res.data.forEach(item => {
                        let label = `${item.service} (${item.name}) - Rp${item.cost.toLocaleString("id-ID")}`;
                        html += `<option value="${item.cost}" data-service="${item.service}">${label}</option>`;

                        if (minCost === null || item.cost < minCost) {
                            minCost = item.cost;
                            minService = item.service;
                        }
                    });

                    $("#ongkir").html(html).prop("disabled", false);

                    if (minCost !== null) {
                        // Pilih otomatis termurah dan trigger change
                        $("#ongkir").val(minCost).trigger("change");
                    }
                } else {
                    $("#ongkir").html('<option value="">Tidak tersedia</option>').prop("disabled", true);
                    $("#ongkir_label").hide();
                    $("#grand_total").hide();
                    $("#ongkir_service").val('');
                    $("#checkout-button").prop("disabled", true);
                }
            });
        }

        // Saat user mengganti layanan pengiriman
        $("#ongkir").change(function() {
            const selectedOption = $(this).find("option:selected");
            const cost = parseInt(selectedOption.val());
            const service = selectedOption.data("service");

            if (!isNaN(cost)) {
                $("#ongkir_service").val(service);
                $("#ongkir_label").text("Ongkir: IDR " + cost.toLocaleString('id-ID')).show();

                const subtotal = <?= $total ?>;
                const grandTotal = subtotal + cost;
                $("#grand_total").text("Grand Total: IDR " + grandTotal.toLocaleString('id-ID')).show();
                $("#checkout-button").prop("disabled", false);
            } else {
                $("#ongkir_service").val('');
                $("#ongkir_label").hide();
                $("#grand_total").hide();
                $("#checkout-button").prop("disabled", true);
            }
        });

        // Klik luar autocomplete
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

    #ongkir_label,
    #grand_total {
        font-style: bold;
        display: none;
    }

    #metode-pembayaran-container label {
        display: block;
        margin-bottom: 5px;
    }
</style>

<?= $this->endSection(); ?>