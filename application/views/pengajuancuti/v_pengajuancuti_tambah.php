<?php if ($this->session->userdata('nr') == 'Karyawan' ) {?>
<main id="main" class="main flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-sm-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Pengajuan Cuti/Sakit</h5>
                    <?php if ($this->session->flashdata('gagal') ): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <?= $this->session->flashdata('gagal') ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="<?= base_url('pengajuancuti/tambah') ?>" class="row g-3 " novalidate enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $this->session->userdata('id_pegawai'); ?>">
                        <div class="col-12">
                            <label for="jeniscuti" class="form-label">Jenis Cuti <span class="text-danger">*</span></label>
                            <select id="jeniscuti" name="jeniscuti" class="form-select <?= form_error('jeniscuti') ? 'is-invalid' : '' ?>" required>
                                <option value="">Pilih...</option>
                                <option value="Sakit" <?= set_select('jeniscuti', 'Sakit'); ?>>Sakit</option>
                                <option value="Cuti" <?= set_select('jeniscuti', 'Cuti'); ?>>Cuti</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= form_error('jeniscuti'); ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" class="form-control <?= form_error('tanggal_mulai') ? 'is-invalid' : '' ?>" id="tanggal_mulai" value="<?= set_value('tanggal_mulai') ?>" required>
                            <div class="invalid-feedback">
                                <?= form_error('tanggal_mulai'); ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_selesai" class="form-control <?= form_error('tanggal_selesai') ? 'is-invalid' : '' ?>" id="tanggal_selesai" value="<?= set_value('tanggal_selesai') ?>" required>
                            <div class="invalid-feedback">
                                <?= form_error('tanggal_selesai'); ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="bukti" class="form-label">Bukti (Gambar/pdf) <span class="text-danger" id="bukti-required">*</span></label>
                            <input type="file" name="bukti" class="form-control <?= form_error('bukti') ? 'is-invalid' : '' ?>" id="bukti" value="<?= set_value('bukti') ?>" id="bukti">
                            <div class="invalid-feedback">
                                <?= form_error('bukti'); ?>
                            </div>
                            <?php if(isset($error)): ?>
                                <div class="text-danger"><?= $error; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-12">
                          <label for="deskripsi" class="form-label">Deskripsi</label>
                          <textarea class="form-control <?= form_error('deskripsi') ? 'is-invalid' : '' ?>" placeholder="deskripsi" name="deskripsi" style="height: 100px;" required><?= set_value('deskripsi') ?></textarea>
                          <div class="invalid-feedback">
                            <?= form_error('deskripsi'); ?>
                          </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-end">
                            <a href="<?= base_url('pengajuancuti') ?>" class="btn btn-danger">Kembali</a>&nbsp;
                            <button type="reset" class="btn btn-secondary">Reset</button>&nbsp;
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</main>
<script>
    document.getElementById('jeniscuti').addEventListener('change', function() {
        var selectedValue = this.value;
        var buktiRequired = document.getElementById('bukti-required');
        if (selectedValue === 'Cuti') {
            buktiRequired.style.display = 'none';
        } else {
            buktiRequired.style.display = 'inline';
        }
    });
</script>

  <?php } ?>
  <?php if ($this->session->userdata('nr') != 'Karyawan' ) {?>
<main id="main" class="main flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-sm-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Pengajuan Cuti/Sakit</h5>
                    <?php if ($this->session->flashdata('gagal') ): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <?= $this->session->flashdata('gagal') ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="<?= base_url('pengajuancuti/hrd_tambah') ?>" class="row g-3 " novalidate enctype="multipart/form-data">
                        <!-- <div class="col-12">
                            <select id="karyawan" name="id_karyawan[]" class="form-select <?= form_error('id_karyawan') ? 'is-invalid' : '' ?>" multiple required>
                                <option value="">Pilih Karyawan...</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= form_error('id_karyawan'); ?>
                            </div>
                        </div> -->
                        <select class="js-example-basic-multiple" name="id_karyawan[]" multiple="multiple">
                            <option value="id_karyawan[]"></option>
                        </select>
                        <div class="col-12">
                            <label for="jeniscuti" class="form-label">Jenis Cuti <span class="text-danger">*</span></label>
                            <input type="text" name="jeniscuti" class="form-control <?= form_error('jeniscuti') ? 'is-invalid' : '' ?>" id="jeniscuti" value="Cuti" readonly>
                            <div class="invalid-feedback">
                                <?= form_error('jeniscuti'); ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" class="form-control <?= form_error('tanggal_mulai') ? 'is-invalid' : '' ?>" id="tanggal_mulai" value="<?= set_value('tanggal_mulai') ?>" required>
                            <div class="invalid-feedback">
                                <?= form_error('tanggal_mulai'); ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_selesai" class="form-control <?= form_error('tanggal_selesai') ? 'is-invalid' : '' ?>" id="tanggal_selesai" value="<?= set_value('tanggal_selesai') ?>" required>
                            <div class="invalid-feedback">
                                <?= form_error('tanggal_selesai'); ?>
                            </div>
                        </div>
                        <div class="col-12">
                          <label for="deskripsi" class="form-label">Deskripsi</label>
                          <textarea class="form-control <?= form_error('deskripsi') ? 'is-invalid' : '' ?>" placeholder="deskripsi" name="deskripsi" style="height: 100px;" required><?= set_value('deskripsi') ?></textarea>
                          <div class="invalid-feedback">
                            <?= form_error('deskripsi'); ?>
                          </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-end">
                            <a href="<?= base_url('pengajuancuti') ?>" class="btn btn-danger">Kembali</a>&nbsp;
                            <button type="reset" class="btn btn-secondary">Reset</button>&nbsp;
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({
            placeholder: 'Pilih Karyawan...',
            ajax: {
                url: '<?= base_url("pengajuancuti/get_karyawan") ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // Mencari berdasarkan input pengguna
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.nama_lengkap
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });
    });
</script>
<?php } ?>