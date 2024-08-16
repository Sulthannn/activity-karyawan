<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("location: Halaman_login.php");
        exit;
    }

    $nama  = $_SESSION['nama'];
    $role  = $_SESSION['role'];
    $image = $_SESSION['image'];

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

    $query = "
        SELECT id, name, email, subject, message 
        FROM feedback
        ORDER BY id DESC
    ";

    $result = mysqli_query($koneksi, $query);

    function mask_email($email) {
        $email_parts = explode("@", $email);
        $name_part   = $email_parts[0];
        $domain_part = $email_parts[1];
        
        if (strlen($name_part) > 2) {
            $masked_name = substr($name_part, 0, 2) . str_repeat('*', strlen($name_part) - 2);
        } else {
            $masked_name = $name_part;
        }
        
        return $masked_name . '@' . $domain_part;
    }

    // Switch Alert - Delete
    if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
        $id = intval($_GET['id']);
        $result = hapus_feedback($id);
        if ($result > 0) {
            echo "<script>
                window.onload = function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Feedback successfully deleted!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        document.location.href = 'feedback.php';
                    });
                }
                </script>";
        } else {
            echo "<script>
                window.onload = function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Feedback failed to deleted!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            </script>";
        }
    }

    $query  = "SELECT * FROM feedback";
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
    <title>BKI - Feedback</title>
    <link href="img/logo.png" rel="icon">
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
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        #searchInput:hover {
            border: 1px solid #003285 !important;
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
                        <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder"><?php echo $nama; ?></span><span class="user-status"><?php echo $role; ?></span></div><span class="avatar"><img class="round" src="img/<?php echo $image; ?>" alt="" height="40" width="40"><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user"><a class="dropdown-item" href="profile.php"><i class="me-50" data-feather="user"></i> Profile</a>
                    <?php if (is_user()): ?>
                        <a class="dropdown-item" href="#" onclick="confirmBreak(); return false;"><i class="me-50" data-feather="battery-charging"></i> Break</a>
                    <?php endif; ?>
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
                            <li><a class="d-flex align-items-center" href="avident.php"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Avident">Avident</span></a>
                            </li>
                        </ul>
                    </li><br>
                    <li class="nav-item"><a class="d-flex align-items-center" href="role.php"><i data-feather="user-plus"></i><span class="menu-title text-truncate" data-i18n="Role ">Role </span></a>
                    </li><br>
                    <li class="active nav-item"><a class="d-flex align-items-center" href="feedback.php"><i data-feather="mail"></i><span class="menu-title text-truncate" data-i18n="Feedback ">Feedback </span></a>
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
                            <h2 class="float-start mb-0">Feedback</h2>
                        </div>
                    </div>
                </div>
            <div class="content-body">
                <!-- Table Hover Animation start -->
                <div class="row" id="table-hover-animation">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div>
                                    <label for="entriesSelect">Show</label>
                                    <select id="entriesSelect" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <label for="entriesSelect" class="ms-2">entries</label>
                                </div>
                                <div>
                                    <input type="text" id="searchInput" placeholder="Search..." class="form-control search-input" style="width: 220px;" onkeyup="searchTable()">
                                </div>
                            </div>
                            <div class="table-responsive"> <!-- style="min-width: 1000px;" -->
                                <table class="table table-hover-animation">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>No.</th>
                                            <th style="min-width: 250px;">Name</th>
                                            <th style="min-width: 250px;">Email</th>
                                            <th style="min-width: 500px;">Subject</th>
                                            <th style="min-width: 500px;">Message</th>
                                            <?php if (is_superadmin()): ?>
                                            <th>Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody" style="text-align: center;">
                                    <?php 
                                        $i = 1;
                                        if(mysqli_num_rows($result) > 0){
                                            while($row = mysqli_fetch_assoc($result)){
                                                $masked_email = mask_email($row['email']);
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>Anonymous</td> 
                                            <td><?php echo $masked_email; ?></td>
                                            <td><?php echo $row['subject']; ?></td>
                                            <td><?php echo $row['message']; ?></td>
                                            <?php if (is_superadmin()): ?>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $row['id']; ?>); return false;">Delete</a>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                        <?php
                                            $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                                <div class="d-flex justify-content-between align-items-center mt-2 px-2">
                                    <div id="table-info" class="text-left"></div>
                                    <div class="pagination-container">
                                        <ul class="pagination">
                                        </ul>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })

        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.querySelector(".table-hover-animation");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) { 
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
        const entriesSelect = document.getElementById('entriesSelect');
        const table = document.querySelector('.table-hover-animation');
        const rows = table.getElementsByTagName('tr');
        const info = document.getElementById('table-info');
        const paginationContainer = document.querySelector('.pagination-container .pagination');

        let currentPage = 1;
        const rowsPerPage = parseInt(entriesSelect.value);

        function updateTable() {
            const entries = parseInt(entriesSelect.value);
            let count = 0;
            let totalEntries = rows.length - 1;
            const totalPages = Math.ceil(totalEntries / entries);

            for (let i = 1; i < rows.length; i++) {
                if (i > (currentPage - 1) * entries && i <= currentPage * entries) {
                    rows[i].style.display = '';
                    count++;
                } else {
                    rows[i].style.display = 'none';
                }
            }
            
            let start = totalEntries > 0 ? (currentPage - 1) * entries + 1 : 0;
            let end = Math.min(currentPage * entries, totalEntries);
            info.textContent = `Showing ${start} to ${end} of ${totalEntries} entries`;
            
            updatePagination(totalPages);
        }

        function updatePagination(totalPages) {
            paginationContainer.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = 'page-item' + (i === currentPage ? ' active' : '');
                const a = document.createElement('a');
                a.className = 'page-link';
                a.href = '#';
                a.textContent = i;
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentPage = i;
                    updateTable();
                });
                li.appendChild(a);
                paginationContainer.appendChild(li);
            }
        }

        entriesSelect.addEventListener('change', function() {
            currentPage = 1;
            updateTable();
        });

        updateTable();
    });

        function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'This action cannot be undone!',
                    text: "Deleting this feedback will remove all associated data. Are you sure you want to proceed?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'feedback.php?id=' + id + '&action=delete';
                    }
                });
            }
        });
    }
    
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