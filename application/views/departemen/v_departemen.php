
  <main id="main" class="main flex-grow-1">

    <div class="row">
      
      <div class="pagetitle col-sm-10">
        <h1>Data Departemen</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Data Departemen</li>
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
              <h1 class="card-title text-center">DATA DEPARTEMEN</h1>

              <?php if ($this->session->flashdata('berhasil') ): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?= $this->session->flashdata('berhasil') ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>
              <a href="<?= base_url('departemen/tambah') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
              <!-- Table with stripped rows -->
              <table id="example" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Departemen</th>
                    <th class="text-center">Deskripsi</th>
                    <th class="text-center"><i class="bi bi-gear-fill"></i></th>
                  </tr>
                </thead>

                <tbody>
                  <?php 
                    $no = 1;
                    foreach($departemen as $d){ 
                  ?>
                  <tr class="text-center">
                    <th scope="row" class="text-center"><?= $no++ ?></th>
                    <td><?= $d->nama ?></td>
                    <td><?= $d->deskripsi ?></td>
                    <td class="text-center">
                      <a href="<?= base_url() ?>departemen/edit/<?= $d->id?>" class="btn btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>
                      <a href="<?= base_url() ?>departemen/hapus/<?= $d->id?>" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus ?')" title="Hapus"><i class="bi bi-trash3"></i></a>
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