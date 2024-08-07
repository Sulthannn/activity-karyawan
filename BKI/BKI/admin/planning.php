<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("location: Halaman_login.php");
        exit;
    }

    require 'koneksi.php';

    $result = mysqli_query($koneksi, "SELECT id, nup, nama, divisi FROM users WHERE status = 'Active'");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tanggal        = htmlspecialchars($_POST['tanggal']);
        $user_id        = htmlspecialchars($_POST['user_id']);
        $deskripsi      = htmlspecialchars($_POST['deskripsi']);
        $time_upload_activity_planning = date('Y-m-d H:i:s');
        $history_update = htmlspecialchars($_POST['history_update']);
        $gambar         = '';

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'img/' . $gambar);
        $status = 'Completed';
    } else {
        $status = 'On-progress';
    }

    $data = [
        'tanggal'        => $tanggal,
        'user_id'        => $user_id,
        'deskripsi'      => $deskripsi,
        'gambar'         => $gambar,
        'time_upload_activity_planning' => $time_upload_activity_planning,
        'status'         => $status,
        'history_update' => $history_update
    ];

    if (tambah_planning($data) > 0) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location.href = 'planning.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan!');</script>";
    }
}

    $query = "
        SELECT p.id, p.tanggal, p.deskripsi, p.time_upload_activity_planning, p.status, p.gambar, p.history_update,
            u.nup, u.nama, u.divisi
        FROM planning p
        JOIN users u ON p.user_id = u.id
        WHERE u.status = 'active'
    ";
    $result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>

<html class="loading semi-dark-layout" lang="en" data-layout="semi-dark-layout" data-textdirection="ltr">

<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>BKI - Planning</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.css">
    <!-- <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/bordered-layout.css"> -->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <!-- END: Page CSS-->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        .btn-primary {
            background: linear-gradient(135deg, #AFC8AD, #88AB8E);
            color: #FFF;
            border: none;
            padding: 12px 24px;
            text-decoration: none;
        }
        .gallery-icon {
            color: #2A629A;
            font-size: 24px;
            transition: color 0.3s ease;
        }
        .gallery-icon:hover {
            color: #1A4F6A;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
        <div class="navbar-container d-flex content">
            <div class="d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto">
                <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder">Tirta Samudera Ramadhani</span><span class="user-status">Super Admin</span></div><span class="avatar"><img class="round" src="..." alt="" height="40" width="40"><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user"><a class="dropdown-item" href="page-profile.html"><i class="me-50" data-feather="user"></i> Profile</a>
                        <a class="dropdown-item" href="logout.php"><i class="me-50" data-feather="power"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto">
                    <a class="navbar-brand" href="#">
                        <h2 class="brand-text" font-size: 20px;">BKI</h2>
                        <hr>
                    </a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
            <div class="main-menu-content">
                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                    <li class="nav-item"><a class="d-flex align-items-center" href="dashboard.php"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span></a>
                    </li><br>
                    <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="Employee Activity">Employee Activity</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="time.php"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Employee Time">Time</span></a>
                            </li>
                            <li class="active"><a class="d-flex align-items-center" href="planning.php"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Planning">Planning</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="avident.php"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Avident">Avident</span></a>
                            </li>
                        </ul>
                    </li><br>
                    <li class="nav-item"><a class="d-flex align-items-center" href="role.php"><i data-feather="user-plus"></i><span class="menu-title text-truncate" data-i18n="Role ">Role </span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="content-header-left col-md-9 col-12 mb-2">
                        <div class="row breadcrumbs-top">
                            <h2 class="float-start mb-0">Employee Planning</h2>
                        </div>
                    </div>
                </div>
            <div class="content-body">
                <!-- Table Hover Animation start -->
                <div class="row" id="table-hover-animation">
                    <div class="col-12">
                        
                        <a href="add_planning.php" class="btn btn-primary">Add Data</a>
                        
                        <br>
                        <br>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Planning Data</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover-animation" style="min-width: 2000px;"> <!-- style="min-width: 250px;" -->
                                        <thead>
                                            <tr style="text-align: center;">
                                                <th>No.</th>
                                                <th style="min-width: 150px;">Date</th>
                                                <th>NUP</th>
                                                <th style="min-width: 250px;">Name</th>
                                                <th>Division</th>
                                                <th style="min-width: 500px;">Description</th>
                                                <th style="min-width: 150px;">Upload Time</th>
                                                <th style="min-width: 250px;">Gambar</th>
                                                <th>Status</th>
                                                <th>History</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align: center;">
                                        <?php
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $gambar_arr = explode(',', $row['gambar']);
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                                <td><?php echo $row['nup']; ?></td>
                                                <td><?php echo $row['nama']; ?></td>
                                                <td><?php echo $row['divisi']; ?></td>
                                                <td style="text-align: justify;"><?php echo $row['deskripsi']; ?></td>
                                                <td><?php echo $row['time_upload_activity_planning']; ?></td>
                                                <td>
                                                    <?php if (!empty($row['gambar'])): ?>
                                                        <?php
                                                            $gambar_arr = explode(',', $row['gambar']);
                                                                foreach ($gambar_arr as $gambar):
                                                            ?>
                                                                    <a href="img/<?= htmlspecialchars($gambar) ?>" data-lightbox="gallery-<?= $row['id'] ?>" data-title="<?= htmlspecialchars($gambar) ?>" class="gallery-icon">
                                                                        <i class="fas fa-images" style="font-size: 18px;"></i>
                                                                    </a>
                                                                    <?php endforeach;
                                                                        ?>
                                                    <?php else: 
                                                        ?>
                                                        
                                                        No Image
                                                    <?php endif;
                                                        ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $statusClass = '';
                                                        $statusText = '';
                                                            if (!empty($row['gambar'])) {
                                                                $statusClass = 'badge bg-success';
                                                                $statusText = 'Completed';
                                                            } else {
                                                                $statusClass = 'badge bg-warning';
                                                                $statusText = 'On-progress';
                                                            }
                                                        ?>
                                                    <span class="<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                                </td>
                                                <td><?php echo $row['history_update']; ?></td>
                                                <td>
                                                    <a href="edit_planning.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary_4">Edit</a>
                                                    <a href="hapus_planning.php?id=<?php echo $row['id']; ?>" style="margin-top: 5px;" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data <?php echo $row['nama']; ?> ?')">Delete</a>
                                                </td>
                                            </tr>
                                        <?php
                                            $i++;
                                        }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0"><span class="float-md-start d-block d-md-inline-block mt-25">&copy; Biro Klasifikasi Indonesia <span class="d-none d-sm-inline-block">2024</span></span></p>
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->

    <!-- BEGIN: Vendor JS-->
    <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
    <!-- END: Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>

</body>
</html>