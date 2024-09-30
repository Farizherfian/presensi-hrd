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
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <!-- <div class="row"> -->

        <?php if ($this->session->flashdata('berhasil') ): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('berhasil') ?> <span class="fw"><?= $this->session->userdata('nama_lengkap'); ?></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error') ): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

      <?php if ($this->session->userdata('nr') == 'Karyawan'){ ?>
        <!-- Left side columns -->
        <div class="col-lg-12 mt-5">
          <div class="row">
          <?php 
            $hariIni = date('N'); // Mendapatkan hari dalam bentuk angka (1 = Senin, 7 = Minggu)
            if ($hariIni == 6 || $hariIni == 7) { ?>
            <div class="col-xxl-4 col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="d-flex flex-column justify-content-center align-items-center mt-5">
                            <i class="bi bi-emoji-smile" style="font-size: 5rem;"></i>
                            <h5>Hari Ini Libur</h5>
                            <h6>Tidak Bisa Absen Pada Hari Sabtu dan Minggu</h6>
                        </div>
                    </div>
                </div>
            </div>
          <?php }elseif ($cek_cuti > 0) { ?>
            <div class="col-xxl-4 col-md-4 mb-4">
              <div class="card h-100">
                <div class="card-body text-center">

                  <div class="d-flex flex-column justify-content-center align-items-center mt-5">
                  <i class="bi bi-emoji-smile" style="font-size: 5rem;"></i>
                    <h5>Anda Sedang Cuti/Sakit</h5>
                 </div>

                </div>
              </div>
            </div>
          <?php }elseif ($cek_presensiMasuk < 1){ ?>
            <div class="col-xxl-4 col-md-4 mb-4">

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
                  <form action="<?= base_url('presensi/presensiMasuk') ?>" method="post">
                    <input type="hidden" name="latitude_user" id="latitude_user">
                    <input type="hidden" name="longitude_user" id="longitude_user">
                    <button class="btn btn-primary mt-5">Masuk</button>
                  </form>
                </div>
              </div>
            </div>
          <?php }elseif ($cek_presensiKeluar > 0) { ?>
            <div class="col-xxl-4 col-md-4 mb-4">
              <div class="card h-100">
                <div class="card-body text-center">

                  <div class="d-flex flex-column justify-content-center align-items-center mt-5">
                  <i class="bi bi-emoji-smile" style="font-size: 5rem;"></i>
                    <h4>Selamat Istirahat</h5>
                    <h4> Sampai Jumpa Besok</h5>
                 </div>

                </div>
              </div>
            </div>
          <?php } else { ?>
            <div class="col-xxl-4 col-md-4 mb-4">

              <div class="card h-100">
                <div class="card-body text-center">

                  <h5 class="card-title">Presensi Keluar</h5>
                  <div><h6 class="fw-bold fs-4 mb-3"><?= date('d F Y'); ?></h6></div>
                  <div class="parent-clock mt-5">
                    <div id="jam"></div>
                    <div>:</div>
                    <div id="menit"></div>
                    <div>:</div>
                    <div id="detik"></div>
                  </div>
                  <form action="<?= base_url('presensi/presensiKeluar') ?>" method="post">
                    <input type="hidden" name="latitude_user" id="latitude_user">
                    <input type="hidden" name="longitude_user" id="longitude_user">
                    <button class="btn btn-danger mt-5" id="btn-keluar">Keluar</button>
                  </form>
                </div>
              </div>
            </div>
          <?php } ?>
            <div class="col-xxl-4 col-md-4 mb-4">
              <a href="<?= base_url('pengajuancuti') ?>">
              <div class="card h-100">
                <div class="card-body text-center">

                  <div class="d-flex flex-column justify-content-center align-items-center mt-5">
                    <i class="bi bi-calendar3" style="font-size: 5rem;"></i>
                    <h3>Sisa Cuti</h3>
                    <h2 class="mb-0 fw-bold"><?= $sisa_cuti2 ?> Hari</h2>
                 </div>

                </div>
              </div>
              </a>
            </div>
            <div class="col-xxl-4 col-md-4 mb-4">
              <a href="<?= base_url('pengajuancuti') ?>">
              <div class="card h-100">
                <div class="card-body text-center">

                  <div class="d-flex flex-column justify-content-center align-items-center mt-5">
                    <i class="bi bi-hourglass-split" style="font-size: 5rem;"></i>
                    <h3>Pengajuan Cuti/Sakit</h3>
                    <h2 class="mb-0 fw-bold"><?= $pending ?> PENDING</h2>
                 </div>

                </div>
              </div>
              </a>
            </div>

          </div>
        </div><!-- End Left side columns -->
        <?php } ?>

        <?php if ($this->session->userdata('nr') != 'Karyawan'){ ?>
        <div class="row">
          <div class="col-xxl-3 col-md-4">
            <a href="<?= base_url('presensi/data_presensi') ?>">
            <div class="card info-card ">

              <div class="card-body">
                <h5 class="card-title">Tidak Hadir <span>| Hari Ini</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-calendar-x"></i>
                  </div>
                  <div class="ps-4">
                    <h6><?= $jumlah_tidak_hadir ?></h6>
                  </div>
                </div>
              </div>

            </div>
            </a>
          </div>
          <div class="col-xxl-3 col-md-4">
            <a href="<?= base_url('pengajuancuti') ?>">
            <div class="card info-card ">

              <div class="card-body">
                <h5 class="card-title">Sakit <span>| Hari Ini</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bx bx-plus-medical"></i>
                  </div>
                  <div class="ps-4">
                    <h6><?= $sakit_hari_ini ?></h6>
                  </div>
                </div>
              </div>

            </div>
            </a>
          </div>
          <div class="col-xxl-3 col-md-4">
            <a href="<?= base_url('pengajuancuti') ?>">
            <div class="card info-card ">

              <div class="card-body">
                <h5 class="card-title">Cuti <span>| Hari Ini</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-calendar3"></i>
                  </div>
                  <div class="ps-4">
                    <h6><?= $cuti_hari_ini ?></h6>
                  </div>
                </div>
              </div>

            </div>
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-xxl-3 col-md-4">
            <a href="<?= base_url('karyawan') ?>">
            <div class="card info-card card">

              <div class="card-body">
                <h5 class="card-title">Jumlah Karyawan</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-4">
                    <h6><?= $jumlah_karyawan ?></h6>
                  </div>
                </div>
              </div>

            </div>
            </a>
          </div>
          <div class="col-xxl-3 col-md-4">
            <a href="<?= base_url('karyawan') ?>">
            <div class="card info-card">

              <div class="card-body">
                <h5 class="card-title">Karyawan Pensiun</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-x"></i>
                  </div>
                  <div class="ps-4">
                    <h6><?= $karyawan_pensiun ?></h6>
                  </div>
                </div>
              </div>

            </div>
            </a>
          </div>
          <div class="col-xxl-3 col-md-4">
            <a href="<?= base_url('pengajuancuti') ?>">
            <div class="card info-card ">

              <div class="card-body">
                <h5 class="card-title">Pengajuan Cuti/Sakit</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-hourglass-split"></i>
                  </div>
                  <div class="ps-4">
                    <h6><?= $pengajuan_pending ?> Pending</h6>
                  </div>
                </div>
              </div>

            </div>
            </a>
          </div>
        <?php } ?>
      </div>

      <div class="row">  
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Karyawan Terbaik | <?= date('F', strtotime('-1 month')); ?></h5>

                <ol class="list-group list-group-numbered">
                    <?php foreach ($karyawan_terbaik as $karyawan): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold"><?= $karyawan['nama_lengkap']; ?> <span class="badge bg-success rounded-pill"><?= $karyawan['hadir']; ?> Hadir</span></div>
                                NIK: <?= $karyawan['nik']; ?>
                            </div>
                            <img src="<?= base_url(); ?>assets/uploads/<?= $karyawan['foto']; ?>" style="width: 50px; height: auto;">
                            <!-- <span class="badge bg-success rounded-pill"><?= $karyawan['hadir']; ?> Hadir</span> -->
                        </li>
                    <?php endforeach; ?>
                </ol>
            
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Karyawan Terburuk | <?= date('F', strtotime('-1 month')); ?></h5>

                <ol class="list-group list-group-numbered">
                    <?php foreach ($karyawan_terburuk as $karyawan): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold"><?= $karyawan['nama_lengkap']; ?> <span class="badge bg-success rounded-pill"><?= $karyawan['alpha']; ?> Alpha</span></div>
                                NIK: <?= $karyawan['nik']; ?>
                            </div>
                            <img src="<?= base_url(); ?>assets/uploads/<?= $karyawan['foto']; ?>" style="width: 50px; height: auto;">
                            <!-- <span class="badge bg-success rounded-pill"><?= $karyawan['alpha']; ?> Alpha</span> -->
                        </li>
                    <?php endforeach; ?>
                </ol>
            
            </div>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
            <?php if ($this->session->userdata('nr') == 'Karyawan'){ ?>
                <h5 class="card-title">Chart Kehadiran Tahun <?= date('Y') ?> <span>| <?= $this->session->userdata('nama_lengkap') ?></span></h5>
              <?php }else{ ?>
                <h5 class="card-title">Chart Kehadiran Tahun <?= date('Y') ?></h5>
              <?php } ?>

              <!-- Bar Chart -->
              <canvas id="barChart" style="max-height: 400px;"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const hadirData = <?= json_encode($hadir_per_bulan) ?>; // Data dari controller

                    new Chart(document.querySelector('#barChart'), {
                        type: 'bar',
                        data: {
                            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                            datasets: [{
                                label: 'Jumlah hadir',
                                data: hadirData, // Gunakan data hadir
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(255, 205, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(201, 203, 207, 0.2)',
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(255, 205, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(54, 162, 235, 0.2)'
                                ],
                                borderColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(255, 159, 64)',
                                    'rgb(255, 205, 86)',
                                    'rgb(75, 192, 192)',
                                    'rgb(54, 162, 235)',
                                    'rgb(153, 102, 255)',
                                    'rgb(201, 203, 207)',
                                    'rgb(255, 99, 132)',
                                    'rgb(255, 159, 64)',
                                    'rgb(255, 205, 86)',
                                    'rgb(75, 192, 192)',
                                    'rgb(54, 162, 235)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
              </script>
              <!-- End Bar CHart -->

            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <?php if ($this->session->userdata('nr') == 'Karyawan'){ ?>
                <h5 class="card-title">Chart Cuti dan Sakit Tahun <?= date('Y') ?> <span>| <?= $this->session->userdata('nama_lengkap') ?></span></h5>
              <?php }else{ ?>
                <h5 class="card-title">Chart Cuti dan Sakit Tahun <?= date('Y') ?></h5>
              <?php } ?>

              <!-- Column Chart -->
              <div id="columnChart"></div>

              <script>
                  document.addEventListener("DOMContentLoaded", () => {
                      const sakitData = <?= json_encode($sakit_per_bulan) ?>; // Data sakit per bulan dari controller
                      const cutiData = <?= json_encode($cuti_per_bulan) ?>;   // Data cuti per bulan dari controller

                      new ApexCharts(document.querySelector("#columnChart"), {
                          series: [{
                              name: 'Sakit',
                              data: sakitData  // Data sakit per bulan
                          }, {
                              name: 'Cuti',
                              data: cutiData   // Data cuti per bulan
                          }],
                          chart: {
                              type: 'bar',
                              height: 350
                          },
                          plotOptions: {
                              bar: {
                                  horizontal: false,
                                  columnWidth: '55%',
                                  endingShape: 'rounded'
                              },
                          },
                          dataLabels: {
                              enabled: false
                          },
                          stroke: {
                              show: true,
                              width: 2,
                              colors: ['transparent']
                          },
                          xaxis: {
                              categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                          },
                          yaxis: {
                              title: {
                                  text: 'Jumlah Hari'
                              }
                          },
                          fill: {
                              opacity: 1
                          },
                          tooltip: {
                              y: {
                                  formatter: function(val) {
                                      return val + " hari";
                                  }
                              }
                          }
                      }).render();
                  });
              </script>
              <!-- End Column Chart -->

            </div>
          </div>
        </div>

      <!-- </div> -->
    </section>
  </main>
<script>
  const jamPulang = "<?= $this->config->item('jam_pulang'); ?>";  // Ambil nilai jam_pulang dari konfigurasi

  window.setInterval("waktu()", 1000);

  function waktu() {
    const waktu = new Date();
    const jam = waktu.getHours();
    const menit = waktu.getMinutes();
    const detik = waktu.getSeconds();

    document.getElementById("jam").innerHTML = formatWaktu(jam);
    document.getElementById("menit").innerHTML = formatWaktu(menit);
    document.getElementById("detik").innerHTML = formatWaktu(detik);

    // Pisahkan jam dan menit dari jamPulang (format 17:00)
    const jamPulangSplit = jamPulang.split(":");
    const jamKeluar = parseInt(jamPulangSplit[0], 10);
    const menitKeluar = parseInt(jamPulangSplit[1], 10);

    // Cek apakah waktu sudah mencapai jam pulang
    if (jam > jamKeluar || (jam === jamKeluar && menit >= menitKeluar)) {
      document.getElementById("btn-keluar").style.display = "block"; // Tampilkan tombol keluar
    } else {
      document.getElementById("btn-keluar").style.display = "none";  // Sembunyikan tombol keluar
    }
  }

  function formatWaktu(waktu) {
    return waktu < 10 ? "0" + waktu : waktu;
  }

  // Sembunyikan tombol keluar saat halaman pertama kali dimuat jika belum jam pulang
  document.addEventListener("DOMContentLoaded", function() {
    waktu();
  });

  getLocation();

  function getLocation() {
    if (navigator.geolocation){
      navigator.geolocation.getCurrentPosition(showPosition, showError, {enableHighAccuracy: true});
    } else {
      alert("Browser Anda tidak mendukung Geolocation");
    }
  }

  function showPosition(position) {
    document.getElementById('latitude_user').value = position.coords.latitude;
    document.getElementById('longitude_user').value = position.coords.longitude;
  }

  function showError(error) {
    switch(error.code) {
      case error.PERMISSION_DENIED:
        alert("Pengguna menolak permintaan Geolocation.");
        break;
      case error.POSITION_UNAVAILABLE:
        alert("Informasi lokasi tidak tersedia.");
        break;
      case error.TIMEOUT:
        alert("Permintaan lokasi memakan waktu terlalu lama.");
        break;
      case error.UNKNOWN_ERROR:
        alert("Terjadi kesalahan yang tidak diketahui.");
        break;
    }
  }

</script>