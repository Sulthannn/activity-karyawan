<?php
    session_start();
    if(!isset($_SESSION['nama_user'])){
       header("Location: Halaman_login.php");    
    }
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
    <title>BKI - Edit Data</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <!-- END: Custom CSS-->

    <style>
        .btn-primary {
            background: linear-gradient(135deg, #FFDA78, #FF7F3E);
            color: #FFF;
            border: none;
            padding: 12px 24px;
            text-decoration: none;
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
    <!-- END: Header-->

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
                            <li><a class="d-flex align-items-center" href="planning.php"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Planning">Planning</span></a>
                            </li>
                            <li class="active"><a class="d-flex align-items-center" href="avident.php"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Avident">Avident</span></a>
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
                        <h2 class="float-start mb-0">Form Avident</h2>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="proses_insert_informasi.php" method="POST" class="form form-vertical" enctype="multipart/form-data">
                                        <div class="col-2">
                                            <div class="mb-1">
                                                <label for="id_..." class="form-label"></label>
                                                <input type="text" id="id_..." class="form-control" name="id_..." value="<?=$row['id_informasi'] ?>" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label for="date" class="form-label">Date</label>
                                                    <input type="date" class="form-control" name="date" value="<?=$row['date'] ?>" placeholder="" required />
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label for="nup" class="form-label">NUP</label>
                                                    <input type="text" class="form-control" name="nup" value="<?=$row['nup'] ?>" placeholder="Number ..." required />
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" name="name" value="<?=$row['name'] ?>" placeholder="Full Name" required />
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1">
                                                <label for="division" class="form-label">Division</label>
                                                    <select class="form-control" id="division" name="division" value="<?=$row['division'] ?>" required >
                                                        <option value="">-</option>
                                                        <option value="Inspektor">Inspector</option>
                                                        <option value="General">General</option>
                                                        <option value="HSE">HSE</option>
                                                        <option value="Finance">Finance</option>
                                                        <option value="Marketing">Marketing</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label for="img" class="form-label">Image</label>
                                                    <input type="file" class="form-control" name="img" value="<?=$row['img'] ?>" placeholder="" required />
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label for="upload-time" class="form-label">Upload Time</label>
                                                    <input type="time" class="form-control" name="upload-time" value="<?=$row['waktu_unggah'] ?>" placeholder="" required />
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <button type="submit" class="btn btn-primary_2 me-1">Save</button>
                                                <a href="avident.php" class="btn btn-outline-secondary">Back</a>
                                            </div>
                                        </div>
                                    </form>
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