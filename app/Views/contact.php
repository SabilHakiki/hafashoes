<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>


<div class="pagetitle">
    <h1>Contact</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Pages</li>
            <li class="breadcrumb-item active">Contact</li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->

<section class="section contact">
    <div class="row gy-4">
        <div class="col-xl-6">
            <div class="row">
                <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Alamat</h3>
                        <p>Jl. Gribig Raya 59333<br /> Gebog, Kudus, Jawa Tengah</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-telephone"></i>
                        <h3>Nomor Kami</h3>
                        <p> <a href="https://wa.me/6281390950717" target="_blank">
                                +62 813-9095-0717
                            </a></p>
                        <p> </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-box card">
                        <i class="bi bi-envelope"></i>
                        <h3>Email Kami</h3>
                        <p>admin@gmail.com </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="col-lg">
                <div class="info-box card">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<style>
    #map {
        height: 400px;
        width: 100%;
    }
</style>
<script>
    // Inisialisasi peta dengan koordinat Anda
    var map = L.map('map').setView([-6.787361, 110.826417], 16);

    // Tambahkan tile layer (peta dasar)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Tambahkan marker di lokasi
    L.marker([-6.787361, 110.826417]).addTo(map)
        .bindPopup("Hafa Shoes")
        .openPopup();
</script>

<?= $this->endSection(); ?>