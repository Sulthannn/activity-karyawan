<?php
session_start();
include("koneksi.php");

date_default_timezone_set('Asia/Jakarta');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $tanggal = date('Y-m-d');
    $time_logout = date('H:i:s');
    
    $update_query = "UPDATE time SET time_logout = '$time_logout' WHERE user_id = $user_id AND tanggal = '$tanggal' AND time_logout IS NULL";
    mysqli_query($koneksi, $update_query);
}
session_destroy();
header("Location: ../index.php");
?>