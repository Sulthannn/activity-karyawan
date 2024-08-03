<?php
    session_start();
    include("../../../src-SGExplorer/SGExplorer/admin/koneksi.php");

    $query = "select * from pemetaan";
    $result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE php>
<php lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SGExplorer</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        
  <style>
    php, body {
      height: 100%;
      margin: 0;
    }
    #peta_lamun {
      width: 100%;
      height: 400px; /* Sesuaikan tinggi peta sesuai kebutuhan Anda */
      border-radius: 10px;
    }
  </style>

  <script src="lamun.js"></script>

</head>
<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <!-- <img src="assets/img/logo asik/2.png" style="max-width: 50px;"; alt="SGExplorer Logo"> -->
      <div class="logo">
        <a href="index.php" style="display: flex;">
        <h1 class="text-light" style="font-family: Cambria"><a href="index.php">SGExplorer</a></h1>
        </a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php" style="font-family: Cambria">Beranda</a></li>
          <li><a class="active" href="pemetaan.php" style="font-family: Cambria">Peta</a></li>
          <li><a href="informasi.php" style="font-family: Cambria">Informasi</a></li>
          <li><a class="getstarted" href="../../../src-SGExplorer/SGExplorer/admin/Halaman_login.php" style="font-family: Cambria">Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
    </div>
  </header>
  <!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="breadcrumb-hero">
        <div class="container">
          <div class="breadcrumb-hero">
            <h2 style="font-family: Cambria">Pemetaan Lamun</h2>
          </div>
        </div>
      </div>
      <div class="container">
        <ol>
          <li><a href="index.php" style="font-family: Cambria">Beranda</a></li>
          <li style="font-family: Cambria">Peta</li>
        </ol>
      </div>
    </section>
    <!-- End Breadcrumbs -->

    <div id="peta_lamun" class="container"></div>

    <section id="team" class="team services section-title pt-5">
      <div class="container">
        <div class="section-title" data-aos="fade-up">
          
   <!-- <h2>Features</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div> -->

        <div class="row">
            <?php
            $i = 1;
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                        <div class="member" data-aos="fade-up">
                            <div class="member-img">
                                <img src="../../../src-SGExplorer/SGExplorer/admin/img/<?php echo $row['gmbr_pulau']; ?>" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4 style="font-family: Cambria"><?php echo $row['nama_pulau']; ?></h4>
                                <p style="font-family: Cambria"><?php echo $row['luasan']; ?> (Ha)</p>
                                <p style="font-family: Cambria"><?php echo $row['spesies_lamun']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php
                        $i++;
                    }
                }
            ?>
        </div>
    </div>
</section>
  </main>

  <!-- ======= Footer ======= -->
  <footer id="footer" style="font-family: Cambria;">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-info">
            <h3>SGExplorer</h3>
            <p style="text-align: justify;">Website ini didedikasikan untuk pemetaan lamun, informasi mendalam tentang distribusi, kesehatan, dan keberagaman lamun di pesisir Taman Nasional dengan pemetaan akurat dan terkini.</p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Tautan</h4>
            <ul>
              <li><a href="index.php">Beranda</a></li>
              <li><a href="pemetaan.php">Pemetaan</a></li>
              <li><a href="informasi.php">Informasi</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-contact">
            <h4>Kontak</h4>
            <p>
              Jl. Ciracas No. 38, Serang<br>
              Kota Serang, Banten. 42116.<br>
              <strong>telp  : </strong> (0254) 200277<br>
              <strong>email :</strong> sik_kdserang@upi.edu<br>
            </p>

            <div class="social-links">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>

          </div>

          <div class="col-lg-3 col-md-6 footer-newsletter">
            <h4>Hubungi Kami</h4>
            <form action="" method="post">
              <div>
                <label for="">Email</label>
                <input type="text" class="form-control" name="" placeholder="" />
              </div>
              <div>
                <label for="">Pesan</label>
                <textarea style="width: 265; height: 50px;" type="text" class="form-control" name="" placeholder=""></textarea>
              </div>
              <br>
              <div>
                <button type="submit" class="btn me-1" style="background-color: #88AB8E; color: white;">Save</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>SGExplorer</span></strong>. All Rights Reserved
      </div>
    </div>
  </footer>
  <!-- End Footer -->

  <script>
        // const / var
        var lamun1 = L.layerGroup();

        function getColor(d) {
          return d > 1  ? '#FB8B24' : '#FB8B24' ;
      }

      function style(feature) {
          return {
              fillColor: getColor(feature.properties.gridcode),
              weight: 0,
              opacity: 0,
              color: 'orange',
              dashArray: '3',
              fillOpacity : 10,
          };
      }

    L.geoJSON(lamun, {style: style}).addTo(lamun1);

        // var overlayMaps = {
        // "lamun" : lamun1,
        // };
    </script>
    
    <script>
        var imagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
            maxZoom: 18
        });
        
        var layerControl = L.map('peta_lamun', {
            center: [-0.6507305977456189, 115.69706730376701],
            zoom: 5,
            layers: [imagery, lamun1]
        });

        L.control.layers(overlayMaps).addTo(layerControl);
    </script>
    <script>
        <?php
            $query = "select * from pemetaan";
            $result_peta = mysqli_query($koneksi, $query);

            $i = 1;
                if(mysqli_num_rows($result_peta) > 0){
                    while($row_peta = mysqli_fetch_assoc($result_peta)){
            ?>

            var marker = L.marker([<?php echo $row_peta['titik_koordinat']; ?>])
              .bindPopup("<b style='font-family: Cambria; font-size: 15px;'><?php echo $row_peta['nama_pulau']; ?></b><br><br><img style='border-radius: 10px; display: block; margin: 0 auto;' src='../../../src-SGExplorer/SGExplorer/admin/img/<?php echo $row_peta['gmbr_pulau']; ?>' alt='Gambar Lamun' width='150'><br><b style='font-family: Cambria; font-size: 12px;'><?php echo $row_peta['luasan']; ?> (Ha)</b><br><div style='text-align: justify;'><b style='font-family: Cambria; font-size: 11px;'>Spesies Lamun:</b> <?php echo $row_peta['spesies_lamun']; ?></div>")
                .addTo(layerControl);
    
        <?php
            }

        }
            ?>
    
    </script>
        
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</php>