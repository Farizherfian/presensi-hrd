
  <main id="main" class="main flex-grow-1">

    <div class="row">
      
      <div class="pagetitle col-sm-10">
        <h1>Laporan Kehadiran</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan Kehadiran</li>
          </ol>
        </nav>
      </div>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="card">
            <div class="card-body">
              <h1 class="card-title text-center">LAPORAN KEHADIRAN</h1>

              <form method="post" action="<?= base_url('laporan') ?>" class="form-inline mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <select name="bulan" class="form-select">
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i ?>" <?= $i == $bulan ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 10)) ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="tahun" class="form-select">
                            <?php for ($i = 2020; $i <= date('Y'); $i++): ?>
                                <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" name="tampilkan" class="btn btn-primary">Tampilkan</button>
                        <button type="submit" name="excel" value="1" class="btn btn-success"><i class="ri ri-file-excel-2-line"></i> Excel</button>
                    </div>
                </div>
              </form>

              <!-- Table with stripped rows -->
              <table id="example" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Departemen</th>
                    <th class="text-center">Jabatan</th>
                    <th class="text-center">Hadir</th>
                    <th class="text-center">Cuti</th>
                    <th class="text-center">Sakit</th>
                    <th class="text-center">Alpha</th>
                  </tr>
                </thead>

                <tbody>
                  <?php 
                    $no = 1;
                    foreach ($laporan as $row){ ?>
                      <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center"><?= $row['nik']; ?></td>
                        <td><?= $row['nama_lengkap']; ?></td>
                        <td><?= $row['departemen']; ?></td>
                        <td><?= $row['jabatan']; ?></td>
                        <td class="text-center"><?= $row['hadir']; ?></td>
                        <td class="text-center"><?= $row['cuti']; ?></td>
                        <td class="text-center"><?= $row['sakit']; ?></td>
                        <td class="text-center"><?= $row['alpha']; ?></td>
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