
  <main id="main" class="main flex-grow-1">

    <div class="row">
      
      <div class="pagetitle col-sm-10">
        <h1>Data Presensi</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Data Presensi</li>
          </ol>
        </nav>
      </div>

    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="card">
            <div class="card-body">
              <h1 class="card-title text-center">DATA PRESENSI</h1>
              <!-- Table with stripped rows -->
              <table id="example" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Waktu Masuk</th>
                    <th class="text-center">Foto Masuk</th>
                    <th class="text-center">Waktu Keluar</th>
                    <th class="text-center">Foto Keluar</th>
                  </tr>
                </thead>

                <tbody>
                  <?php 
                    $no = 1;
                    foreach($presensi as $p){
                      $jam_masuk = $this->config->item('jam_masuk'); 
                      $waktu_masuk = date('H:i', strtotime($p->waktu_masuk)); 
                  ?>
                  <tr class="text-center">
                    <th scope="row" class="text-center"><?= $no++ ?></th>
                    <td class="text-center"><?= $p->nik ?></td>
                    <?php if ($waktu_masuk > $jam_masuk) {?>
                      <td class="bg-danger"><?= $p->nama_lengkap ?></td>
                    <?php }else{?>
                    <td><?= $p->nama_lengkap ?></td>
                    <?php } ?>
                    <td class="text-center"><?= $p->waktu_masuk ?></td>
                    <td>
                      <img class="mb-2" src="<?= base_url() . 'assets/uploads/presensi/' . $p->nik . '/masuk/' . $p->foto_masuk; ?>" width="90px" height="auto">
                    </td>
                    <td class="text-center"><?= $p->waktu_keluar ?></td>
                    <td>
                      <img class="mb-2" src="<?= base_url() . 'assets/uploads/presensi/' . $p->nik . '/keluar/' . $p->foto_keluar; ?>" width="90px" height="auto">
                    </td>
                  </tr>
              <?php } ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
            </div>
          </div>
      </div>
    </section>

  </main>
