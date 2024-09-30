<?php if ($this->session->userdata('nr') != 'Karyawan') { ?>
    <main id="main" class="main flex-grow-1">
        <div class="row">
            <!-- Pengajuan -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body ">
                        <h4 class="card-title text-center">Detail Pengajuan </h4>
                        <div class="mb-3">
                            <label for="jeniscuti" class="form-label">Jenis Cuti</label>
                            <input type="text" class="form-control" id="jeniscuti" value="<?= $detail['jenis_cuti'] ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="text" class="form-control" id="tanggal_mulai" value="<?= $detail['tanggal_mulai'] ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="text" class="form-control" id="tanggal_selesai" value="<?= $detail['tanggal_selesai'] ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" rows="3" readonly><?= $detail['deskripsi'] ?></textarea>
                        </div>
                        <?php 
                            $upload_path = base_url('assets/uploads/pengajuancuti/' . $detail['nik'] . '/');
      
                            $file_path = $upload_path . $detail['bukti'];

                            $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
                        ?>
                        <div class="mb-3">
                            <label for="bukti" class="form-label">Bukti</label>
                            <?php if ($detail['bukti']): ?>
                                <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png'])): ?>
                                    <div class="mt-2">
                                        <img src="<?= $file_path ?>" alt="Bukti Cuti" style="width: 300px; height: auto;">
                                    </div>
                                <?php elseif ($file_extension == 'pdf'): ?>
                                    <div class="mt-2">
                                        <button class="btn btn-primary"><a href="<?= $file_path ?>" target="_blank" class="text-white">Lihat PDF</a></button>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <input type="text" class="form-control" id="bukti" value="Tidak Ada Bukti" readonly>
                            <?php endif; ?>
                        </div>
                        <div class="mt-3 d-flex justify-content-center">
                            <?php if ($detail['status_pengajuan'] == 'DISETUJUI'){ ?>
                              <?php  
                                $tanggal_mulai = $detail['tanggal_mulai'];
                                $hari_ini = date('Y-m-d');
                                if ($hari_ini < $tanggal_mulai) {
                              ?>
                              <button class="btn btn-lg btn-danger" data-bs-toggle="modal" data-bs-target="#batalkanModal<?= $detail['id'] ?>">
                                  Batalkan
                              </button>&nbsp;
                            <?php } ?>
                            <?php } ?>
                            <?php if ($detail['status_pengajuan'] == 'PENDING'){ ?>
                                <a href="<?= base_url('pengajuancuti/setujui_pengajuan/' . $detail['id'] ) ?>" class="btn btn-lg btn-success">Setujui</a>&nbsp;
                                <button class="btn btn-lg btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal<?= $detail['id'] ?>">Tolak</button>&nbsp;  
                            <?php } ?>
                            <a href="<?= base_url('pengajuancuti') ?>" class="btn btn-lg btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body ">
                        <h4 class="card-title text-center">Informasi Karyawan</h4>
                        <table class="table table-borderless">
                            <div class="mb-3 d-flex justify-content-center">
                              <img class="mb-2" src="<?= base_url(); ?>assets/uploads/<?= $detail['foto']; ?>" style="width: 150px; height: auto;">
                            </div>
                            <tr>
                              <td>NIK</td>
                              <td>:</td>
                              <td><?= $detail['nik'] ?></td>
                            </tr>
                            <tr>
                              <td>Nama Lengkap</td>
                              <td>:</td>
                              <td><?= $detail['nama_lengkap'] ?></td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td><?= $detail['email'] ?></td>
                            </tr>
                            <tr>
                              <td>Tanggal Lahir</td>
                              <td>:</td>
                              <td><?= date('F d, Y', strtotime($detail['tanggal_lahir'])) ?></td>
                            </tr>
                            <tr>
                              <td>Jenis Kelamin</td>
                              <td>:</td>
                              <td><?= $detail['jenis_kelamin'] ?></td>
                            </tr>
                            <tr>
                              <td>No Handphone</td>
                              <td>:</td>
                              <td><?= $detail['no_telepon'] ?></td>
                            </tr>
                            <tr>
                              <td>Departemen</td>
                              <td>:</td>
                              <td><?= $detail['nd'] ?></td>
                            </tr>
                            <tr>
                              <td>Jabatan</td>
                              <td>:</td>
                              <td><?= $detail['nj'] ?></td>
                            </tr>
                            <tr>
                              <td>Tanggal Masuk</td>
                              <td>:</td>
                              <td><?= date('F d, Y', strtotime($detail['tanggal_masuk'])) ?></td>
                            </tr>
                            <?php if ($detail['jenis_cuti'] == 'Cuti'){ ?>
                                <?php if ($detail['status_pengajuan'] == 'PENDING'){ ?>
                                    <tr>
                                      <td>Batas Cuti</td>
                                      <td>:</td>
                                      <td><?= $detail['batas_cuti'] ?></td>
                                    </tr> 
                                <?php }else{ ?>
                                    <tr>
                                      <td>Sisa Cuti</td>
                                      <td>:</td>
                                      <td><?= $detail['batas_cuti'] ?></td>
                                    </tr>
                                <?php } ?>
                            <?php }else{ ?>
                                <tr>
                                  <td>Batas Cuti</td>
                                  <td>:</td>
                                  <td><?= $detail['batas_cuti'] ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                              <td>Status Kepegawaian</td>
                              <td>:</td>
                              <td><?= $detail['status_kepegawaian'] ?></td>
                            </tr>
                            <tr>
                              <td>Alamat</td>
                              <td>:</td>
                              <td><?= $detail['alamat'] ?></td>
                            </tr>
                          </table>
                    </div>
                </div>
            </div>
            <!-- Tolak Modal -->
            <div class="modal fade" id="tolakModal<?= $detail['id']  ?>" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tolakModalLabel">Tolak Pengajaun Cuti</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('pengajuancuti/tolak_pengajuan/' . $detail['id']); ?>" method ="post">
                            <div class="modal-body">
                                <textarea class="form-control" rows="3" name="alasan" placeholder="Berikan Alasan Penolakan..." required></textarea>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Batalkan Modal -->
            <div class="modal fade" id="batalkanModal<?= $detail['id']  ?>" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="batalkanModalLabel">Batalkan Pengajaun Cuti</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('pengajuancuti/batalkan_pengajuan/' . $detail['id']); ?>" method ="post">
                            <div class="modal-body">
                                <textarea class="form-control" rows="3" name="alasan" placeholder="Berikan Alasan Dibatalkan..." required></textarea>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </main>
<?php } else { ?>
    <?php redirect('dashboard'); ?>
<?php } ?>

