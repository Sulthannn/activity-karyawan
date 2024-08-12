<?php
session_start();
include("koneksi.php");

date_default_timezone_set('Asia/Jakarta');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $tanggal = date('Y-m-d');
    $current_time = date('H:i:s');
    
    // Cek apakah sudah ada record untuk hari ini
    $check_query = "SELECT * FROM time WHERE user_id = $user_id AND tanggal = '$tanggal'";
    $check_result = mysqli_query($koneksi, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $row = mysqli_fetch_assoc($check_result);
        if ($row['is_break'] == false) {
            $update_query = "UPDATE time SET before_break = '$current_time', is_break = true WHERE user_id = $user_id AND tanggal = '$tanggal'";
        } else {
            $update_query = "UPDATE time SET after_break = '$current_time', is_break = false WHERE user_id = $user_id AND tanggal = '$tanggal'";
        }
        mysqli_query($koneksi, $update_query);
    } else {
        $insert_query = "INSERT INTO time (tanggal, user_id, time_login, before_break, after_break, time_logout, geotagging, is_break) VALUES ('$tanggal', $user_id, '00:00:00', '$current_time', '00:00:00', '00:00:00', '', true)";
        mysqli_query($koneksi, $insert_query);
    }
    
    session_destroy();
    header("Location: ../index.php");
    exit;
}
?>