<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HafaShoes E-Commerce</title>

    <!-- Favicons -->
    <link href="<?= base_url('/assets/img/Logo2.png') ?>" rel="icon" />
    <link href="<?= base_url('/assets/img/Logo2.png') ?>" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="<?= base_url('/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('/assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('/assets/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('/assets/vendor/quill/quill.snow.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('/assets/vendor/quill/quill.bubble.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('/assets/vendor/remixicon/remixicon.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('/assets/vendor/simple-datatables/style.css') ?>" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Template Main CSS File -->
    <link href="<?= base_url('/style.css') ?>" rel="stylesheet" />

    <!-- Midtrans -->
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-hCVwpeiZXPpOwiJh"></script>


    <!-- CROPPER.JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <!-- Vendor JS Files -->
    <script src="<?= base_url('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</head>


<body>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="<?= base_url('mainmenu'); ?>" class="logo d-flex align-items-center">
                <img src="<?= base_url('/assets/img/Logo2.png'); ?>" alt="" />
                <span class="d-none d-lg-block">HafaShoes</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item d-block d-lg-none">
                </li>
                <!-- End Search Icon -->

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile dropdown-toggle d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="<?= !empty($user['foto']) ? base_url('gmbrprofil/' . $user['foto']) : base_url('assets/img/profile-img.png'); ?>" alt="Profile" class="rounded-circle">
                        <span class="ps-2"><?= $user ? ucwords($user['nama']) : 'Pengunjung'; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <?php if ($user): ?>
                                <h6><?= ucwords($user['nama']); ?></h6>
                                <span><?= ucwords($user['role']); ?></span>
                            <?php else: ?>
                                <a href="/login">Login</a>
                            <?php endif; ?>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?= base_url('profile'); ?>">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item d-flex align-items-center" href="<?= base_url('logout'); ?>">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- End Icons Navigation -->
    </header>

    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'mainmenu' ? '' : 'collapsed'; ?>" href="<?= base_url('mainmenu'); ?>">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php if (isset($user['role']) && $user['role'] === 'admin'): ?>

                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'produk' ? '' : 'collapsed'; ?>" href="<?= base_url('produk'); ?>">
                        <i class="bi bi-box-seam"></i>
                        <span>Produk</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'kategori' ? '' : 'collapsed'; ?>" href="<?= base_url('kategori'); ?>">
                        <i class="bi bi-box"></i>
                        <span>Kategori</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'keranjang' ? '' : 'collapsed'; ?>" href="<?= base_url('keranjang'); ?>">
                    <i class="ri-shopping-cart-2-line"></i>
                    <span>Keranjang</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'transaksi' ? '' : 'collapsed'; ?>" href="<?= base_url('transaksi'); ?>">
                    <i class="bi bi-file-earmark-code"></i>
                    <span>Transaksi</span>
                </a>
            </li>

            <?php if (isset($user['role']) && $user['role'] === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'laporan' ? '' : 'collapsed'; ?>" href="<?= base_url('laporan'); ?>">
                        <i class="ri-book-3-line"></i>
                        <span>Laporan Penjualan</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (isset($user['role']) && in_array($user['role'], ['admin', 'kurir'])): ?>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'kurir' ? '' : 'collapsed'; ?>" href="<?= base_url('kurir'); ?>">
                        <i class="bi bi-truck"></i>
                        <span>Kurir</span>
                    </a>
                </li>
            <?php endif ?>

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'profile' ? '' : 'collapsed'; ?>" href="<?= base_url('profile'); ?>">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('contact'); ?>">
                    <i class="bi bi-envelope"></i>
                    <span>Contact</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('logout'); ?>">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </aside>
    <main id="main" class="main">