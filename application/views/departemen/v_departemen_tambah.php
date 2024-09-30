
        <main id="main" class="main flex-grow-1">
          <div class="row justify-content-center">
          <div class="col-sm-8">
          <div class="card"> 
            <div class="card-body ">
              <h5 class="card-title text-center mb-3">TAMBAH DATA DEPARTEMEN</h5>

              <!-- Vertical Form -->
              <form method="post" action="<?= base_url('departemen/tambah') ?>" class="row g-3 " novalidate enctype="multipart/form-data">
                <div class="col-12">
                  <label for="nama" class="form-label">Nama Departemen <span class="text-danger">*</span></label>
                  <input type="text" name="nama" class="form-control <?= form_error('nama') ? 'is-invalid' : '' ?>" id="nama" value="<?= set_value('nama') ?>" required>
                  <div class="invalid-feedback">
                    <?= form_error('nama'); ?>
                  </div>
                </div>
                <div class="col-12">
                  <label for="alamat" class="form-label">Deskripsi</label>
                  <textarea class="form-control <?= form_error('deskripsi') ? 'is-invalid' : '' ?>" placeholder="deskripsi" name="deskripsi" style="height: 100px;"><?= set_value('deskripsi') ?></textarea>
                  <div class="invalid-feedback">
                    <?= form_error('deskripsi'); ?>
                  </div>
                </div>
                <div class="mt-3 d-flex justify-content-end">
                  <a href="<?= base_url('departemen') ?>" class="btn btn-danger">Kembali</a>&nbsp;
                  <button type="reset" class="btn btn-secondary">Reset</button>&nbsp;
                  <button type="submit" class="btn btn-success">Simpan</i></button>
                </div>
              </form><!-- Vertical Form -->

            </div>
          </div>
          </div>
          </div>
        </main>