
        <main id="main" class="main flex-grow-1">
          <div class="row justify-content-center">
          <div class="col-sm-12 ">
          <div class="card"> 
            <div class="card-body ">
              <h5 class="card-title text-center mb-3">TAMBAH DATA KARYAWAN</h5>

              <!-- Vertical Form -->
              <form method="post" action="<?= base_url('karyawan/tambah') ?>" class="row g-3 " novalidate enctype="multipart/form-data">
                <div class="col-6">
                  <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" name="nama" class="form-control <?= form_error('nama') ? 'is-invalid' : '' ?>" id="nama" value="<?= set_value('nama') ?>" required>
                  <div class="invalid-feedback">
                    <?= form_error('nama'); ?>
                  </div>
                </div>
                <div class="col-6">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="text" name="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" id="email" value="<?= set_value('email') ?>" required>
                  <div class="invalid-feedback">
                    <?= form_error('email'); ?>
                  </div>
                </div>
                <div class="col-6">
                  <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                  <input type="date" name="tanggal_lahir" class="form-control <?= form_error('tanggal_lahir') ? 'is-invalid' : '' ?>" id="tanggal_lahir" value="<?= set_value('tanggal_lahir') ?>" required>
                  <div class="invalid-feedback">
                    <?= form_error('tanggal_lahir'); ?>
                  </div>
                </div>
                <div class="col-6">
                  <label for="kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                  <div class="form-check">
                    <input type="radio" id="laki-laki" name="kelamin" value="Laki-laki" class="form-check-input <?= form_error('kelamin') ? 'is-invalid' : '' ?>" <?= set_radio('kelamin', 'Laki-laki'); ?> required>
                    <label class="form-check-label" for="laki-laki">Laki-laki</label>
                  </div>
                  <div class="form-check">
                    <input type="radio" id="perempuan" name="kelamin" value="Perempuan" class="form-check-input <?= form_error('kelamin') ? 'is-invalid' : '' ?>" <?= set_radio('kelamin', 'Perempuan'); ?> required>
                    <label class="form-check-label" for="perempuan">Perempuan</label>
                  </div>
                  <div class="invalid-feedback">
                    <?= form_error('kelamin'); ?>
                  </div>
                </div>
                <!-- <div class="col-6">
                  <label for="kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                  <select id="kelamin" name="kelamin" class="form-select <?= form_error('kelamin') ? 'is-invalid' : '' ?>" required>
                    <option value="">Pilih...</option>
                    <option value="Laki-laki" <?= set_select('kelamin', 'Laki-laki'); ?>>Laki - laki</option>
                    <option value="Perempuan" <?= set_select('kelamin', 'Perempuan'); ?>>Perempuan</option>
                  </select>
                  <div class="invalid-feedback">
                    <?= form_error('kelamin'); ?>
                  </div>
                </div> -->
                <div class="col-6">
                  <label for="no_hp" class="form-label">No HP <span class="text-danger">*</span></label>
                  <input type="tel" name="no_hp" class="form-control <?= form_error('no_hp') ? 'is-invalid' : '' ?>" id="no_hp" value="<?= set_value('no_hp') ?>" required>
                  <div class="invalid-feedback">
                    <?= form_error('no_hp'); ?>
                  </div>
                </div>
                <div class="col-6">
                  <label for="departemen" class="form-label">Departemen <span class="text-danger">*</span></label>
                  <select id="departemen" name="departemen" class="form-select <?= form_error('departemen') ? 'is-invalid' : '' ?>" required>
                    <option value="">Pilih...</option>
                      <?php foreach ($departemen as $d) {?>
                        <option value="<?= $d->id ?>" <?= set_select('departemen', $d->id); ?>><?= $d->nama ?></option>
                      <?php } ?>
                  </select>
                  <div class="invalid-feedback">
                    <?= form_error('departemen'); ?>
                  </div>
                </div>
                <div class="col-6">
                  <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                  <select id="jabatan" name="jabatan" class="form-select <?= form_error('jabatan') ? 'is-invalid' : '' ?>" required>
                    <option value="">Pilih...</option>
                      <?php foreach ($jabatan as $j) {?>
                        <option value="<?= $j->id ?>" <?= set_select('jabatan', $j->id); ?>><?= $j->nama ?></option>
                      <?php } ?>
                  </select>
                  <div class="invalid-feedback">
                    <?= form_error('jabatan'); ?>
                  </div>
                </div>
                <div class="col-6">
                  <label for="tanggal_masuk" class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                  <input type="date" name="tanggal_masuk" class="form-control <?= form_error('tanggal_masuk') ? 'is-invalid' : '' ?>" id="tanggal_masuk" value="<?= set_value('tanggal_masuk') ?>" required >
                  <div class="invalid-feedback">
                    <?= form_error('tanggal_masuk'); ?>
                  </div>
                </div>
                <div class="col-6">
                  <label for="status" class="form-label">Status Kepegawaian <span class="text-danger">*</span></label>
                  <select id="status" name="status" class="form-select <?= form_error('status') ? 'is-invalid' : '' ?>" required>
                    <option value="">Pilih...</option>
                    <option value="Kontrak" <?= set_select('kelamin', 'Kontrak'); ?>>Kontrak</option>
                    <option value="Karyawan" <?= set_select('kelamin', 'Karyawan'); ?>>Karyawan</option>
                    <option value="Pensiun" <?= set_select('kelamin', 'Pensiun'); ?>>Pensiun</option>
                    <option value="Tidak Aktif" <?= set_select('kelamin', 'Tidak Aktif'); ?>>Tidak Aktif</option>
                  </select>
                  <div class="invalid-feedback">
                    <?= form_error('status'); ?>
                  </div>
                </div>
                <div class="col-6">
                  <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                  <select id="role" name="role" class="form-select <?= form_error('role') ? 'is-invalid' : '' ?>" required>
                    <option value="">Pilih...</option>
                      <?php foreach ($role as $r) {?>
                        <option value="<?= $r->id ?>" <?= set_select('role', $r->id); ?>><?= $r->nama ?></option>
                      <?php } ?>
                  </select>
                  <div class="invalid-feedback">
                    <?= form_error('role'); ?>
                  </div>
                </div>
                <div class="col-6">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-control <?= isset($error) ? 'is-invalid' : '' ?>" id="foto" value="<?= set_value('foto') ?>" id="foto">
                    <div class="invalid-feedback">
                        <?= form_error('foto'); ?>
                    </div>
                    <div class="invalid-feedback">
                      <?= $error; ?>
                    </div>
                </div>
                <div class="col-6">
                  <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                  <textarea class="form-control <?= form_error('alamat') ? 'is-invalid' : '' ?>" placeholder="Alamat" name="alamat" style="height: 100px;" required><?= set_value('alamat') ?></textarea>
                  <div class="invalid-feedback">
                    <?= form_error('alamat'); ?>
                  </div>
                </div>
                <div class="mt-3 d-flex justify-content-end">
                  <a href="<?= base_url('karyawan') ?>" class="btn btn-danger">Kembali</a>&nbsp;
                  <button type="reset" class="btn btn-secondary">Reset</button>&nbsp;
                  <button type="submit" class="btn btn-success">Simpan</i></button>
                </div>
              </form><!-- Vertical Form -->

            </div>
          </div>
          </div>
          </div>
        </main>