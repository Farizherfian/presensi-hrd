
  <main id="main" class="main flex-grow-1">

    <div class="row">
      
      <div class="pagetitle col-sm-10">
        <h1>Data karyawan</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item active">Data karyawan</li>
          </ol>
        </nav>
      </div><!-- End Page Title -->
      <!-- <div class="col-sm-2 mt-4">
        <div class="d-flex justify-content-end">
          <a href="<?= base_url('karyawan/tambah') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
        </div>
      </div>
 -->
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="card">
            <div class="card-body">
              <h1 class="card-title text-center">DATA KARYAWAN</h1>

              <?php if ($this->session->flashdata('berhasil') ): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?= $this->session->flashdata('berhasil') ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>
              <a href="<?= base_url('karyawan/tambah') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>

              <a href="<?= base_url('karyawan/excel') ?>" class="btn btn-success"><i class="ri ri-file-excel-2-line"></i> Excel</a>
                     
              <!-- Table with stripped rows -->
              <table id="example" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Nama Lengkap</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Departemen</th>
                    <th class="text-center">Jabatan</th>
                    <th class="text-center"><i class="bi bi-gear-fill"></i></th>
                  </tr>
                </thead>

                <tbody>
                  <?php 
                    $no = 1;
                    foreach($karyawan as $k){ 
                  ?>
                  <tr class="text-center">
                    <th scope="row" class="text-center"><?= $no++ ?></th>
                    <td><?= $k->nik ?></td>
                    <td><?= $k->nama_lengkap ?></td>
                    <td><?= $k->email ?></td>
                    <td><?= $k->nd ?></td>
                    <td><?= $k->nj ?></td>
                    <td class="text-center">
                      <a href="<?= base_url() ?>karyawan/edit/<?= $k->id?>" class="btn btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>
                      <a href="<?= base_url() ?>karyawan/detail/<?= $k->id?>" class="btn btn-info" title="detail"><i class="bi bi-eye-fill"></i></a>
                      <a href="<?= base_url() ?>karyawan/hapus/<?= $k->id?>" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus ?')" title="Hapus"><i class="bi bi-trash3"></i></a>
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