  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link <?= $this->uri->segment(1) == 'dashboard' ? '' : 'collapsed' ?>" href="<?= base_url('dashboard') ?>">
          <i class="bi bi-house-door"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <?php if ($this->session->userdata('nr') != 'Karyawan'){ ?>
      <li class="nav-item">
        <a class="nav-link <?= $this->uri->segment(1) == 'departemen' ? '' : 'collapsed' ?>" href="<?= base_url('departemen') ?>">
          <i class="bi bi-building"></i>
          <span>Data Departemen</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $this->uri->segment(1) == 'jabatan' ? '' : 'collapsed' ?>" href="<?= base_url('jabatan') ?>">
          <i class="bi bi-person-badge"></i>
          <span>Data Jabatan</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $this->uri->segment(1) == 'karyawan' ? '' : 'collapsed' ?>" href="<?= base_url('karyawan') ?>">
          <i class="bi bi-people"></i>
          <span>Data Karyawan</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $this->uri->segment(1) == 'presensi' ? '' : 'collapsed' ?>" href="<?= base_url('presensi') ?>">
          <i class="bi bi-journal-text"></i>
          <span>Data Presensi</span>
        </a>
      </li>

      <?php } ?>

      <?php if ($this->session->userdata('nr') == 'Karyawan') { ?>
      <li class="nav-item">
        <a class="nav-link <?= $this->uri->segment(1) == 'presensi' ? '' : 'collapsed' ?>" href="<?= base_url('presensi') ?>">
          <i class="bi bi-journal-text"></i>
          <span>Data Presensi</span>
        </a>
      </li>
      <?php } ?>

      <li class="nav-item">
        <a class="nav-link <?= $this->uri->segment(1) == 'pengajuancuti' ? '' : 'collapsed' ?>" href="<?= base_url('pengajuancuti') ?>">
          <i class="bi bi-envelope-open"></i>
          <span>Pengajuan Cuti/Sakit</span>
        </a>
      </li>

      <?php if ($this->session->userdata('nr') != 'Karyawan'){ ?>
      <li class="nav-item">
        <a class="nav-link <?= $this->uri->segment(1) == 'laporan' ? '' : 'collapsed' ?>" href="<?= base_url('laporan') ?>">
          <i class="bi bi-file-earmark-medical"></i>
          <span>Laporan Kehadiran</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $this->uri->segment(1) == 'kirim_email' ? '' : 'collapsed' ?>" href="<?= base_url('kirim_email') ?>">
          <i class="bi bi-send"></i>
          <span>Kirim Email</span>
        </a>
      </li>
      <?php } ?>

      <li class="nav-item">
        <a class="nav-link <?= $this->uri->segment(1) == 'profil' ? '' : 'collapsed' ?>" href="<?= base_url('profil') ?>">
          <i class="bi bi-person"></i>
          <span>Profil</span>
        </a>
      </li>

      <?php if ($this->session->userdata('nr') != 'Karyawan'){ ?>
      <li class="nav-item">
        <a class="nav-link <?= $this->uri->segment(1) == 'setting' ? '' : 'collapsed' ?>" href="<?= base_url('setting') ?>">
          <i class="bi bi-gear"></i>
          <span>Setting</span>
        </a>
      </li>
      <?php } ?>

      <li class="nav-item">
        <a class="nav-link <?= $this->uri->segment(1) == 'logout' ? '' : 'collapsed' ?>" href="<?= base_url('login/logout') ?>">
          <i class="bi bi-box-arrow-right"></i>
          <span>LogOut</span>
        </a>
      </li>
    </ul>

  </aside><!-- End Sidebar-->