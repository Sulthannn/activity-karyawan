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

        $check_query = "SELECT * FROM time WHERE user_id = $user_id AND tanggal = '$tanggal'";
        $check_result = mysqli_query($koneksi, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $row = mysqli_fetch_assoc($check_result);
            if ($row['is_break'] == true) {
                $update_query = "UPDATE time SET after_break = '$time_login', is_break = false WHERE user_id = $user_id AND tanggal = '$tanggal'";
                mysqli_query($koneksi, $update_query);
            }
        } else {
            $insert_query = "INSERT INTO time (tanggal, user_id, time_login, geotagging) VALUES ('$tanggal', $user_id, '$time_login', '')";
            mysqli_query($koneksi, $insert_query);

            $_SESSION['first_login'] = true;
        }

        if (isset($_SESSION['first_login']) && $_SESSION['first_login']) {
            $batas_waktu = strtotime('00:05:00');
            $waktu_login = strtotime($time_login);
            
            if ($waktu_login > $batas_waktu) {
                $_SESSION['telat'] = true;
                $selisih = $waktu_login - $batas_waktu;
                $menit_telat = floor($selisih / 60);
                $jam_telat = floor($menit_telat / 60);
                $sisa_menit_telat = $menit_telat % 60;
                $detik_telat = $selisih % 60;
            
                if ($jam_telat > 0) {
                    $_SESSION['telat_waktu'] = "$jam_telat hours $sisa_menit_telat minutes $detik_telat seconds late!";
                } elseif ($sisa_menit_telat > 0) {
                    $_SESSION['telat_waktu'] = "$sisa_menit_telat minutes $detik_telat seconds late!";
                } else {
                    $_SESSION['telat_waktu'] = "$detik_telat seconds late!";
                }
            } else {
                $_SESSION['telat'] = false;
            }

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