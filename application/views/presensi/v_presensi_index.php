
  <?php if ($this->session->userdata('nr') == 'Karyawan') {?>
    <style>
    .parent-clock{
      display: grid;
      grid-template-columns: auto auto auto auto auto;
      font-size: 35px;
      font-weight: bold;
    }
  </style>
  <main id="main" class="main flex-grow-1">

    <div class="pagetitle">
      <h1>Presensi</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <?php if ($this->session->userdata('nr') == 'Karyawan'){ ?>
        <!-- Left side columns -->
        <div class="col-lg-12 mt-5">
          <div class="row justify-content-center">
          <?php if ($cek_cuti > 0) { ?>
            <div class="col-xxl-8 col-md-4 mb-4">
              <div class="card h-100">
                <div class="card-body text-center">

                  <div class="d-flex flex-column justify-content-center align-items-center mt-5">
                  <i class="bi bi-emoji-smile" style="font-size: 5rem;"></i>
                    <h5>Anda Sedang Cuti/Sakit</h5>
                 </div>

                </div>
              </div>
            </div>
          <?php }else{ ?>

            <div class="col-xxl-4 col-md-4 mb-4">

            <?php if ($cek_presensiMasuk < 1): ?>
              <div class="card h-100">
                <div class="card-body text-center">

                  <h5 class="card-title">Presensi Masuk</h5>
                  <div><h6 class="fw-bold fs-4 mb-3"><?= date('d F Y'); ?></h6></div>
                  <div class="parent-clock mt-5">
                    <div id="jam"></div>
                    <div>:</div>
                    <div id="menit"></div>
                    <div>:</div>
                    <div id="detik"></div>
                  </div>
                    <a href="<?= base_url('presensi/presensiMasuk') ?>" class="btn btn-primary mt-5">Masuk</a>
                </div>
              </div>
            <?php else : ?>
              <div class="card h-100">
                <div class="card-body text-center">

                  <h5 class="card-title">Presensi Masuk</h5>
                  <div class="d-flex flex-column justify-content-center align-items-center mt-3">
                  <i class="bi bi-check-circle text-success" style="font-size: 5rem;"></i>
                    <h5>Anda Sudah Melakukan Presensi Masuk</h5>
                 </div>

                </div>
              </div>

            <?php endif; ?>
            </div>

            <div class="col-xxl-4 col-md-4 mb-4">

            <?php if ($cek_presensiMasuk < 1) : ?>

              <div class="card h-100">
                <div class="card-body text-center">

                  <h5 class="card-title">Presensi Keluar</h5>
                  <div class="d-flex flex-column justify-content-center align-items-center mt-3">
                  <i class="bi bi-x-circle text-danger" style="font-size: 5rem;"></i>
                    <h5>Anda Belum Melakukan Presensi Masuk</h5>
                 </div>

                </div>
              </div>

            <?php elseif ($cek_presensiKeluar > 0) : ?>

              <div class="card h-100">
                <div class="card-body text-center">

                  <h5 class="card-title">Presensi Keluar</h5>
                  <div class="d-flex flex-column justify-content-center align-items-center mt-3">
                  <i class="bi bi-check-circle text-danger" style="font-size: 5rem;"></i>
                    <h5>Anda Sudah Melakukan Presensi Keluar</h5>
                 </div>

                </div>
              </div>

              <?php else : ?>
              <div class="card h-100">
                <div class="card-body text-center">

                  <h5 class="card-title">Presensi Keluar</h5>
                  <div><h6 class="fw-bold fs-4 mb-3"><?= date('d F Y'); ?></h6></div>
                  <div class="parent-clock mt-5">
                    <div id="jam1"></div>
                    <div>:</div>
                    <div id="menit1"></div>
                    <div>:</div>
                    <div id="detik1"></div>
                  </div>
                  <a href="<?= base_url('presensi/presensiKeluar') ?>" class="btn btn-danger mt-5">Keluar</a>
                </div>
              </div>
            <?php endif; ?>
            
            </div>
          <?php } ?>

          </div>
        </div><!-- End Left side columns -->
        <?php } ?>

      </div>
    </section>
  </main>

<script>
    window.setInterval("waktu()", 1000);

    function waktu() {
      const waktu = new Date();
      document.getElementById("jam").innerHTML = formatWaktu(waktu.getHours());
      document.getElementById("menit").innerHTML = formatWaktu(waktu.getMinutes());
      document.getElementById("detik").innerHTML = formatWaktu(waktu.getSeconds());
    }
    window.setInterval("waktu1()", 1000);

    function waktu1() {
      const waktu = new Date();
      document.getElementById("jam1").innerHTML = formatWaktu(waktu.getHours());
      document.getElementById("menit1").innerHTML = formatWaktu(waktu.getMinutes());
      document.getElementById("detik1").innerHTML = formatWaktu(waktu.getSeconds());
    }
    function formatWaktu(waktu) {
      if (waktu < 10) {
        return "0" + waktu;
      }else{
        return waktu;
      }
    }

</script>
<?php } ?>