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
        $_SESSION['role'] = $row['role'];

        $user_id = $_SESSION['user_id'];
        $tanggal = date('Y-m-d');
        $time_login = date('H:i:s');

        $insert_query = "INSERT INTO time (tanggal, user_id, time_login, geotagging) VALUES ('$tanggal', $user_id, '$time_login', '')";
        mysqli_query($koneksi, $insert_query);
        header("Location: dashboard.php");
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