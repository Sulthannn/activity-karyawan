<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: Halaman_login.php");      
        exit;
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

    $query_all_planning = "SELECT COUNT(*) as total_all_planning FROM planning";
    $query_planning = "SELECT COUNT(*) as total_planning FROM planning WHERE status = 'On-progress'";
    $query_avident  = "SELECT COUNT(*) as total_avident FROM planning WHERE status = 'Completed'";

    if ($role == 'User') {
        $userIdQuery = "SELECT id FROM users WHERE username = '{$_SESSION['username']}' LIMIT 1";
        $userIdResult = mysqli_query($koneksi, $userIdQuery);
        $userIdRow = mysqli_fetch_assoc($userIdResult);
        $userId = $userIdRow['id'];

        $query_all_planning .= " WHERE user_id = $userId";
        $query_planning .= " AND user_id = $userId";
        $query_avident  .= " AND user_id = $userId";
    }

    $result_all_planning = mysqli_query($koneksi, $query_all_planning);
    $result_planning = mysqli_query($koneksi, $query_planning);
    $result_avident  = mysqli_query($koneksi, $query_avident);

    if (!$result_all_planning || !$result_planning || !$result_avident) {
        echo "Error: " . mysqli_error($koneksi);
        exit;
    }

    $data_all_planning = mysqli_fetch_assoc($result_all_planning);
    $data_planning = mysqli_fetch_assoc($result_planning);
    $data_avident  = mysqli_fetch_assoc($result_avident);

    $query_division_completed = "
        SELECT u.divisi, COUNT(*) as total_completed 
        FROM planning p 
        JOIN users u ON p.user_id = u.id 
        WHERE p.status = 'Completed' 
        GROUP BY u.divisi 
        ORDER BY total_completed DESC
    ";

    $result_division_completed = mysqli_query($koneksi, $query_division_completed);

    $divisi = [];
    $total_completed = [];
    $total_all_completed = 0;

    while ($row = mysqli_fetch_assoc($result_division_completed)) {
        $divisi[] = $row['divisi'];
        $total_completed[] = $row['total_completed'];
        $total_all_completed += $row['total_completed'];
    }

    $percentages = array_map(function($count) use ($total_all_completed) {
        return $total_all_completed > 0 ? ($count / $total_all_completed) * 100 : 0;
    }, $total_completed);

    $divisi_json = json_encode($divisi);
    $percentages_json = json_encode($percentages);

    
    $search_name = isset($_POST['name']) ? $_POST['name'] : '';

    $query = "
        SELECT p.status, COUNT(*) as total 
        FROM planning p 
        JOIN users u 
        ON p.user_id = u.id 
        WHERE 1 = 1";

    if ($search_name) {
        $search_name = mysqli_real_escape_string($koneksi, $search_name); // Sanitasi input
        $query .= " AND u.nama = '$search_name'";
    }

    $query .= " GROUP BY p.status";

    $result = mysqli_query($koneksi, $query);

    $chart_data = [
        'On-progress' => 0,
        'Completed' => 0
    ];

    while ($row = mysqli_fetch_assoc($result)) {
        if (array_key_exists($row['status'], $chart_data)) {
            $chart_data[$row['status']] = (int) $row['total']; // Pastikan ini adalah angka
        }
    }

    $chart_data_json = json_encode($chart_data);

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
    <link href="img/logo.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
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
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/charts/chart-apex.css">
    <!-- END: Page CSS-->

    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        
    <style>
        .icon-large {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #003285 !important;
        }
        .select2-container--default .select2-selection--single {
            border-color: #CED4DA;
            transition: border-color 0.1s ease;
        }
        .select2-container--default .select2-selection--single.item-selected {
            border-color: #003285 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #333333;
        }
        .select2-container--default .select2-results__option[aria-selected="true"] {
            background: linear-gradient(135deg, #FF7F3E, #FF7F3E);
        }
        .select2-container--default .select2-selection--single .select2-selection__clear,
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            display: none;
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
                                    <div style="font-size: 17px;" class="statistics-title">On-progress</div>
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
            </section>
            <section id="apexchart">
                <div class="row">
                    <!-- Donut Chart Starts-->
                    <div class="col-xl-6 col-12">
                        <div class="card">
                            <div class="card-header flex-column align-items-start">
                                <h4 class="card-title mb-75">Division Chart</h4>
                                <span class="card-subtitle text-muted">Division with the most avident uploads</span>
                            </div>
                            <div class="card-body">
                                <div id="donut-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Donut Chart Ends-->
                    
                    <div class="col-xl-6 col-12">
                        <div class="card">
                            <div class="
                            card-header
                            d-flex
                            flex-sm-row flex-column
                            justify-content-md-between
                            align-items-start
                            justify-content-start
                            ">
                            <div>
                                <h4 class="card-title mb-10">Avident</h4>
                                <span class="card-subtitle text-muted">Displays individual avident performance</span>
                                <div class="d-flex align-items-center mt-md-0 mt-1">
                                <form method="POST" action="" style="position: relative; display: flex; align-items: center;">
                                    <div class="form-group" style="width: 200px;">
                                        <label for="name" class="form-label"></label>
                                        <select class="form-control" id="name" name="name">
                                            <option value=""></option>
                                            <?php
                                            $names_result = mysqli_query($koneksi, "SELECT DISTINCT nama FROM users");
                                            while ($row = mysqli_fetch_assoc($names_result)) {
                                                $selected = ($search_name == $row['nama']) ? 'selected' : '';
                                                echo "<option value=\"{$row['nama']}\" $selected>{$row['nama']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn" style="border: none; background: transparent; cursor: pointer; margin-bottom: -28px; margin-left: -10px;">
                                        <i class="fa fa-search icon-large"></i>
                                    </button>
                                </form>
                            </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="bar-chart"></div>
                        </div>
                    </div>
                </div>
                <!-- Bar Chart Ends -->
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

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="../../../app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->
     
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    
    <script>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success, error,  { enableHighAccuracy: true });
        } else {
            alert("Geolocation tidak didukung oleh browser ini.");
        }

        function success(position) {
            const latitude = position.coords.latitude;
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
    </script>

    <script>
        $(document).ready(function() {
            $('#name').select2({
                placeholder: 'Select User',
                dropdownParent: $('body'),
                minimumInputLength: 1,
                width: '100%',
                containerCssClass: 'select2-container--custom'
            });

        function sortSelectOptions() {
            var $select  = $('#name');
            var $options = $select.find('option');

            $options.sort(function(a, b) {
                return $(a).text().localeCompare($(b).text());
            });

            $select.empty().append($options);
        }

        sortSelectOptions();

        $('#name').on('select2:select', function() {
            $('.select2-selection--single').addClass('item-selected');
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.select2-container').length) {
                $('.select2-selection--single').removeClass('item-selected');
            }
        });

        $('#name').on('select2:open', function() {
            $('.select2-selection--single').removeClass('item-selected');
        });
    });
    </script>

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
        
        $(function () {
            'use strict';
            
            var flatPicker = $('.flat-picker'),
            isRtl = $('html').attr('data-textdirection') === 'rtl',
            chartColors = {
                column: {
                    series1: '#826af9',
                    series2: '#d2b0ff',
                    bg: '#f8d3ff'
                },
                success: {
                    shade_100: '#7eefc7',
                    shade_200: '#06774f'
                },
                donut: {
                    series1: '#ffe700',
                    series2: '#00d4bd',
                    series3: '#826bf8',
                    series4: '#2b9bf4',
                    series5: '#FFA1A1'
                },
                area: {
                    series3: '#a4f8cd',
                    series2: '#60f2ca',
                    series1: '#2bdac7'
                }
            };


        // Donut Chart
        var donutChartEl = document.querySelector('#donut-chart'),
        donutChartConfig = {
            chart: {
                height: 350,
                type: 'donut'
            },
            legend: {
                show: true,
                position: 'bottom'
            },
            labels: <?php echo $divisi_json; ?>,
            series: <?php echo $percentages_json; ?>,
            colors: [
                    '#5398D9',
                    '#2A629A',
                    '#FF7F3E',
                    '#FFDA78',
                    '#F05837' 
                ],
            dataLabels: {
                enabled: true,
                formatter: function (val, opt) {
                    return Math.round(val) + '%';
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            name: {
                                fontSize: '2rem',
                                fontFamily: 'Montserrat'
                            },
                            value: {
                                fontSize: '1rem',
                                fontFamily: 'Montserrat',
                                formatter: function (val) {
                                    return Math.round(val) + '%';
                                }
                            },
                            total: {
                                show: true,
                                fontSize: '1.5rem',
                                label: 'Total',
                                formatter: function (w) {
                                    let totalPercentage = w.config.series.reduce((a, b) => a + b, 0);
                                    return Math.round(totalPercentage) + '%';
                                }
                            }
                        }
                    }
                }
            },
            responsive: [
                {
                    breakpoint: 992,
                    options: {
                        chart: {
                            height: 380
                        }
                    }
                },
                {
                    breakpoint: 576,
                    options: {
                        chart: {
                            height: 320
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    labels: {
                                        show: true,
                                        name: {
                                            fontSize: '1.5rem'
                                        },
                                        value: {
                                            fontSize: '1rem'
                                        },
                                        total: {
                                            fontSize: '1.5rem'
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            ]
        };
        
        if (typeof donutChartEl !== 'undefined' && donutChartEl !== null) {
            var donutChart = new ApexCharts(donutChartEl, donutChartConfig);
            donutChart.render();
        }
    });


        // Bar Chart
        const chartData = <?php echo $chart_data_json; ?>;

        const categories = Object.keys(chartData);
        const seriesData = Object.values(chartData);

        console.log('Categories:', categories); // Debugging
        console.log('Series Data:', seriesData); // Debugging

        var barChartEl = document.querySelector('#bar-chart');
        var barChartConfig = {
            chart: {
                height: 265,
                type: 'bar',
                parentHeightOffset: 0,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: '20%',
                    endingShape: 'rounded'
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                padding: {
                    top: -15,
                    bottom: -10
                }
            },
            colors: [
                    '#2A629A'
                ],
            dataLabels: {
                enabled: false
            },
            series: [
                {
                    name: 'Activities',
                    data: seriesData
                }
            ],
            xaxis: {
                categories: categories,
                labels: {
                    formatter: function (value) {
                        return value; // Format tanpa desimal
                    }
                }
            },
            yaxis: {
                opposite: false,
                labels: {
                    formatter: function (value) {
                        return value; // Format tanpa desimal
                    }
                }
            }
        };

        if (typeof barChartEl !== 'undefined' && barChartEl !== null) {
            var barChart = new ApexCharts(barChartEl, barChartConfig);
            barChart.render();
        }
    </script>

</body>
</html>