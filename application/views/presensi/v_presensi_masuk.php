
  <main id="main" class="main flex-grow-1">

    <div class="pagetitle">
      <h1>Presensi Masuk</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row justify-content-center">
          <div id="kamera" class="col-md-4"></div>&nbsp;
          <div id="hasil" class="col-md-4" style="display: none;"></div>
      </div>
      <div class="row justify-content-center"> 
          <button class="btn btn-primary mt-2 col-sm-4" onClick="Ambilfoto()">Ambil Foto</button>&nbsp;
          <button id="kirim" class="btn btn-primary mt-2 col-sm-4" style="display: none;" onClick="Kirim()">Kirim</button>
      </div>
    </section>
  </main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script>
  var datafoto = '';
  Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 50
    });
    Webcam.attach( '#kamera' );
    
    function Ambilfoto() {
        Webcam.snap( function(data_uri) {
          datafoto = data_uri;
            document.getElementById('hasil').innerHTML = '<img src="'+data_uri+'"/>';
            document.getElementById('hasil').style.display = 'block';
            document.getElementById('kirim').style.display = 'block';
        } );
    }
    function Kirim() {
        if (datafoto) { 
            $.ajax({
                url: '<?= base_url('presensi/PresensiMasuk_proses') ?>',
                type: 'POST',
                data: {
                    foto: datafoto 
                },
                success: function(response) {
                    toastr["success"]("Presensi Masuk Berhasil");
                    setTimeout(function() {
                        window.location.href = '<?= base_url('dashboard') ?>';
                    }, 2000);
                },
                error: function() {
                    toastr["error"]("Presensi Masuk Gagal");
                }
            });
        } else {
            toastr["error"]("Silakan ambil foto terlebih dahulu.");
        }
    }
</script>



<!-- <script>
    Set kamera
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    Webcam.attach('#kamera');

    function Ambilfoto() {
        Webcam.snap(function(data_uri) {
            
            $.ajax({
                url: '<?= base_url('presensi/PresensiMasuk_proses') ?>',
                type: 'POST',
                data: {
                    foto: data_uri
                },
                success: function(response) {
                    toastr["success"]("Presensi Masuk Berhasil");
                    setTimeout(function() {
                        window.location.href = '<?= base_url('dashboard') ?>';
                    }, 2000);
                },
                error: function() {
                    toastr["error"]("Presensi Masuk Gagal");
                }
            });
        });
    }
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "showDuration": "300",
      "hideDuration": "300",
      "timeOut": "4000",
      "extendedTimeOut": "100",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "slideDown",
      "hideMethod": "slideUp"
    }
</script> -->