  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Profil</li>
          </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <?php if ($this->session->flashdata('berhasil') ): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('berhasil') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('gagal') ): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('gagal') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <div class="col-xl-6">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <div class="mb-3 d-flex justify-content-center">
                    <img class="mb-2" src="<?= base_url(); ?>assets/uploads/<?= $karyawan['foto']; ?>" width="50%" height="50%">
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nama Lengkap</div>
                    <div class="col-lg-9 col-md-8"><?= $karyawan['nama_lengkap'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">NIK</div>
                    <div class="col-lg-9 col-md-8"><?= $karyawan['nik'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?= $karyawan['email'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Tanggal Lahir</div>
                    <div class="col-lg-9 col-md-8"><?= date('F d, Y', strtotime($karyawan['tanggal_lahir'])) ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Jenis Kelamin</div>
                    <div class="col-lg-9 col-md-8"><?= $karyawan['jenis_kelamin'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">No Handphone</div>
                    <div class="col-lg-9 col-md-8"><?= $karyawan['no_telepon'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Departemen</div>
                    <div class="col-lg-9 col-md-8"><?= $karyawan['nd'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Jabatan</div>
                    <div class="col-lg-9 col-md-8"><?= $karyawan['nj'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Tanggal Masuk</div>
                    <div class="col-lg-9 col-md-8"><?= date('F d, Y', strtotime($karyawan['tanggal_masuk'])) ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Batas Cuti</div>
                    <div class="col-lg-9 col-md-8"><?= $karyawan['batas_cuti'] ?> Hari</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Status Kepegawaian</div>
                    <div class="col-lg-9 col-md-8"><?= $karyawan['status_kepegawaian'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                    <div class="col-lg-9 col-md-8"><?= $karyawan['alamat'] ?></div>
                  </div>

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
        <div class="col-xl-6">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column">

                <h5 class="card-title">Ubah Password</h5>
              <!-- Change Password Form -->
                  <form action="<?= base_url('profil/ubahpassword') ?>" method="post" novalidate>

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password Saat ini</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" id="currentPassword" value="<?= set_value('password') ?>">
                        <div class="invalid-feedback">
                          <?= form_error('password'); ?>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="password" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="passwordnew" type="password" class="form-control <?= form_error('passwordnew') ? 'is-invalid' : '' ?>" id="password" placeholder="min 8 character">
                        <div class="invalid-feedback">
                          <?= form_error('passwordnew'); ?>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="konfirmasi" class="col-md-4 col-lg-3 col-form-label">Konfirmasi  Password Baru</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="konfirmasi" type="password" class="form-control <?= form_error('konfirmasi') ? 'is-invalid' : '' ?>" id="konfirmasi">
                        <div class="invalid-feedback">
                          <?= form_error('konfirmasi'); ?>
                        </div>
                      </div>
                    </div>

                    <div class="text-end">
                      <button type="submit" class="btn btn-primary">Ubah Password</button>
                    </div>
                  </form><!-- End Change Password Form -->
            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->