<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("location: Halaman_login.php");
        exit;
    }

    $nama  = $_SESSION['nama'];
    $role  = $_SESSION['role'];
    $image = $_SESSION['image'];

    function is_user() {
        return $_SESSION['role'] === 'User';
    }

    function is_superadmin() {
        return $_SESSION['role'] === 'Super-Admin';
    }

    function is_admin() {
        return $_SESSION['role'] === 'Admin';
    }

    include("koneksi.php");

    $selected_month = date('m'); 
    $selected_year  = date('Y');

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
        $selected_month = htmlspecialchars($_GET['month']);
        $selected_year  = htmlspecialchars($_GET['year']);
    }

    $query = "
        SELECT p.id, p.tanggal, p.time_login, p.before_break, p.after_break, p.time_logout, p.geotagging, 
            u.nup, u.nama, u.divisi
        FROM time p
        JOIN users u ON p.user_id = u.id
        WHERE u.status = 'active' 
        AND MONTH(p.tanggal) = '$selected_month' 
        AND YEAR(p.tanggal) = '$selected_year'
    ";

    if (is_user()) {
        $query .= " AND u.nama = '$nama'";
    }

    $query .= " ORDER BY p.tanggal DESC";

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
    <title>BKI - Time</title>
    <link href="../../assets/img/logo.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- Favicons -->
    <link href="img/logo.png" rel="icon">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

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
        .active {
            color: green;
        }
        .inactive {
            color: red;
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
                            <li class="active"><a class="d-flex align-items-center" href="time.php"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Employee Time">Time</span></a>
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
                            <h2 class="float-start mb-0">Employee Time</h2>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row" id="table-hover-animation">
                    <div class="col-12">
                        <div class="d-flex justify-content-end align-items-center mb-1">
                        <!-- <a href="add_avident.php" class="btn btn-primary">Add Data</a> -->
                            <form method="get" action="time.php" class="d-flex">
                                <div class="me-2">
                                    <label for="month" class="form-label d-none">Month</label>
                                    <select id="month" name="month" class="form-select">
                                        <?php for ($m = 1; $m <= 12; $m++): ?>
                                            <option value="<?php echo str_pad($m, 2, '0', STR_PAD_LEFT); ?>" <?php echo str_pad($m, 2, '0', STR_PAD_LEFT) == $selected_month ? 'selected' : ''; ?>>
                                                <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="me-2">
                                    <label for="year" class="form-label d-none">Year</label>
                                    <select id="year" name="year" class="form-select">
                                        <?php for ($y = date('Y'); $y >= 2000; $y--): ?>
                                            <option value="<?php echo $y; ?>" <?php echo $y == $selected_year ? 'selected' : ''; ?>>
                                                <?php echo $y; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <button type="submit" name="search" class="btn btn-primary">Search</button>
                            </form>
                        </div>
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
                            <div class="table-responsive">
                            <table class="table table-hover-animation" style="min-width: 2000px;">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th style="min-width: 50px;">No.</th>
                                            <th style="min-width: 50px;">Date</th>
                                            <th style="min-width: 200px;">NUP</th>
                                            <th style="min-width: 350px;">Name</th>
                                            <th style="min-width: 150px;">Division</th>
                                            <th style="min-width: 100px;">Login Time</th>
                                            <th style="min-width: 100px;">Before Break</th>
                                            <th style="min-width: 100px;">After Break</th>
                                            <th style="min-width: 100px;">Logout Time</th>
                                            <th style="min-width: 100px;">Geotagging</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody" style="text-align: center;">
                                        <?php 
                                            $i = 1;
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $time_logout_display = $row['time_logout'] ? htmlspecialchars($row['time_logout']) : $current_time;
                                                    $geotagging = htmlspecialchars($row['geotagging'] ?? '');
                                                    $geotagging_array = explode(',', $geotagging);
                                                    $latitude = $geotagging_array[0] ?? '';
                                                    $longitude = $geotagging_array[1] ?? '';
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                                <td><?php echo htmlspecialchars($row['nup'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($row['nama'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($row['divisi'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($row['time_login'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($row['before_break'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($row['after_break'] ?? ''); ?></td>
                                                <td id="logout-time-<?php echo $row['id']; ?>" class="<?php echo $row['time_logout'] ? 'inactive' : 'active'; ?>">
                                                    <?php echo htmlspecialchars($time_logout_display); ?>
                                                </td>
                                                <td>
                                                    <a href='#' class='geotagging-link' data-bs-toggle='modal' data-bs-target='#mapModal' data-lat='<?php echo $latitude; ?>' data-lng='<?php echo $longitude; ?>' style='margin-left: 10px;'>
                                                        <i class='fa fa-map-location'></i> 
                                                    </a>
                                                </td>
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
                    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mapModalLabel">Map</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="map" style="height: 500px;"></div>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://kit.fontawesome.com/9273de0686.js" crossorigin="anonymous"></script>   
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
            input  = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table  = document.querySelector(".table-hover-animation");
            tr     = table.getElementsByTagName("tr");

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

        //Time
        function formatTime(date) {
            let hours   = date.getHours();
            let minutes = date.getMinutes();
            let seconds = date.getSeconds();
            hours   = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;
            return hours + ':' + minutes + ':' + seconds;
        }

        function updateLogoutTimes() {
            document.querySelectorAll('[id^="logout-time-"]').forEach(function (element) {
                if (element.classList.contains('active')) {
                    let currentTime   = new Date();
                    element.innerText = formatTime(currentTime);
                }
            });
        }

        updateLogoutTimes();
        setInterval(updateLogoutTimes, 1000);

        //Geotagging
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success, error,  { enableHighAccuracy: true });
        } else {
            alert("Geolocation tidak didukung oleh browser ini.");
        }

        function success(position) {
            const latitude  = position.coords.latitude;
            const longitude = position.coords.longitude;

            fetch('simpan_geotagging.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    latitude: latitude,
                    longitude: longitude
                })
            }).then(response => response.json())
            .then(data => {
                if(data.status == 'success') {
                    console.log('Geolocation berhasil disimpan');
                    getGeotaggingData();
                } else {
                    console.log('Geolocation gagal disimpan');
                }
            });
        }

        function error() {
            alert("Tidak dapat mengakses lokasi Anda.");
        }

        function getGeotaggingData() {
            $.ajax({
                url: 'get_geotagging.php',
                method: 'GET',
                success: function(data) {
                    $('tbody').html(data);
                }
            });
        }

        setInterval(getGeotaggingData, 5000);
        
        $(document).ready(function() {
            getGeotaggingData();
        });

        // Map
        $(document).ready(function() {
            var map;
            var marker;
            $('#mapModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var lat = button.data('lat');
                var lng = button.data('lng');
                
                setTimeout(function() {
                    if (map) {
                        map.remove();
                    }
                    map = L.map('map').setView([lat, lng], 15);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                    }).addTo(map);

                    marker = L.marker([lat, lng]).addTo(map)
                        .bindPopup('Coordinates: ' + lat + ', ' + lng)
                        .openPopup()

                    .addTo(map);

                    var distance = map.distance([lat, lng]);
                    $(`.geotagging-link[data-lat='${lat}'][data-lng='${lng}']`).closest('td').html(`
                        <a href="#" class="geotagging-link" data-bs-toggle="modal" data-bs-target="#mapModal" data-lat="${lat}" data-lng="${lng}" style="margin-left: 10px;">
                            <i class="fa fa-map-location"></i>
                        </a>
                    `);
                }, 300);
            });
        });

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
                cancelButtonText: 'Cancel',
                backdrop: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'break.php';
                }
            });
        }
    </script>

</body>
</html>