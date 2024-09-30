
<main id="main" class="main flex-grow-1">
  <div class="row justify-content-center">
    <div class="col-sm-10">
      <div class="card"> 
        <div class="card-body">
          <h5 class="card-title text-center mb-3">KIRIM EMAIL</h5>

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
          <!-- Vertical Form -->
          <form method="post" action="<?= base_url('Kirim_email/kirim') ?>" class="row g-3 " novalidate enctype="multipart/form-data">

            <div class="col-12">
              <label class="form-label">Kepada <span class="text-danger">*</span></label>
              <input type="text" name="to" class="form-control <?= form_error('to') ? 'is-invalid' : '' ?>" id="to" placeholder="Masukkan email penerima" value="<?= set_value('to') ?>">
              <div class="invalid-feedback">
                <?= form_error('to'); ?>
              </div>
              <?php if (!form_error('to')){ ?>
                <small class="text-muted">Pisahkan beberapa email dengan koma.</small>
              <?php } ?>
            </div>
            <div class="col-12">
                <label class="form-label">CC</label>
                <input type="text" name="cc" class="form-control <?= form_error('cc') ? 'is-invalid' : '' ?>" id="cc" placeholder="Masukkan email CC" value="<?= set_value('cc') ?>">
                <div class="invalid-feedback">
                    <?= form_error('cc'); ?>
                </div>
                <?php if (!form_error('to')){ ?>
                  <small class="text-muted">Pisahkan beberapa email dengan koma.</small>
              <?php } ?>
            </div>
            <div class="col-12">
                <label class="form-label">BCC</label>
                <input type="text" name="bcc" class="form-control <?= form_error('bcc') ? 'is-invalid' : '' ?>" id="bcc" placeholder="Masukkan email bcc" value="<?= set_value('bcc') ?>">
                <div class="invalid-feedback">
                    <?= form_error('bcc'); ?>
                </div>
                <?php if (!form_error('to')){ ?>
                  <small class="text-muted">Pisahkan beberapa email dengan koma.</small>
              <?php } ?>
            </div>
            <div class="col-12">
              <label class="form-label">Subject <span class="text-danger">*</span></label>
              <input type="text" name="subject" class="form-control <?= form_error('subject') ? 'is-invalid' : '' ?>" id="subject" placeholder="subject" value="<?= set_value('subject') ?>">
              <div class="invalid-feedback">
                <?= form_error('subject'); ?>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label">Attachment</label>
              <input type="file" name="attachment[]" class="form-control <?= isset($error) ? 'is-invalid' : '' ?>" id="attachment" multiple>
              <div class="invalid-feedback">
                  <?= $error; ?>
              </div>
              <?php if (empty($error)){ ?>
                <small class="text-muted">Ukuran maksimal 2MB per file. Jenis file yang diizinkan: .jpeg, .jpg, .png, .pdf, .doc, .docx, .xls, .xlsx.</small>
              <?php } ?>
            </div>
            <div class="col-12">
               <textarea name="message" class="form-control <?= form_error('message') ? 'is-invalid' : '' ?> tinymce-editor" id="message" rows="5" placeholder="Tulis pesan di sini"><?php echo set_value('message'); ?></textarea>
               <div class="invalid-feedback">
                <?= form_error('message'); ?>
              </div>
            </div>
            <div class="mt-3 d-flex justify-content-end">
              <button type="reset" class="btn btn-secondary">Reset</button>&nbsp;
              <button type="submit" class="btn btn-success">Kirim</i></button>
            </div>
          </form><!-- Vertical Form -->

        </div>
      </div>
    </div>
  </div>
</main>