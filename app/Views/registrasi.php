<!DOCTYPE html>
<html lang="en">


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - HafaShoes</title>

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
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Buat Akun HafaShoes</h5>
                    <p class="text-center small">Masukkan detail pribadi Anda untuk membuat akun</p>
                  </div>

                  <form action="<?= base_url() . 'register/user'; ?>" method="post" class="row g-3 needs-validation" novalidate>
                    <div class="col-12">
                      <label for="yourName" class="form-label">Username</label>
                      <input type="text" name="nama" class="form-control <?= isset($valid['nama']) ? 'is-invalid' : ''; ?>" id="yourName" value="<?= old('nama'); ?>" required>
                      <div class="invalid-feedback"> <?= isset($valid['nama']) ? $valid['nama'] : '' ?></div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control <?= isset($valid['email']) ? 'is-invalid' : ''; ?>" id="yourEmail" value="<?= old('email'); ?>" required>
                      <div class="invalid-feedback"> <?= isset($valid['email']) ? $valid['email'] : '' ?></div>
                    </div>

                    <div class="col-12">
                      <label for="yournohp" class="form-label">No Handphone</label>
                      <div class="input-group has-validation">
                        <input type="text" name="nohp" class="form-control <?= isset($valid['nohp']) ? 'is-invalid' : ''; ?>" id="yournohp" value="<?= old('nohp'); ?>" required>
                        <div class="invalid-feedback"> <?= isset($valid['nohp']) ? $valid['nohp'] : '' ?> </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="pass1" class="form-control <?= isset($valid['pass1']) ? 'is-invalid' : ''; ?>" id="yourPassword" required>
                      <div class="invalid-feedback"><?= isset($valid['pass1']) ? $valid['pass1'] : '' ?></div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword2" class="form-label">Konfirmasi Password</label>
                      <input type="password" name="pass2" class="form-control <?= isset($valid['pass2']) ? 'is-invalid' : ''; ?>" id="yourPassword2" required>
                      <div class="invalid-feedback"><?= isset($valid['pass2']) ? $valid['pass2'] : '' ?></div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="<?= base_url() ?> ">Log in</a></p>
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

  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>