<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: Halaman_login.php");
}

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];
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

// Delete user
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    $result = hapus_user($id);
    if ($result > 0) {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Role successfully deleted!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    document.location.href = 'role.php';
                });
            }
            </script>";
    } else {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Role failed to deleted!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        </script>";
    }
}

// Change status user
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'change_status') {
    $id = intval($_GET['id']);
    
    $stmt = $koneksi->prepare("SELECT status FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($currentStatus);
    $stmt->fetch();
    $stmt->close();

    $currentStatus = strtolower($currentStatus);
    $newStatus = ($currentStatus === 'active') ? 'Non-active' : 'Active';

    $stmt = $koneksi->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $id);
    if ($stmt->execute()) {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Status changed successfully',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    document.location.href = 'role.php';
                });
            }
            </script>";
    } else {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Status failed changed successfully',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        </script>";
    }
    $stmt->close();
}

$query  = "SELECT * FROM users";
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
    <title>BKI - Role</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- Favicons -->
    <link href="../../assets/img/logo.png" rel="icon">

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <!-- END: Page CSS-->

    <style>
        .btn-primary {
            background: linear-gradient(135deg, #AFC8AD, #88AB8E);
            color: #FFF;
            border: none;
            padding: 12px 24px;
            text-decoration: none;
        }
        .image-preview {
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 100%;
            height: auto;
        }
        .image-preview:hover {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
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
                        <a class="dropdown-item" href="#" onclick="confirmBreak(); return false;"><i class="me-50" data-feather="battery-charging"></i> Break</a>
                        <a class="dropdown-item" href="#" onclick="confirmLogout(); return false;"><i class="me-50" data-feather="power"></i> Logout</a>
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
                        <h2 class="brand-text" style="font-size: 20px;">BKI</h2>
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
                    <li class="active nav-item"><a class="d-flex align-items-center" href="role.php"><i data-feather="user-plus"></i><span class="menu-title text-truncate" data-i18n="Role ">Role </span></a>
                    </li>
                    <br>
                    <li class="nav-item"><a class="d-flex align-items-center" href="feedback.php"><i data-feather="mail"></i><span class="menu-title text-truncate" data-i18n="Feedback ">Feedback </span></a>
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
                            <h2 class="float-start mb-0">Employee Role</h2>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row" id="table-hover-animation">
                    <div class="col-12">
                        <?php if (is_superadmin()): ?>
                        <a href="add_role.php" class="btn btn-primary">Add Data</a>
                        <?php endif; ?>
                        <br>
                        <br>
                        <div class="card">
                        <div class="card-header d-flex justify-content-between">
    <div>
        <label for="entriesSelect">Show</label>
        <select id="entriesSelect" class="form-control" style="width: auto; display: inline-block;">
            <option value="1">1</option>
            <option value="3">3</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <label for="entriesSelect">entries</label>
    </div>
    <div>
        <input type="text" id="searchInput" placeholder="Search..." class="form-control search-input" style="width: 220px;" onkeyup="searchTable()">
    </div>
</div>
                            <div class="table-responsive">
                                <table class="table table-hover-animation" style="min-width: 1500px;">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>No.</th>
                                            <th>Image</th>
                                            <th>NUP</th>
                                            <th>Nama</th>
                                            <th>Divisi</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody" style="text-align: center;">
                                        <?php 
                                        $i = 1;
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td>
                                                        <a href="img/<?php echo $row['image']; ?>" data-lightbox="profile-image">
                                                            <img src="img/<?php echo $row['image']; ?>" class="image-preview" alt="User Image" width="125" />
                                                        </a>
                                                    </td>
                                                    <td><?php echo $row['nup']; ?></td>
                                                    <td><?php echo $row['nama']; ?></td>
                                                    <td><?php echo $row['divisi']; ?></td>
                                                    <td><?php echo $row['username']; ?></td>
                                                    <td><?php echo $row['role']; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row['status'] == 'Active') {
                                                            echo '<span class="badge bg-success">Active</span>';
                                                        } else if ($row['status'] == 'Non-active') {
                                                            echo '<span class="badge bg-danger">Non-active</span>';
                                                        } else {
                                                            echo '<span class="badge bg-secondary">Unknown</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                    <?php if (is_superadmin()): ?>
                                                        <a href="edit_role.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary_4">Edit</a>
                                                        <a href="#" class="btn btn-sm btn-warning" onclick="confirmChangeStatus(<?php echo $row['id']; ?>, '<?php echo strtolower($row['status']); ?>'); return false;">
                                                            Change Status
                                                        </a>
                                                        <?php endif; ?>
                                                        <?php if (is_superadmin() || is_admin()): ?>
                                                        <a href="#" class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $row['id']; ?>); return false;">Delete</a>
                                                            <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div id="tableFooter" class="d-flex justify-content-between">
                                    <div id="entriesInfo"></div>
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
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    text: "Deleting this user will remove all associated data. Are you sure you want to proceed?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'role.php?id=' + id + '&action=delete';
                    }
                });
            }
        });
    }

    function confirmChangeStatus(id, currentStatus) {
        let newStatus = (currentStatus === 'active') ? 'Non-active' : 'Active';
        Swal.fire({
            title: 'Change Status',
            text: "Are you sure you want to change status to " + newStatus + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'role.php?id=' + id + '&action=change_status';
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
            updateTableEntries();
        }

        let currentPage = 1;
    let entriesPerPage = parseInt(document.getElementById('entriesSelect').value);

    function paginateTable() {
        const table = document.querySelector(".table-hover-animation");
        const tr = table.getElementsByTagName("tr");
        const totalEntries = tr.length - 1; 
        const totalPages = Math.ceil(totalEntries / entriesPerPage);

        for (let i = 1; i < tr.length; i++) {
            tr[i].style.display = "none";
        }
        const start = (currentPage - 1) * entriesPerPage + 1;
        const end = Math.min(start + entriesPerPage - 1, totalEntries);
        for (let i = start; i <= end; i++) {
            tr[i].style.display = "";
        }

        document.getElementById('pageInfo').textContent = `Page ${currentPage} of ${totalPages}`;

        document.getElementById('prevPage').disabled = currentPage === 1;
        document.getElementById('nextPage').disabled = currentPage === totalPages;

        updateTableEntries();
    }

    function updateTableEntries() {
        const table = document.querySelector(".table-hover-animation");
        const tr = table.getElementsByTagName("tr");
        const totalEntries = tr.length - 1;
        const showingEntries = Math.min(entriesPerPage, totalEntries - (currentPage - 1) * entriesPerPage);

        const startEntry = totalEntries > 0 ? (currentPage - 1) * entriesPerPage + 1 : 0;
        const endEntry = startEntry + showingEntries - 1;

        document.getElementById('entriesInfo').textContent = `Showing ${startEntry} to ${endEntry} of ${totalEntries} entries`;
    }

    document.getElementById('entriesSelect').addEventListener('change', function() {
        entriesPerPage = parseInt(this.value);
        currentPage = 1; 
        paginateTable();
    });

    document.getElementById('prevPage').addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            paginateTable();
        }
    });

    document.getElementById('nextPage').addEventListener('click', function() {
        const table = document.querySelector(".table-hover-animation");
        const totalEntries = table.getElementsByTagName("tr").length - 1;
        const totalPages = Math.ceil(totalEntries / entriesPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            paginateTable();
        }
    });

    paginateTable();
    </script>


</body>
</html>