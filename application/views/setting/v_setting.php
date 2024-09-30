
  <main id="main" class="main flex-grow-1">

    <section class="section dashboard">
      <div class="row">

        <div class="card">
            <div class="card-body">
              <h1 class="card-title text-center">SETTING</h1>

              <?php if ($this->session->flashdata('berhasil') ): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?= $this->session->flashdata('berhasil') ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>
              <?php if ($this->session->flashdata('error') ): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?= $this->session->flashdata('error') ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>
            <form action="<?= base_url('setting/update') ?>" method="post" enctype="multipart/form-data">
              <div class="mb-3 d-flex justify-content-center">
                <img class="mb-2" src="<?= base_url('assets/uploads/logo/' . $this->config->item('logo')); ?>" style="width: 150px; height: auto;">
              </div>
              <!-- Nama Aplikasi -->
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="nama_aplikasi" class="form-label">Nama Aplikasi</label>
                    <input type="text" class="form-control" id="nama_aplikasi" name="nama_aplikasi" value="<?= isset($setting['nama_aplikasi']) ? $setting['nama_aplikasi'] : '' ?>" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <!-- Logo Aplikasi -->
                  <div class="mb-3">
                      <label for="logo" class="form-label">Logo Aplikasi</label>
                      <input type="file" class="form-control" name="logo" accept="image/*">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <!-- Jam Masuk -->
                  <div class="mb-3">
                      <label for="jam_masuk" class="form-label">Jam Masuk</label>
                      <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" value="<?= isset($setting['jam_masuk']) ? $setting['jam_masuk'] : '' ?>" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <!-- Jam Pulang -->
                  <div class="mb-3">
                      <label for="jam_pulang" class="form-label">Jam Pulang</label>
                      <input type="time" class="form-control" id="jam_pulang" name="jam_pulang" value="<?= isset($setting['jam_pulang']) ? $setting['jam_pulang'] : '' ?>" required>
                  </div>
                </div>
              </div>

              <div class="mb-3">
                  <label for="pluscode" class="form-label">Plus Code</label>
                  <div class="input-group">
                      <input type="text" class="form-control" id="pluscode" placeholder="Enter Plus Code">
                      <button type="button" id="getLatLngBtn" class="btn btn-primary">Get Lat/Lng</button>
                  </div>
              </div>

              <!-- Latitude and Longitude in One Row -->
              <div class="row mb-3">
                  <div class="col-md-6">
                      <label for="latitude" class="form-label">Latitude</label>
                      <input type="text" class="form-control" id="latitude" name="latitude" value="<?= isset($setting['latitude']) ? $setting['latitude'] : '' ?>" readonly>
                  </div>
                  <div class="col-md-6">
                      <label for="longitude" class="form-label">Longitude</label>
                      <input type="text" class="form-control" id="longitude" name="longitude" value="<?= isset($setting['longitude']) ? $setting['longitude'] : '' ?>" readonly>
                  </div>
              </div>

              <!-- Radius -->
              <div class="mb-3">
                  <label for="radius" class="form-label">Radius (Meter)</label>
                  <input type="number" class="form-control" id="radius" name="radius" value="<?= isset($setting['radius']) ? $setting['radius'] : '' ?>" placeholder="Contoh: 100" required>
              </div>

              <!-- Setting Email -->
              <!-- <h1 class="card-title text-center">SETTING EMAIL</h1> -->


              <!-- SMTP Host -->
              <!-- <div class="mb-3">
                  <label for="smtp_host" class="form-label">SMTP Host</label>
                  <input type="text" class="form-control" id="smtp_host" name="smtp_host" value="<?= isset($setting['smtp_host']) ? $setting['smtp_host'] : '' ?>" placeholder="Contoh: smtp.example.com" required>
              </div> -->

              <!-- SMTP User -->
              <!-- <div class="mb-3">
                  <label for="smtp_user" class="form-label">SMTP User</label>
                  <input type="text" class="form-control" id="smtp_user" name="smtp_user" value="<?= isset($setting['smtp_user']) ? $setting['smtp_user'] : '' ?>" required>
              </div>
 -->
              <!-- SSL/TSL -->
              <!-- <div class="mb-3">
                  <label for="ssl_tsl" class="form-label">SSL/TSL</label>
                  <select id="ssl_tsl" name="ssl_tsl" class="form-select <?= form_error('ssl_tsl') ? 'is-invalid' : '' ?>" required>
                      <option value="ssl" <?= set_select('ssl_tsl', 'ssl'); ?>>SSL</option>
                      <option value="tsl" <?= set_select('ssl_tsl', 'tsl'); ?>>TSL</option>
                  </select>
              </div> -->

              <!-- SMTP Port -->
              <!-- <div class="mb-3">
                  <label for="smtp_port" class="form-label">SMTP Port</label>
                  <input type="number" class="form-control" id="smtp_port" name="smtp_port" value="<?= isset($setting['smtp_port']) ? $setting['smtp_port'] : '' ?>" placeholder="Contoh: 587" required>
              </div> -->

              <!-- Simpan Pengaturan -->
              <div class="mb-3 d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary">Simpan</button>
              </div>   
            </form>

            </div>
          </div>
      </div>
    </section>

  </main>

  <script>
  document.getElementById('getLatLngBtn').addEventListener('click', function () {
    var plusCode = document.getElementById('pluscode').value;

    if (plusCode) {
      // Replace with your own LocationIQ API key
      var apiKey = 'pk.ed8df5abaa8b29a10ee92bd5d105d7e2';
      var url = `https://us1.locationiq.com/v1/search.php?key=${apiKey}&q=${encodeURIComponent(plusCode)}&format=json`;

      fetch(url)
        .then(response => response.json())
        .then(data => {
          if (data && data[0]) {
            document.getElementById('latitude').value = data[0].lat;
            document.getElementById('longitude').value = data[0].lon;
          } else {
            alert('Location not found!');
          }
        })
        .catch(error => {
          console.error('Error fetching location data:', error);
          alert('Error fetching location data. Please try again.');
        });
    } else {
      alert('Please enter a valid Plus Code');
    }
  });
</script>