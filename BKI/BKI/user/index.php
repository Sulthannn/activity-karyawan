<?php
    session_start();
    include("../../../src-SGExplorer/SGExplorer/admin/koneksi.php");

    $query = "select * from informasi";
    $result = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SGExplorer - Index</title>
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
</head>
<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <!-- <img src="assets/img/logo asik/2.png" style="max-width: 50px;"; alt="SGExplorer Logo"> -->
      <div class="logo">
        <a href="index.php" style="display: flex;">
        <h1 class="text-light"><a href="index.php" style="font-family: Cambria">SGExplorer</a></h1>
        </a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="active" href="index.php" style="font-family: Cambria">Beranda</a></li>
          <li><a href="pemetaan.php" style="font-family: Cambria">Peta</a></li>
          <li><a href="informasi.php" style="font-family: Cambria">Informasi</a></li>
          <li><a class="getstarted" href="../../../src-SGExplorer/SGExplorer/admin/Halaman_login.php" style="font-family: Cambria">Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
    </div>
  </header>
  <!-- End Header -->
  
  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container" data-aos="fade-up">
      <h1 style="font-family: Cambria">Welcome to SGExplorer</h1>
      <h2 style="font-family: Cambria">Exploring Seagrass Ecosystems Through Innovative Mapping</h2>
    </div>
  </section>
  <!-- End Hero -->

  <main id="main">
    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row justify-content-end">
          <div class="col-lg-11">
            <div class="row justify-content-end">

              <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
                <div class="count-box py-5">
                  <i class="bi bi-emoji-smile"></i>
                  <span style="font-family: Cambria" data-purecounter-start="0" data-purecounter-end="1" class="purecounter">0</span>
                  <p>Kingdom</p>
                </div>
              </div>

              <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
                <div class="count-box py-5">
                  <i class="bi bi-journal-richtext"></i>
                  <span style="font-family: Cambria" data-purecounter-start="0" data-purecounter-end="2" class="purecounter">0</span>
                  <p>Famili</p>
                </div>
              </div>

              <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
                <div class="count-box pb-5 pt-0 pt-lg-5">
                  <i class="bi bi-clock"></i>
                  <span style="font-family: Cambria" data-purecounter-start="0" data-purecounter-end="7" class="purecounter">0</span>
                  <p>Genus</p>
                </div>
              </div>

              <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
                <div class="count-box pb-5 pt-0 pt-lg-5">
                  <i class="bi bi-award"></i>
                  <span style="font-family: Cambria" data-purecounter-start="0" data-purecounter-end="12" class="purecounter">0</span>
                  <p>Spesies</p>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-lg-6 video-box align-self-baseline position-relative">
            <img src="assets/img/bg.jpeg" class="img-fluid" alt="">
            <a href="https://youtu.be/C871T8Vtj4Q?si=xN-G9tmxRutuZUvN" class="glightbox play-btn mb-4"></a>
          </div>

          <div class="col-lg-6 pt-3 pt-lg-0 content">
            <h3 style="font-family: Cambria">
              WHAT IS SEAGRASS?
            </h3>
            <p class="fst-italic" style="text-align: justify; font-family: Cambria;">
            Seagrass adalah tumbuhan berbunga yang hidup di perairan laut dangkal, biasanya di daerah pesisir. Meskipun disebut "rumput laut," seagrass sebenarnya lebih mirip dengan tanaman darat daripada rumput. Seagrass memiliki akar, batang, dan daun yang mirip dengan tanaman darat pada umumnya.

            Tumbuhan seagrass dapat membentuk padang lamun yang luas di dasar laut. Padang lamun ini menyediakan habitat penting untuk berbagai spesies laut, termasuk ikan, moluska, dan berbagai makhluk laut lainnya. Selain itu, seagrass juga berperan penting dalam menjaga keseimbangan ekosistem laut dan melindungi pesisir pantai dari erosi.
            </p>
            <!-- <ul>
              <li><i class="bx bx-check-double"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
              <li><i class="bx bx-check-double"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
              <li><i class="bx bx-check-double"></i> Voluptate repellendus pariatur reprehenderit corporis sint.</li>
              <li><i class="bx bx-check-double"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
            </ul>
            <p>
              Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
              velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
              culpa qui officia deserunt mollit anim id est laborum
            </p> -->
          </div>
        </div>
      </div>
    </section>

    <!-- ======= Services Section ======= -->
    <section id="services" class="services" style="font-family: Cambria">
      <div class="container">

        <div class="section-title pt-5" data-aos="fade-up">
          <h2>
            Why is seagrass important?
          </h2>
        </div>

        <div class="row" style="text-align: justify;">
          <div class="col-md-6"data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-book" style="color: #e9bf06;"></i></div>
              <h4 style="font-family: Cambria" class="title" ><a href="">Perlindungan Pantai</a></h4>
              <p class="description">Seagrass membantu melindungi pantai dari erosi karena akarnya dapat menahan sedimentasi. Hal ini mengurangi dampak buruk ombak dan badai, serta membantu menjaga kestabilan garis pantai</p>
            </div>
          </div>
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-card-checklist" style="color: #3fcdc7;"></i></div>
              <h4 style="font-family: Cambria" class="title"><a href="">Penyimpanan Karbon</a></h4>
              <p class="description">Seagrass memiliki kapasitas besar untuk menyimpan karbon. Melalui proses fotosintesis, seagrass menyerap karbon dioksida dari atmosfer dan menyimpannya dalam jaringan mereka</p>
            </div>
          </div>
          <div class="col-md-6"data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-briefcase" style="color: #ff689b;"></i></div>
              <h4 style="font-family: Cambria" class="title"><a href="">Habitat dan Keanekaragaman Hayati</a></h4>
              <p class="description">Seagrass menciptakan habitat yang penting bagi berbagai spesies laut, termasuk ikan, moluska, dan krustasea. Keanekaragaman hayati yang tinggi di ekosistem seagrass mendukung rantai makanan laut dan mempertahankan keberagaman hayati di perairan</p>
            </div>
          </div>

          <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-globe" style="color: #d6ff22;"></i></div>
              <h4 style="font-family: Cambria" class="title"><a href="">Sumber Pangan dan Mata Pencaharian</a></h4>
              <p class="description">Sebagian masyarakat bergantung pada seagrass sebagai sumber pangan, terutama bagi komunitas pesisir. Dan beberapa spesies ikan dan invertebrata yang hidup di sekitar seagrass merupakan sumber mata pencaharian bagi nelayan</p>
            </div>
          </div>
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-clock" style="color: #4680ff;"></i></div>
              <h4 style="font-family: Cambria" class="title"><a href="">Pariwisata dan Rekreasi</a></h4>
              <p class="description">Daerah dengan ekosistem seagrass sering menjadi tujuan pariwisata dan tempat rekreasi karena keindahan alamnya. Aktivitas seperti menyelam dan snorkeling di sekitar hutan seagrass menarik banyak wisatawan</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- ======= Features Section ======= -->
  <section id="features" class="features" style="font-family: Cambria"  >
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2 style="font-family: Cambria;">Berita Terkini</h2>
          <p  style="font-family: Cambria; font-size: 20px;">Temukan wawasan terbaru dan informasi dengan membaca berita kami dibawah ini!</p>
        </div>

        <div class="row">
          
        <?php 
          $i = 1;
            if(mysqli_num_rows($result) > 0){
              while($row = mysqli_fetch_assoc($result)){
          ?>
              <div class="col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                  <div class="card" style="background-image: url('../../../src-SGExplorer/SGExplorer/admin/img1/<?php echo $row['gmbr_tempat']; ?>');">
                      <div class="card-body">
                        <h5 class="card-title"><a href=""><?php echo $row['nama_tempat']; ?></a></h5>
                        <h6 style="text-align: center;" class="card-text"><?php echo $row['deskripsi']; ?></h6>
                          <div style="text-align: center;" class="read-more"><a href="<?php echo $row['sumber']?>"><i class="bi bi-arrow-right"></i> Read More</a></div>
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

</html>