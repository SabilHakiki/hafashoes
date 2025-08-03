<?= $this->extend('template/wrap'); ?>
<?= $this->section('content'); ?>


<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="mainmenu">Home</a></li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section profile">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <img src="<?= !empty($user['foto']) ? base_url('gmbrprofil/' . $user['foto']) : base_url('assets/img/profile-img.png'); ?>" alt="Profile" class=" image-fluid">
                    <h2><?= ucwords($user['nama']); ?></h2>
                    <span><?= ucwords($user['role']); ?></span>
                </div>
            </div>
        </div>


        <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit</button>
                        </li>
                        <?php if (isset($user['role']) && $user['role'] === 'admin'): ?>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-role">Data Kurir</button>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title">Profile Detail</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Nama</div>
                                <div class="col-lg-9 col-md-8">
                                    <?= $user['nama']; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Alamat</div>
                                <div class="col-lg-9 col-md-8">
                                    <?= $user['destination_label']; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">
                                    <?= $user['email']; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Nomor Handphone</div>
                                <div class="col-lg-9 col-md-8">
                                    <?= $user['nohp']; ?>
                                </div>
                            </div>
                        </div>



                        <!-- EDIT -->
                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                            <form action="<?= base_url() . 'edit'; ?>" method="post" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="foto" class="col-md-4 col-lg-3 col-form-label">Foto Profil</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input type="file" name="foto" class="form-control" id="foto" accept="image/*">
                                    </div>
                                </div>
                                <!-- Tempat preview gambar -->
                                <div class="row mb-3">
                                    <div class="col-md-8 col-lg-9">
                                        <div class="img-container">
                                            <img id="image-preview" src="#" alt="Preview Foto" style="display: none; max-width: 100%;">
                                        </div>
                                    </div>
                                </div>
                                <!-- Input tersembunyi untuk menyimpan data gambar hasil crop -->
                                <input type="hidden" name="croppedImage" id="croppedImage">

                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="nama" type="text" class="form-control" id="fullName" value="<?= $user['nama']; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="alamat_suggestions" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input type="text" id="alamat_search" class="form-control" placeholder="Ketik nama kota / kecamatan..." autocomplete="off" value="<?= esc($user['destination_label']) ?>" required>
                                        <div id="alamat_suggestions" class="list-group mt-1" style="position: absolute; z-index: 1000;"></div>
                                    </div>
                                </div>
                                <input type="hidden" name="destination_id" id="destination_id" value="<?= esc($user['destination_id']) ?>">
                                <input type="hidden" name="destination_label" id="destination_label" value="<?= esc($user['destination_label']) ?>">

                                <div class="row mb-3">
                                    <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Detail Alamat</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="alamat" type="text" class="form-control" id="alamat" value="<?= $user['alamat']; ?>" required>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="text" class="form-control" id="email" value="<?= $user['email']; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Nohp" class="col-md-4 col-lg-3 col-form-label">Nomor Handphone</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="nohp" type="text" class="form-control" id="nohp" value="<?= $user['nohp']; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="oldPassword" class="col-md-4 col-lg-3 col-form-label">Password Lama</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="oldpassword" type="password" class="form-control" id="oldPassword" value="<?= $user['password']; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>



                        <!-- TAMBAH KURIR -->
                        <div class="tab-pane fade profile-role pt-3" id="profile-role">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#pilihKurirModal">
                                Tambah Kurir
                            </button>

                            <!-- Tampilkan pesan sukses atau error -->
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert" id="flash-message-success">
                                    <?= session()->getFlashdata('success'); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php elseif (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="flash-message-error">
                                    <?= session()->getFlashdata('error'); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <script>
                                setTimeout(function() {
                                    let successAlert = document.getElementById('flash-message-success');
                                    let errorAlert = document.getElementById('flash-message-error');

                                    if (successAlert) {
                                        successAlert.classList.remove('show');
                                        setTimeout(() => {
                                            successAlert.remove();
                                        }, 150); // Waktu tambahan agar efek fade out berjalan mulus
                                    }

                                    if (errorAlert) {
                                        errorAlert.classList.remove('show');
                                        setTimeout(() => {
                                            errorAlert.remove();
                                        }, 150);
                                    }
                                }, 3000); // Tutup pesan setelah 3 detik
                            </script>
                            <!-- --------------- -->

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Kurir</th>
                                        <th>Email</th>
                                        <th>Nomor Handphone</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kurir as $ku): ?>
                                        <tr>
                                            <td><?= $ku['id']; ?></td>
                                            <td><?= esc($ku['nama']); ?></td>
                                            <td><?= esc($ku['email']); ?></td>
                                            <td><?= esc($ku['nohp']); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary bi bi-pencil-square" data-bs-toggle="modal" data-bs-target="#editkurir<?= $ku['id']; ?>"></button>
                                        </tr>
                                        <form action="<?= base_url() . 'updateRole'; ?>" method="post">
                                            <div class="modal fade" id="editkurir<?= $ku['id']; ?>" tabindex="-1" aria-labelledby="modal2Label">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal2Label">Data Kurir</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-3">
                                                                <label for="ekurir" class="col-md-4 col-lg-3 col-form-label">Nama Kurir</label>
                                                                <div class="col-md-8 col-lg-9">
                                                                    <input name="id_user" type="hidden" class="form-control" value="<?= $ku['id']; ?>">
                                                                    <label class="col-md-4 col-lg-3 col-form-label"> <?= $ku['nama']; ?></label>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label for="role" class="col-md-4 col-lg-3 col-form-label">role</label>
                                                                <div class="col-md-8 col-lg-9">
                                                                    <select name="role" class="form-select" id="role">
                                                                        <option value="Kurir" <?= $ku['role'] === 'Kurir' ? 'selected' : '' ?>>Kurir</option>
                                                                        <option value="Admin" <?= $ku['role'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
                                                                        <option value="Customer" <?= $ku['role'] === 'Customer' ? 'selected' : '' ?>>Customer</option>
                                                                    </select>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="modal fade" id="pilihKurirModal" tabindex="-1" aria-labelledby="pilihKurirLabel">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <form action="<?= base_url('') . 'updateRole'; ?>" method="post">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="pilihKurirLabel">Pilih Kurir</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="id_user" class="form-label">Pilih</label>
                                                    <select name="id_user" id="id_user" class="form-select" required>
                                                        <option value="" disabled selected>Pilih Akun</option>
                                                        <?php foreach ($customers as $customer): ?>
                                                            <option value="<?= $customer['id']; ?>">
                                                                <?= esc($customer['nama']); ?> - <?= esc($customer['email']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <input name="role" type="hidden" class="form-control" id="role" value="kurir">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // CROPPER
        let cropper;
        const inputFile = document.getElementById('foto');
        const imagePreview = document.getElementById('image-preview');
        const croppedImageInput = document.getElementById('croppedImage');

        inputFile.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';

                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(imagePreview, {
                        aspectRatio: 1,
                        viewMode: 2,
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        // Saat submit, crop dulu gambarnya
        document.querySelector('form').addEventListener('submit', function(event) {
            if (cropper) {
                event.preventDefault();
                cropper.getCroppedCanvas().toBlob((blob) => {
                    const reader = new FileReader();
                    reader.onloadend = () => {
                        croppedImageInput.value = reader.result;
                        this.submit();
                    };
                    reader.readAsDataURL(blob);
                });
            }
        });

        // AUTOCOMPLETE ALAMAT
        $(document).ready(function() {
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

            $("#alamat_suggestions").on("click", ".list-group-item", function(e) {
                e.preventDefault();
                const label = $(this).text();
                const id = $(this).data("id");
                $("#alamat_search").val(label);
                $("#destination_id").val(id);
                $("#destination_label").val(label);
                $("#alamat_suggestions").hide();
            });

            $(document).click(function(e) {
                if (!$(e.target).closest("#alamat_search").length) {
                    $("#alamat_suggestions").hide();
                }
            });
        });
    </script>

    <?= $this->endSection(); ?>