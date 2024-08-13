<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: Halaman_login.php");      
    }

    include("koneksi.php");

    function is_superadmin() {
        return $_SESSION['role'] === 'Super-Admin';
    }
    
    function is_admin() {
        return $_SESSION['role'] === 'Admin';
    }
    
    function is_user() {
        return $_SESSION['role'] === 'User';
    }
    
    $nama  = $_SESSION['nama'];
    $role  = $_SESSION['role'];
    $image = $_SESSION['image'];

    // Initialize query strings
$query_all_planning = "SELECT COUNT(*) as total_all_planning FROM planning";
$query_planning = "SELECT COUNT(*) as total_planning FROM planning WHERE status = 'On-progress'";
$query_avident = "SELECT COUNT(*) as total_avident FROM planning WHERE status = 'Completed'";

// Modify queries if the role is User
if ($role == 'User') {
    $query_all_planning .= " WHERE user_id = (SELECT id FROM users WHERE username = '{$_SESSION['username']}')";
    $query_planning .= " AND user_id = (SELECT id FROM users WHERE username = '{$_SESSION['username']}')";
    $query_avident .= " AND user_id = (SELECT id FROM users WHERE username = '{$_SESSION['username']}')";
}

$result_all_planning = mysqli_query($koneksi, $query_all_planning);
$result_planning = mysqli_query($koneksi, $query_planning);
$result_avident = mysqli_query($koneksi, $query_avident);

if (!$result_all_planning || !$result_planning || !$result_avident) {
    echo "Error: " . mysqli_error($koneksi);
    exit;
}

$data_all_planning = mysqli_fetch_assoc($result_all_planning);
$data_planning = mysqli_fetch_assoc($result_planning);
$data_avident = mysqli_fetch_assoc($result_avident);

    // Query untuk data aktivitas
    $query = "
        SELECT p.id, p.tanggal, p.time_login, p.before_break, p.after_break, p.time_logout, p.geotagging, 
            u.nup, u.nama, u.divisi
        FROM time p
        JOIN users u ON p.user_id = u.id
        WHERE u.status = 'active'
    ";
    
    $result = mysqli_query($koneksi, $query);

    date_default_timezone_set('Asia/Jakarta');
    $current_time = date('H:i:s');
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
    <title>BKI - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <!-- END: Page CSS-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .icon-large {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu-modern navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="">
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
                        <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder"><?php echo $nama; ?></span><span class="user-status"><?php echo $role; ?></span></div><span class="avatar"><img class="round" src="img/<?php echo $image; ?>" alt="" height="40" width="40"><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user"><a class="dropdown-item" href="profile.php"><i class="me-50" data-feather="user"></i> Profile</a>
                        <a class="dropdown-item" href="#" onclick="confirmBreak(); return false;"><i class="me-50" data-feather="battery-charging"></i> Break</a>
                        <a class="dropdown-item" href="#" onclick="confirmLogout(); return false;"><i class="me-50" data-feather="power"></i> Logout</a>
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
                        <h1 class="brand-text" style="font-size: 20px;">BKI</h1>
                        <hr>
                    </a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
            <div class="main-menu-content">
                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                    <li class="active nav-item"><a class="d-flex align-items-center" href="dashboard.php"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span></a>
                    </li><br>
                    <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="Employee Activity">Employee Activity</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="time.php"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Employee Time">Time</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="planning.php"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Planning">Planning</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="avident.php"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Avident">Avident</span></a>
                            </li>
                        </ul>
                    </li><br>
                    <?php if (is_superadmin() || is_admin()): ?>
                    <li class="nav-item"><a class="d-flex align-items-center" href="role.php"><i data-feather="user-plus"></i><span class="menu-title text-truncate" data-i18n="Role ">Role </span></a>
                    </li>
                    <br>
                    <li class="nav-item"><a class="d-flex align-items-center" href="feedback.php"><i data-feather="mail"></i><span class="menu-title text-truncate" data-i18n="Feedback ">Feedback </span></a>
                    </li>
                    <?php endif; ?>
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
                            <h2 class="float-start mb-0" style="font-size: 30px;">Welcome <?php echo $nama; ?>!</h2>
                    </div>
                </div>
            </div>
    <!-- END: Content-->
    <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-stats">
        <div class="row match-height">
            <!-- All Planning Card -->
            <div class="col-xl-4 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-header">
                        <h4 style="font-size: 20px;" class="card-title">
                            <i data-feather="calendar" class="icon-large"></i>
                            All Planning
                        </h4>
                    </div>
                    <div class="card-body statistics-body">
                        <div class="statistics-details">
                            <div class="d-flex justify-content-between">
                                <div style="font-size: 17px;" class="statistics-title">Total</div>
                                <div style="font-size: 17px;" class="statistics-value"><?php echo htmlspecialchars($data_all_planning['total_all_planning']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Planning Card -->
            <div class="col-xl-4 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-header">
                        <h4 style="font-size: 20px;" class="card-title">
                            <i data-feather="clock" class="icon-large"></i>
                            Planning
                        </h4>
                    </div>
                    <div class="card-body statistics-body">
                        <div class="statistics-details">
                            <div class="d-flex justify-content-between">
                                <div style="font-size: 17px;" class="statistics-title">On-Progress</div>
                                <div style="font-size: 17px;" class="statistics-value"><?php echo htmlspecialchars($data_planning['total_planning']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Avident Card -->
            <div class="col-xl-4 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-header">
                        <h4 style="font-size: 20px;" class="card-title">
                            <i data-feather="check-circle" class="icon-large"></i>
                            Avident
                        </h4>
                    </div>
                    <div class="card-body statistics-body">
                        <div class="statistics-details">
                            <div class="d-flex justify-content-between">
                                <div style="font-size: 17px;" class="statistics-title">Completed</div>
                                <div style="font-size: 17px;" class="statistics-value"><?php echo htmlspecialchars($data_avident['total_avident']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($_SESSION['telat']) && $_SESSION['telat'] === true): ?>

    <script>
        Swal.fire({
            title: 'Warning',
            text: 'You are <?php echo $_SESSION['telat_waktu']; ?>',
            icon: 'warning',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'swal-confirm-button'
            }
        });

        // CSS untuk mengubah warna tombol konfirmasi
        var style = document.createElement('style');
        style.innerHTML = `
            .swal-confirm-button {
                background-color: #3085d6 !important;
                color: white !important;
            }
        `;
        document.head.appendChild(style);
    </script>


    <?php unset($_SESSION['telat']); ?>
    <?php unset($_SESSION['telat_waktu']); ?>
    <?php endif; ?>

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
        
    function confirmLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Final Check',
                    text: "Have you finished all your work for today?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, I am done!',
                    cancelButtonText: 'No, let me finish'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'logout.php';
                    }
                });
            }
        });
    }

    function confirmBreak() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will take a break!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, break!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'break.php';
            }
        });
    }
    </script>
    
</body>
</html>