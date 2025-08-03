<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Login - HafaShoes</title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />


  <link href="<?= base_url('/assets/img/Logo2.png'); ?>" rel="icon" />
  <link href="<?= base_url('/assets/img/Logo2.png'); ?>" rel="apple-touch-icon" />
  <link href="https://fonts.gstatic.com" rel="preconnect" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" />

  <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/vendor/bootstrap-icons/bootstrap-icons.css" />
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet" />
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />


  <link href="assets/css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url('/style2.css') ?>">

</head>

<body>
  <main>
    <div class="container">
      <section
        class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Toko HafaShoes</h5>
                    <p class="text-center small">Masukan Email & password Anda Untuk login</p>
                  </div>

                  <form action="<?= base_url('login'); ?>" method="post" class="row g-3 needs-validation" novalidate>
                    <?= csrf_field() ?>
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation ">
                        <input
                          type="text"
                          name="user"
                          class="form-control <?= (session()->has('error')) ? 'is-invalid' : ''; ?>"
                          id="yourUsername"
                          value="<?= old('user'); ?>"
                          required autofocus />
                        <div class="invalid-feedback">
                          <?= session()->get('error'); ?>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input
                        type="password"
                        name="pass"
                        class="form-control <?= (session()->has('error1')) ? 'is-invalid' : ''; ?>"
                        id="yourPassword"
                        required />
                      <div class="invalid-feedback">
                        <?= session()->get('error1'); ?>
                      </div>
                    </div>


                    <div class="col-12">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          name="remember"
                          value="true"
                          id="rememberMe" />
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">
                        Login
                      </button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">
                        Belum punya akun?
                        <a href="<?= base_url() ?>registrasi">Buat akun</a>
                      </p>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <a
    href="#"
    class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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