<?php
session_start();
include("koneksi.php");

date_default_timezone_set('Asia/Jakarta');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $tanggal = date('Y-m-d');
    $time_logout = date('H:i:s');
    
    // Cek apakah sudah ada record untuk hari ini
    $check_query = "SELECT * FROM time WHERE user_id = $user_id AND tanggal = '$tanggal'";
    $check_result = mysqli_query($koneksi, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $update_query = "UPDATE time SET time_logout = '$time_logout' WHERE user_id = $user_id AND tanggal = '$tanggal'";
        mysqli_query($koneksi, $update_query);
    } else {
        $insert_query = "INSERT INTO time (tanggal, user_id, time_login, time_logout, geotagging) VALUES ('$tanggal', $user_id, '00:00:00', '$time_logout', '')";
        mysqli_query($koneksi, $insert_query);
    }
}

session_destroy();
header("Location: ../index.php");
?>