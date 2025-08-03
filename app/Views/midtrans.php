<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>



<div class="pagetitle">
    <h1>Pembayaran</h1>
    <nav>

    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Proses Pembayaran</h3>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-sQIOvET0PN0icODCdQadnjfn"></script>
<script type="text/javascript">
    var snaptoken = '<?= $snaptoken ?>';

    snap.pay(snaptoken, {
        onSuccess: function(result) {
            console.log('Pembayaran berhasil:', result);
            // Panggil program clear untuk membersihkan data keranjang
            fetch('<?= base_url('clear') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        order_id: result.order_id
                    }),
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Keranjang berhasil dibersihkan.');
                    } else {
                        console.error('Gagal membersihkan keranjang.');
                    }
                    // Redirect ke halaman transaksi
                    window.location.href = '<?= base_url('transaksi') ?>';
                })
                .catch(error => {
                    console.error('Terjadi kesalahan saat membersihkan keranjang:', error);
                    window.location.href = '<?= base_url('transaksi') ?>';
                });
        },
        onPending: function(result) {
            console.log('Menunggu pembayaran:', result);
            window.location.href = '<?= base_url('transaksi') ?>';
        },
        onClose: function() {
            console.log("Transaksi dibatalkan.");
            window.location.href = '<?= base_url('transaksi') ?>';
        }
    });
</script>


<?= $this->endSection(); ?>