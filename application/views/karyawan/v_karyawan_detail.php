
        <main id="main" class="main flex-grow-1">
          <div class="row justify-content-center">
          <div class="col-sm-8 ">
          <div class="card">
            <div class="card-body ">
              <h5 class="card-title text-center">Detail Karyawan</h5>

              <table class="table table-borderless">
                <div class="mb-3 d-flex justify-content-center">
                  <img class="mb-2" src="<?= base_url(); ?>assets/uploads/<?= $karyawan['foto']; ?>" style="width: 150px; height: auto;">
                </div>
                <tr>
                  <td>NIK</td>
                  <td>:</td>
                  <td><?= $karyawan['nik'] ?></td>
                </tr>
                <tr>
                  <td>Nama Lengkap</td>
                  <td>:</td>
                  <td><?= $karyawan['nama_lengkap'] ?></td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td>:</td>
                  <td><?= $karyawan['email'] ?></td>
                </tr>
                <tr>
                  <td>Tanggal Lahir</td>
                  <td>:</td>
                  <td><?= date('F d, Y', strtotime($karyawan['tanggal_lahir'])) ?></td>
                </tr>
                <tr>
                  <td>Jenis Kelamin</td>
                  <td>:</td>
                  <td><?= $karyawan['jenis_kelamin'] ?></td>
                </tr>
                <tr>
                  <td>No Handphone</td>
                  <td>:</td>
                  <td><?= $karyawan['no_telepon'] ?></td>
                </tr>
                <tr>
                  <td>Departemen</td>
                  <td>:</td>
                  <td><?= $karyawan['nd'] ?></td>
                </tr>
                <tr>
                  <td>Jabatan</td>
                  <td>:</td>
                  <td><?= $karyawan['nj'] ?></td>
                </tr>
                <tr>
                  <td>Tanggal Masuk</td>
                  <td>:</td>
                  <td><?= date('F d, Y', strtotime($karyawan['tanggal_masuk'])) ?></td>
                </tr>
                <tr>
                  <td>Batas Cuti</td>
                  <td>:</td>
                  <td><?= $karyawan['batas_cuti'] ?></td>
                </tr>
                <tr>
                  <td>Status Kepegawaian</td>
                  <td>:</td>
                  <td><?= $karyawan['status_kepegawaian'] ?></td>
                </tr>
                <tr>
                  <td>Role</td>
                  <td>:</td>
                  <td><?= $karyawan['nr'] ?></td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td>:</td>
                  <td><?= $karyawan['alamat'] ?></td>
                </tr>
              </table>
              <div class="mt-3 d-flex justify-content-end">
                  <a href="<?= base_url('karyawan') ?>" class="btn btn-danger">Kembali</a>
                </div>
            </div>
          </div>
          </div>
          </div>
        </main>
