<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda E-Commerce</title>

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url('/style2.css') ?>">
</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="" />
                <span class="d-none d-lg-block">HafaShoes</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword" />
                <button type="submit" title="Search">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
        <!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle" href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>
                <!-- End Search Icon-->

                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">4</span> </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>
                    </ul>
                    <!-- End Notification Dropdown Items -->
                </li>
                <!-- End Notification Nav -->

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span> </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>Kevin Anderson</h6>
                            <span>Web Designer</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                    <!-- End Profile Dropdown Items -->
                </li>
                <!-- End Profile Nav -->
            </ul>
        </nav>
        <!-- End Icons Navigation -->
    </header>

    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="mainmenu">
                    <i class="bi bi-grid"></i>
                    <span>Dasboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#form-nav" data-bs-toggle="collapse" href="">
                    <i class="bi bi-journal-text"></i> <span>Form</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul class="nav-content collapse" id="form-nav" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="welcome">
                            <i class="bi bi-circle"></i><span>Form 1</span>
                        </a>
                    </li>
                </ul>

                <ul class="nav-content collapse" id="form-nav" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="welcome">
                            <i class="bi bi-circle"></i><span>Form 2</span>
                        </a>
                    </li>
                </ul>

            </li>

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="profile">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-contact.html">
                    <i class="bi bi-envelope"></i>
                    <span>Contact</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Login</span>
                </a>
            </li>
        </ul>
    </aside>

    <main id="main" class="main">

        <div class="row">
            <div class="col">
                <!-- Card with an image on top -->
                <div class="card">
                    <a href="youtube.com">
                        <img src="img/login.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Sepatu nike A1</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <a href="youtube.com">
                        <img src="assets/img/card.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card with an image on top</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <a href="youtube.com">
                        <img src="assets/img/card.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card with an image on top</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <a href="youtube.com">
                        <img src="assets/img/card.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card with an image on top</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <!-- Card with an image on top -->
                <div class="card">
                    <a href="youtube.com">
                        <img src="assets/img/card.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card with an image on top</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <a href="youtube.com">
                        <img src="assets/img/card.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card with an image on top</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <a href="youtube.com">
                        <img src="assets/img/card.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card with an image on top</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <a href="youtube.com">
                        <img src="assets/img/card.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card with an image on top</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <h5 class="card-title">Reports <span>/Today</span></h5>

            <!-- Line Chart -->
            <div id="reportsChart"></div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(
                        document.querySelector("#reportsChart"), {
                            series: [{
                                    name: "Sales",
                                    data: [31, 40, 28, 51, 42, 82, 56],
                                },
                                {
                                    name: "Revenue",
                                    data: [11, 32, 45, 32, 34, 52, 41],
                                },
                                {
                                    name: "Customers",
                                    data: [15, 11, 32, 18, 9, 24, 11],
                                },
                            ],
                            chart: {
                                height: 350,
                                type: "area",
                                toolbar: {
                                    show: false,
                                },
                            },
                            markers: {
                                size: 4,
                            },
                            colors: ["#4154f1", "#2eca6a", "#ff771d"],
                            fill: {
                                type: "gradient",
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.3,
                                    opacityTo: 0.4,
                                    stops: [0, 90, 100],
                                },
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                curve: "smooth",
                                width: 2,
                            },
                            xaxis: {
                                type: "datetime",
                                categories: [
                                    "2018-09-19T00:00:00.000Z",
                                    "2018-09-19T01:30:00.000Z",
                                    "2018-09-19T02:30:00.000Z",
                                    "2018-09-19T03:30:00.000Z",
                                    "2018-09-19T04:30:00.000Z",
                                    "2018-09-19T05:30:00.000Z",
                                    "2018-09-19T06:30:00.000Z",
                                ],
                            },
                            tooltip: {
                                x: {
                                    format: "dd/MM/yy HH:mm",
                                },
                            },
                        }
                    ).render();
                });
            </script>
            <!-- End Line Chart -->
        </div>

    </main>


    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>