<?php
    session_start();
    include("../../../src-SIkan/SIkan/admin/koneksi.php");

    $query = "select * from data_berita";
    $result = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SIkan - Beranda</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body>

  <!-- Header -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="Beranda.php" class="logo d-flex align-items-center">
        <h1>SIkan</h1>
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
      
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="active nav-item" href="Beranda.php">Beranda</a></li>
          <li><a class="nav-item" href="peta_GIS.php">Peta GIS</a></li>
          <li><a class="nav-item" href="Tangkapan.php">Data Tangkapan</a></li>
          <li><a class="get-a-quote" style="border-radius: 10px;" href="../../../src-SIkan/SIkan/admin/Halaman_login.php">Login</a></li>
        </ul>
      </nav>

    </div>
  </header>
  <!-- End Header -->

  <!-- Hero Section -->
  <section id="hero" class="hero d-flex align-items-center">
    <div class="container">
      <div class="row gy-4 d-flex justify-content-between">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h2 data-aos="fade-up">Pelabuhan Perikanan Nasional Karangantu</h2>
          <div class="row gy-4" data-aos="fade-up" data-aos-delay="400"></div>
        </div>

        <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
          <img src="assets/img/hero-img.svg" class="img-fluid mb-3 mb-lg-0" alt="">
        </div>

      </div>
    </div>
  </section>
  <!-- End Hero Section -->

  <main id="main">

    <!-- Start SIkan -->
    <section id="features" class="features">
      <div class="container">

        <div class="row gy-4 align-items-center features-item" data-aos="zoom-out">
          <div class="col-md-5 order-1 order-md-2">
            <center>
            <img src="../../../src-SIkan/SIkan/admin/img/logo.png" style="content-align: center; width: 1000px;" class="img-fluid" alt="">
            </center>
          </div>
          <div class="col-md-7 order-2 order-md-1">
            <h3 style="font-size: 35px;">SIkan</h3>
            <p style="text-align: justify;">
            SIkan merupakan sebuah aplikasi SIkan berbasis web informasi mengenai data sebaran potensi ikan dan data hasil tangkap laut di PPN Karangantu dengan kurun waktu per bulan yang dapat diakses oleh masyarakat umum, terutama untuk para nelayan. Aplikasi berbasis web ini terdapat peta prediksi sebaran potensi ikan menggunakan beberapa parameter tertentu berdasarkan titik koordinat, nilai klorofil-a, nilai suhu permukaan laut (SPL), dan nilai kedalaman laut. Selain itu juga terdapat berita terkini mengenai isu-isu yang beredar di wilayah PPN Karangantu.
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- End SIkan -->

    <!-- Start Fitur -->
  <section id="service" class="services pt-0">
    <div class="container" data-aos="fade-up">
      <div class="section-header">
        <h2>3 Fitur Web SIkan </h2>
      </div>

      <br>
        
        <div class="row gy-4">
          <div class="container featured-services" id="featured-services">
            <div class="row gy-4">

              <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <div class="icon flex-shrink-0"><i class="fa-solid fa-book-open"></i></div>
                <div>
                  <h4 class="title">Berita Seputar Karangantu</h4>
                  <p class="description">Sajian informasi terkini terkait PPN Karangantu</p>
                  <a href="Beranda.php#informasi" class="readmore stretched-link"><span>Learn More</span><i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
          
              <!-- Fitur 1 -->

              <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <div class="icon flex-shrink-0"><i class="fa-solid fa-map-location-dot"></i></div>
                <div>
                  <h4 class="title">Peta Sebaran Potensi Ikan</h4>
                  <p class="description">Menampilkan peta sebaran potensi Ikan di PPN Karangantu</p>
                  <a href="peta_GIS.php#peta" class="readmore stretched-link"><span>Learn More</span><i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
              
              <!-- Fitur 2 -->

              <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="100">
                <div class="icon flex-shrink-0"><i class="fa-sharp fa-solid fa-chart-simple"></i></div>
                <div>
                  <h4 class="title">Data Hasil Tangkapan Laut</h4>
                  <p class="description">Tabel simple yang menampilkan data Hasil Tangkapan Laut PPN Karangantu per-Bulan</p>
                  <a href="Tangkapan.php#hasil_tangkapan" class="readmore stretched-link"><span>Learn More</span><i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
              
              <!-- Fitur 2 -->

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Fitur -->

  <br>
  
    <!-- Start Berita -->
    <section id="service" class="services pt-0">
      <div class="container" data-aos="fade-up"  id="informasi">

        <div class="section-header">
          <h2>Berita</h2>
        </div>

        <div class="row gy-4">
          <?php 
            $i = 1;
              if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
          ?>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="card">
              <div class="card-img">
                <img src="../../../src-SIkan/SIkan/admin/img/<?php echo $row["gmbr"]; ?>" width="750px" alt="" class="img-fluid">
              </div>
              <h3 ><a href="<?php echo $row['sumber']; ?>" class="stretched-link"><?php echo $row['judul']; ?></a></h3>
              <p style="text-align: justify;"><?php echo $row['isi_berita']; ?></p>
            </div>
          </div><!-- End Card Item -->
          <?php
            $i++;
          }
    
        }
          ?>
        </div>
      </div>
    </section>
        
    <!-- End Berita -->
</main>

    <div class="container-fluid" style="background-color: rgb(4, 4, 50); margin-top: 50px;">
        <div class="row" style="margin-left: 122px; margin-top:-50px;">
        <br>
    </div>
    <div class="p-6 div-footer" style="text-align: center; color: white; font-family: Lucida Sans;">
        Copyright © 2022 TaSya, All rights Reserved
    </div>
        <br>
            </div>
        </div>
    </div>
  <!-- End #main -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>