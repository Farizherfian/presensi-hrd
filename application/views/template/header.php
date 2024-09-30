<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= $judul ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- datatables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.3/css/dataTables.bootstrap5.css">
  <!-- Favicons -->
  <link href="<?= base_url('assets/uploads/logo/' . $this->config->item('logo')); ?>" rel="icon">
  <!-- <link href="<?= base_url() ?>assets/assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a class="logo d-flex align-items-center">
        <img src="<?= base_url('assets/uploads/logo/' . $this->config->item('logo')); ?>" alt="">
        <span class="d-none d-lg-block"> <?= $this->config->item('app_name'); ?></span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <!-- <img src="/assets/assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->
            <!-- <i class="bi bi-person-fill"></i> -->
            <img src="<?= base_url(); ?>assets/uploads/<?= $this->session->userdata("foto"); ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= $this->session->userdata("nama_lengkap"); ?></span>
            <!-- <span class="d-none d-md-block ps-2"><?= $this->session->userdata("nama_lengkap"); ?></span> -->
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $this->session->userdata("nama_lengkap"); ?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= base_url('profil'); ?>">
                <i class="bi bi-person"></i>
                <span>Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= base_url('login/logout') ?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>LogOut</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav>&emsp;<!-- End Icons Navigation -->

  </header><!-- End Header -->