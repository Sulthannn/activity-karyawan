<?php
session_start();
include("koneksi.php");

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['latitude']) && isset($data['longitude'])) {
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $geotagging = $latitude . ',' . $longitude;

        $check_query = "SELECT geotagging FROM time WHERE user_id = $user_id AND DATE(tanggal) = CURDATE() AND time_logout IS NULL";
        $check_result = mysqli_query($koneksi, $check_query);
        $row = mysqli_fetch_assoc($check_result);

        if (empty($row['geotagging'])) {
            $update_query = "UPDATE time SET geotagging = '$geotagging' WHERE user_id = $user_id AND DATE(tanggal) = CURDATE() AND time_logout IS NULL";
            $result = mysqli_query($koneksi, $update_query);

            if ($result) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan geotagging']);
            }
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Geotagging sudah ada']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data lokasi tidak lengkap']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User tidak terautentikasi']);
}
?>