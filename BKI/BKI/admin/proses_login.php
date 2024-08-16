<?php
    session_start();
    include("koneksi.php");

    date_default_timezone_set('Asia/Jakarta');

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' AND password = md5('$password')";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($row['status'] === 'Active') {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['roles'] = explode(', ', $row['role']);
            $_SESSION['image'] = $row['image'];
            
            $user_id = $_SESSION['user_id'];
            $tanggal = date('Y-m-d');
            $time_login = date('H:i:s');

            if (isset($_POST['role']) && $_POST['role'] === 'User') {
                $check_query = "SELECT * FROM time WHERE user_id = $user_id AND tanggal = '$tanggal'";
                $check_result = mysqli_query($koneksi, $check_query);
            
                if (mysqli_num_rows($check_result) > 0) {
                    $row = mysqli_fetch_assoc($check_result);
                    if ($row['is_break'] == true) {
                        $update_query = "UPDATE time SET after_break = '$time_login', is_break = false WHERE user_id = $user_id AND tanggal = '$tanggal'";
                        mysqli_query($koneksi, $update_query);

                        echo "<!DOCTYPE html>
                                <html lang='en'>
                                <head>
                                    <meta charset='UTF-8'>
                                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                    <title>Welcome Back</title>
                                    <link href='img/logo.png' rel='icon'>
                                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                </head>
                                <body>
                                    <script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Happy return to activity!',
                                            text: 'You are back from the break.',
                                            backdrop: true,
                                            confirmButtonText: 'OK'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = 'dashboard.php';
                                            }
                                        });
                                    </script>
                                </body>
                                </html>";
                        exit;
                    }
                } else {
                    $insert_query = "INSERT INTO time (tanggal, user_id, time_login, geotagging) VALUES ('$tanggal', $user_id, '$time_login', '')";
                    mysqli_query($koneksi, $insert_query);
                    $_SESSION['first_login'] = true;
                }
            } elseif (isset($_POST['role']) && $_POST['role'] === 'Super-Admin') {
                $_SESSION['first_login'] = false;
            }

            if (count($_SESSION['roles']) > 1) {
                header("Location: pilih_role.php");
            } else {
                $_SESSION['role'] = $_SESSION['roles'][0];
                header("Location: dashboard.php");
            }
            exit;
        } else {
            header("Location: Halaman_login.php?error=inactive");
            exit;
        }
    } else {
        header("Location: Halaman_login.php?error=invalid");
        exit;
    }
?>