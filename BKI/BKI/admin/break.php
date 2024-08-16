<?php
session_start();
include("koneksi.php");

date_default_timezone_set('Asia/Jakarta');

if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'User') {
    $user_id = $_SESSION['user_id'];
    $tanggal = date('Y-m-d');
    $current_time = date('H:i:s');
    
    $check_query  = "SELECT * FROM time WHERE user_id = $user_id AND tanggal = '$tanggal'";
    $check_result = mysqli_query($koneksi, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $row = mysqli_fetch_assoc($check_result);
        if ($row['is_break'] == false && empty($row['before_break'])) {
            $update_query = "UPDATE time SET before_break = '$current_time', is_break = true WHERE user_id = $user_id AND tanggal = '$tanggal'";
            if (mysqli_query($koneksi, $update_query)) {
                echo "<!DOCTYPE html>
                        <html lang='en'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <title>Break Alert</title>
                            <link href='img/logo.png' rel='icon'>
                            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                        </head>
                        <body>
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Have a good rest!',
                                    text: 'You have started your break time.',
                                    backdrop: true,
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '../index.php';
                                    }
                                });
                            </script>
                        </body>
                        </html>";
                session_destroy();
                exit;
            }
        } elseif (!empty($row['before_break']) && !empty($row['after_break'])) {
            echo "<!DOCTYPE html>
                    <html lang='en'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Break Alert</title>
                        <link href='img/logo.png' rel='icon'>
                        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    </head>
                    <body>
                        <script>
                            Swal.fire({
                                icon: 'warning',
                                title: 'You have taken a break!',
                                text: 'You have taken a break today.',
                                backdrop: true,
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.history.back();
                                }
                            });
                        </script>
                    </body>
                    </html>";
            exit;
        }
    } else {
        $insert_query = "INSERT INTO time (tanggal, user_id, time_login, before_break, after_break, time_logout, geotagging, is_break) VALUES ('$tanggal', $user_id, '00:00:00', '$current_time', '00:00:00', '00:00:00', '', true)";
        mysqli_query($koneksi, $insert_query);
    }
}

session_destroy();
header("Location: ../index.php");
exit;
?>