<?php
     session_start();
     include("../../../src-SIkan/SIkan/admin/koneksi.php");

    $query = "select * from data_tangkapan";
    $result = mysqli_query($koneksi, $query);
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SIkan - Data Tangkapan</title>
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

  <!-- =======================================================
  * Template Name: Logis - v1.2.1
  * Template URL: https://bootstrapmade.com/logis-bootstrap-logistics-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>SIkan</h1>
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-item" href="Beranda.php">Beranda</a></li>
          <li><a class="nav-item" href="peta_GIS.php">Peta GIS</a></li>
          <li><a class="active nav-item" href="Tangkapan.php">Data Tangkapan</a></li>
          <li><a class="get-a-quote" style="border-radius: 10px;" href="../../../src-SIkan/SIkan/admin/Halaman_login.php">Login</a></li>
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
  <!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('assets/img/1.jpg');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-8 text-center">
              <h2>Hasil Tangkapan Laut</h2>
              <p>...</p>
            </div>
          </div>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="index.html">Beranda</a></li>
            <li>Data Tangkapan</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Breadcrumbs -->

    <!-- ======= Featured Services Section ======= -->
    <section id="about" class="about">
      <div class="container">
        <div class="gy-4" style="margin-top: -75px;">

        <br>

          <div class="col-lg-12 content order-last order-lg-first" data-aos="fade-up">
            <h3 style="font-size: 25px;">Data Hasil Tangkapan Laut</h3>
            <!-- <h3 style="font-size: 15px;">Satuan : Kg</h3> -->
          </div>
          
        <br>
        
      <div class="col-12 table-responsive" data-aos="fade-up">

      <div class="position-absolute top-0 end-0">
        <a href="../../../src-SIkan/SIkan/admin/export.php" class="btn btn-outline-secondary"><i class="bi bi-download"></i> Export</a>
      </div>

      <br>
      <br>

        <table class="table table-bordered" style="min-width: 2000px;">
          <thead style="font-family: Poppins;">
            <tr>
              <th style="text-align: center;">No.</th>
              <th style="text-align: center;">Bulan</th>
              <th style="text-align: center;">Teri</th>
              <th style="text-align: center;">Belanak</th>
              <th style="text-align: center;">Kembung</th>
              <th style="text-align: center;">Layang</th>
              <th style="text-align: center;">Selar</th>
              <th style="text-align: center;">Tongkol</th>
              <th style="text-align: center;">Tenggiri</th>
              <th style="text-align: center;">Kue</th>
              <th style="text-align: center;">Pari</th>
              <th style="text-align: center;">Udang</th>
              <th style="text-align: center;">Cumi</th>
              <th style="text-align: center;">Rajungan</th>
            </tr>
          </thead>
          <tbody style="text-align: center; font-family: Poppins;">
          <?php 
                                        $i = 1;
                                            if(mysqli_num_rows($result) > 0){
                                                while($row = mysqli_fetch_assoc($result)){
                                        ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row['bulan']; ?></td>
              <td><?php echo $row['ikan1']; ?></td>
              <td><?php echo $row['ikan2']; ?></td>
              <td><?php echo $row['ikan3']; ?></td>
              <td><?php echo $row['ikan4']; ?></td>
              <td><?php echo $row['ikan5']; ?></td>
              <td><?php echo $row['ikan6']; ?></td>
              <td><?php echo $row['ikan7']; ?></td>
              <td><?php echo $row['ikan8']; ?></td>
              <td><?php echo $row['ikan9']; ?></td>
              <td><?php echo $row['ikan10']; ?></td>
              <td><?php echo $row['ikan11']; ?></td>
              <td><?php echo $row['ikan12']; ?></td>
            </tr>
            <?php
                                            $i++;
                                            }
            
                                        }
                                            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
</main>

    <div class="container-fluid" style="background-color: rgb(4, 4, 50); margin-top: 50px;">
        <div class="row" style="margin-left: 122px; margin-top:-50px;">
        <br>
    </div>
    <div class="p-6 div-footer" style="text-align: center; color: white; font-family: Lucida Sans;">
        Copyright © 2022 TaSya
    </div>
        <br>
            </div>
        </div>
    </div>

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