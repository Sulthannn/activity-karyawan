<?php
    session_start();
    include("../../../src-SIkan/SIkan/admin/koneksi.php");

    $query = "select * from data_sebaran";
    $result = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SIkan - Peta GIS</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css"> 

  <style>
		html, body {
			height: 75%;
			margin: 0;
		}
		#peta_GIS {
			height: 450px;
			width : 100%;
			max-width : 100%;
			max-height: 100%;
      border-radius: 10px;
		}
	</style>

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <script src="SPL.js"></script>
  <script src="klorofil.js"></script>
  <script src="Batimetri.js"></script>

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">


</head>

<body>

  <!--  x Header -->
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
          <li><a class="active nav-item" href="peta_GIS.php">Peta GIS</a></li>
          <li><a class="nav-item" href="Tangkapan.php">Data Tangkapan</a></li>
          <li><a class="get-a-quote"  style="border-radius: 10px;" href="../../../src-SIkan/SIkan/admin/Halaman_login.php">Login</a></li>
        </ul>
      </nav>

      <!-- Cth. ../../../src-SIkan/SIkan/admin/Halaman_1.php -->

    </div>
  </header>
  <!-- End Header -->

  <main id="main">

    <!-- Breadcrumbs -->
    <div class="breadcrumbs" id="peta">
      <div class="page-header d-flex align-items-center" style="background-image: url('assets/img/1.jpg');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
              <h2>Peta GIS</h2>
              <p>...</p>
            </div>
          </div>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="Beranda.html">Beranda</a></li>
            <li>Peta GIS</li>
          </ol>
        </div>
      </nav>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Peta_GIS -->
    <section id="about" class="about">
      <div class="container">
        <div class="gy-4" style="margin-top: -75px;">

        <br>

          <div class="col-lg-12 content order-last order-lg-first" data-aos="fade-up">
            <h3 style="font-size: 25px;">Peta Sebaran Potensi Ikan</h3>
          </div>
          
        <br>

          <div class="col-12">
            <div class="card mb-4" style="border-radius: 15px;" data-aos="fade-up" data-aos-delay="100">
              <div class="card-body">
                <div id="peta_GIS"></div>
              </div>
            </div>
          </div>

        <br>
        
      <div class="table-responsive" data-aos="fade-up">
        <table id="table" class="table table-bordered">
          <thead style="font-family: Poppins;">
            <tr>
              <th style="text-align: center;">No.</th>
              <th style="text-align: center;">Titik Koordinat</th>
              <th style="text-align: center;">Chla (mg/g)</th> <!-- mg/g -->
              <th style="text-align: center;">Suhu Permukaan Laut (°C)</th> <!-- °C -->
              <th style="text-align: center;">Kedalaman (M) </th> <!-- M -->
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
              <td><?php echo $row['titik_koordinat']; ?></td>
              <td><?php echo $row['nilai_chla']; ?></td>
              <td><?php echo $row['nilai_spl']; ?></td>
              <td><?php echo $row['nilai_kdlmn']; ?></td>
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

  <!-- End Peta_GIS -->

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

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> 
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js   "></script> 
  <script src="tabel.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <script>
        // const / var
        var SPL1 = L.layerGroup();
        var Chla1 = L.layerGroup();
        var Batimetri1 = L.layerGroup();

        function getColor1(d) {
          return d > 25 ? '#FF0000' :
                 d > 24 ? '#FF1500' :
                 d > 23 ? '#FF2B00' :
                 d > 22 ? '#FF4000' :
                 d > 21 ? '#FF5500' :
                 d > 20 ? '#FF6A00' :
                 d > 19 ? '#FF8000' :
                 d > 18 ? '#FF9500' :
                 d > 17 ? '#FFAA00' :
                 d > 16 ? '#FFBF00' :
                 d > 15 ? '#FFD400' :
                 d > 14 ? '#FFEA00' :
                 d > 13 ? '#FFFF00' :
                 d > 12 ? '#EAF800' :
                 d > 11 ? '#D6F100' :
                 d > 10 ? '#C2E900' :
                 d > 9  ? '#B0E200' :
                 d > 8  ? '#9EDB00' :
                 d > 7  ? '#8DD400' :
                 d > 6  ? '#7DCC00' :
                 d > 5  ? '#6EC500' :
                 d > 4  ? '#5FBE00' :
                 d > 3  ? '#51B700' :
                 d > 2  ? '#33B000' :
                 d > 1  ? '#38A800' : '#38A800' ;
      }

              function getColor2(d) {
                return d > 6  ? '#00F516' :
                    d > 5  ? '#73F81E' :
                    d > 4  ? '#C8F81E' :
                    d > 3  ? '#F4D712' :
                    d > 2  ? '#FA8F0A' :
                    d > 1  ? '#F92207' : '#F92207' ;
      }

            function getColor3(d) {
                return
                
                d > 74 ? '#08306B' :
                d > 73 ? '#083470' :
                d > 72 ? '#083776' :
                d > 71 ? '#083B7B' :
                d > 70 ? '#083E80' :
                d > 69 ? '#084286' :
                d > 68 ? '#084688' :
                d > 67 ? '#084991' :
                d > 66 ? '#084D96' :
                d > 65 ? '#08519B' :
                d > 64 ? '#0A549E' :
                d > 63 ? '#0D58A1' :
                d > 62 ? '#105BA4' :
                d > 61 ? '#135FA7' :
                d > 70 ? '#1562A9' :
                d > 69 ? '#1866AC' :
                d > 58 ? '#1B69AF' :
                d > 57 ? '#1E6DB2' :
                d > 56 ? '#2070B4' :
                d > 55 ? '#2474B6' :
                d > 54 ? '#2777B8' :
                d > 53 ? '#2B7BBA' :
                d > 52 ? '#2F7FBC' :
                d > 51 ? '#3282BE' :
                d > 50 ? '#3686C0' :
                d > 49 ? '#3989C2' :
                d > 48 ? '#3D8DC3' :
                d > 47 ? '#4191C5' :
                d > 46 ? '#4594C7' :
                d > 45 ? '#4997C9' :
                d > 44 ? '#4E9ACB' :
                d > 43 ? '#529DCC' :
                d > 42 ? '#57A0CE' :
                d > 41 ? '#5BA3D0' :
                d > 40 ? '#60A6D2' :
                d > 39 ? '#64A9D3' :
                d > 38 ? '#69ACD5' :
                d > 37 ? '#6EB0D7' :
                d > 36 ? '#73B3D8' :
                d > 35 ? '#79B6D9' :
                d > 34 ? '#7FB9DA' :
                d > 33 ? '#84BCDB' :
                d > 32 ? '#8ABFDD' :
                d > 31 ? '#8FC2DE' :
                d > 30 ? '#95C5DF' :
                d > 29 ? '#9BC8E0' :
                d > 28 ? '#A0CBE2' :
                d > 27 ? '#A4CDE3' :
                d > 26 ? '#A8CEE5' :
                d > 25 ? '#ADD0E6' :
                d > 24 ? '#B1D2E8' :  
                d > 23 ? '#B6D4E9' :
                d > 22 ? '#BAD6EB' :
                d > 21 ? '#BED8EC' :
                d > 20 ? '#C3DAEE' :
                d > 19 ? '#C7DBEF' :
                d > 18 ? '#C9DDF0' :
                d > 17 ? '#CCDFF1' :
                d > 16 ? '#CFE1F2' :
                d > 15 ? '#D1E2F3' :
                    d > 14 ? '#D4E4F4' :
                    d > 13 ? '#D6E6F4' :
                    d > 12 ? '#D9E8F5' :
                    d > 11 ? '#DCE9F6' :
                    d > 10 ? '#DEEBF7' :
                    d > 9  ? '#E1EDF8' :
                    d > 8  ? '#E4EFF9' :
                    d > 7  ? '#E7F0FA' :
                    d > 6  ? '#E9F2FB' :
                    d > 5  ? '#ECF4FB' :
                    d > 4  ? '#EFF6FC' : 
                    d > 3  ? '#F2F7FD' : 
                    d > 2  ? '#F4F9FE' : 
                    d > 1  ? '#F7FBFF' : '#F7FBFF' ;
      }

      function style1(feature) {
          return {
              fillColor: getColor1(feature.properties.gridcode),
              weight: 0,
              opacity: 0,
              color: 'orange',
              dashArray: '3',
              fillOpacity : 10,
          };
      }

      function style2(feature) {
          return {
              fillColor: getColor2(feature.properties.gridcode),
              weight: 0,
              opacity: 0,
              color: 'orange',
              dashArray: '3',
              fillOpacity : 10,
          };
      }

      function style3(feature) {
          return {
              fillColor: getColor3(feature.properties.ContourMax),    
              weight: 0,
              opacity: 0,
              color: '#97DECE',
              dashArray: '3',
              fillOpacity : 10,
          };
      }

    L.geoJSON(SPL, {style: style1}).addTo(SPL1);
    L.geoJSON(Chla, {style: style2}).addTo(Chla1);
    L.geoJSON(Batimetri, {style: style3}).addTo(Batimetri1);

        var imagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
        maxZoom: 18
        });
        
        var layerControl = L.map('peta_GIS', {
        center: [-5.884465577957712, 105.87166923534859],
        zoom: 8,
        layers: [imagery, SPL1]
        });

        var overlayMaps = {
        "SPL" : SPL1,
        "Chla": Chla1,
        "Batimetri" : Batimetri1,
        };

        L.control.layers(overlayMaps).addTo(layerControl);

    </script>

    <script>
        <?php
            $query = "select * from data_sebaran";
            $result_peta = mysqli_query($koneksi, $query);

            $i = 1;
                if(mysqli_num_rows($result_peta) > 0){
                    while($row_peta = mysqli_fetch_assoc($result_peta)){
            ?>

    L.marker([<?php echo $row_peta['titik_koordinat']?>]).addTo(layerControl);
    
        <?php
            }

        }
            ?>
    
    </script>

</body>

</html>