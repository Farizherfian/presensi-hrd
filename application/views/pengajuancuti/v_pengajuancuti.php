
  <main id="main" class="main flex-grow-1">

    <div class="row">
      
      <div class="pagetitle col-sm-10">
        <h1>Pengajuan Cuti/Sakit</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Pengajuan Cuti/Sakit</li>
          </ol>
        </nav>
      </div>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="card">
            <div class="card-body">
              <h1 class="card-title text-center">PENGAJUAN CUTI/SAKIT</h1>

              <?php if ($this->session->userdata('nr') == 'Karyawan') { ?>
              <a href="<?= base_url('pengajuancuti/tambah') ?>" class="btn btn-primary mb-3"><i class="bi bi-plus-lg"></i> Tambah</a>
              <?php } ?>
              <?php if ($this->session->userdata('nr') != 'Karyawan') { ?>
              <a href="<?= base_url('pengajuancuti/tambah_cuti') ?>" class="btn btn-primary mb-3"><i class="bi bi-plus-lg"></i> Tambah</a>
              <?php } ?>
               
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
              <!-- Table with stripped rows -->
              <table id="example" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Jenis Cuti</th>
                    <th class="text-center">Tanggal Mulai</th>
                    <th class="text-center">Tanggal Selesai</th>
                    <?php if ($this->session->userdata('nr') == 'Karyawan') { ?>
                    <th class="text-center">Bukti</th>
                    <th class="text-center">Deskripsi</th>
                    <?php } ?>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Status</th>
                    <th class="text-center"><i class="bi bi-gear-fill"></i></th>
                  </tr>
                </thead>

                <tbody>
                  <?php 
                    $no = 1;
                    foreach ($pengajuan as $p) { 

                    $upload_path = base_url('assets/uploads/pengajuancuti/' . $p->nik . '/');
      
                    $file_path = $upload_path . $p->bukti;

                    $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
                  ?>
                  <tr class="text-center">
                    <th scope="row" class="text-center"><?= $no++ ?></th>
                    <td class="text-center"><?= $p->nik ?></td>
                    <td class="text-center"><?= $p->nama_lengkap ?></td>
                    <td class="text-center"><?= $p->jenis_cuti ?></td>
                    <td class="text-center"><?= date('d F Y', strtotime($p->tanggal_mulai)) ?></td>
                    <td class="text-center"><?= date('d F Y', strtotime($p->tanggal_selesai)) ?></td>
                    <?php if ($this->session->userdata('nr') == 'Karyawan') { ?>
                    <td class="text-center">
                      <?php if ($p->bukti): ?>
                        <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png'])): ?>
                          <img src="<?= $file_path ?>" alt="Bukti Cuti" style="width: 70px; height: auto;">
                        <?php elseif ($file_extension == 'pdf'): ?>
                          <button class="btn btn-primary"><a href="<?= $file_path ?>" target="_blank" class="text-white">Lihat PDF</a></button>
                        <?php endif; ?>
                      <?php else: ?>
                        Tidak ada bukti
                      <?php endif; ?>
                    </td>
                      <?php if ($p->deskripsi == null) {?>
                        <td class="text-center">-</td>
                      <?php }else{ ?>
                        <td class="text-center"><?= $p->deskripsi ?></td>
                      <?php } ?>
                    <?php } ?>
                    <td class="text-center"><?= $p->jumlah_hari ?> hari</td>
                    <?php if ($p->status_pengajuan == 'DISETUJUI') { ?>
                      <td class="text-center text-white" style="background-color: green;"><?= $p->status_pengajuan ?></td>
                    <?php } elseif ($p->status_pengajuan == 'DITOLAK') { ?>
                      <td class="text-center"><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#alasan<?= $p->id ?>"><?= $p->status_pengajuan ?></button></td>
                    <?php } elseif ($p->status_pengajuan == 'DIBATALKAN') { ?>
                      <td class="text-center"><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#alasandibatalkan<?= $p->id ?>"><?= $p->status_pengajuan ?></button></td>
                    <?php } else {?>
                      <td class="text-center"><?= $p->status_pengajuan ?></td>
                    <?php } ?>
                    <td class="text-center">
                      <?php if ($this->session->userdata('nr') != 'Karyawan') { ?>
                        <a href="<?= base_url() ?>pengajuancuti/detail/<?= $p->id ?>" class="btn btn-warning" title="Detail"><i class="bi bi-eye-fill"></i></a>
                      <?php }else{ ?>
                        <?php if ($p->status_pengajuan == 'PENDING') { ?>
                        <a href="<?= base_url() ?>pengajuancuti/edit/<?= $p->id ?>" class="btn btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>
                        <a href="<?= base_url() ?>pengajuancuti/hapus/<?= $p->id ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus ?')" title="Hapus"><i class="bi bi-trash3"></i></a>
                      <?php } ?>
                      <?php } ?>
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
<?php foreach ($pengajuan as $p) {?>
<div class="modal fade" id="alasan<?= $p->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alasan Penolakan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <textarea class="form-control" readonly=""  name="alasan" style="height: 100px;"><?= set_value('alasan') ?><?= $p->alasan_tolak ?></textarea>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="alasandibatalkan<?= $p->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alasan Dibatalkan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <textarea class="form-control" readonly=""  name="alasan" style="height: 100px;"><?= set_value('alasan') ?><?= $p->alasan_dibatalkan ?></textarea>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>

  </main>


<!--   <?php if ($this->session->userdata('nr') != 'Karyawan' ) { ?>
  <main id="main" class="main flex-grow-1">

    <div class="row">
      
      <div class="pagetitle col-sm-10">
        <h1>Pengajuan Cuti/Sakit</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Pengajuan Cuti/Sakit</li>
          </ol>
        </nav>
      </div>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="card">
            <div class="card-body">
              <h1 class="card-title text-center">PENGAJUAN CUTI/SAKIT</h1>

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
              
              <table id="example" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Tanggal Mulai</th>
                    <th class="text-center">Tanggal Selesai</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Status</th>
                    <th class="text-center"><i class="bi bi-gear-fill"></i></th>
                  </tr>
                </thead>

                <tbody>
                  <?php 
                    $no = 1;
                    foreach ($pengajuan as $k) { 
                  ?>
                  <tr class="text-center">
                    <th scope="row" class="text-center"><?= $no++ ?></th>
                    <td class="text-center"><?= $k->nik ?></td>
                    <td class="text-center"><?= $k->nama_lengkap ?></td>
                    <td class="text-center"><?= date('d F Y', strtotime($k->tanggal_mulai)) ?></td>
                    <td class="text-center"><?= date('d F Y', strtotime($k->tanggal_selesai)) ?></td>
                    <td class="text-center"><?= $k->jumlah_hari ?> Hari</td>
                    <td class="text-center"><?= $k->status_pengajuan ?></td>
                    <td class="text-center">
                      <a href="<?= base_url() ?>pengajuancuti/detail/<?= $k->id ?>" class="btn btn-warning" title="Detail"><i class="bi bi-eye-fill"></i></a>
                  </tr>
                </tbody>
              <?php } ?>
              </table>
              
            </div>
          </div>
      </div>
    </section>

  </main>
  <?php } ?> -->