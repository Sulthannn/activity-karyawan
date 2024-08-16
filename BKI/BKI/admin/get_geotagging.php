<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("location: Halaman_login.php");
        exit;
    }

    $nama = $_SESSION['nama'];
    $role = $_SESSION['role'];
    $image = $_SESSION['image'];

    include("koneksi.php");

    $query = "
    SELECT p.id, p.tanggal, p.time_login, p.before_break, p.after_break, p.time_logout, p.geotagging, 
        u.nup, u.nama, u.divisi
    FROM time p
    JOIN users u ON p.user_id = u.id
    WHERE u.status = 'active'
    ";

    if (is_user()) {
        $query .= " AND u.nama = '$nama'";
    }

    $result = mysqli_query($koneksi, $query);

    function is_superadmin() {
        return $_SESSION['role'] === 'Super-Admin';
    }

    function is_admin() {
        return $_SESSION['role'] === 'Admin';
    }

    function is_user() {
        return $_SESSION['role'] === 'User';
    }

    date_default_timezone_set('Asia/Jakarta');
    $current_time = date('H:i:s');

    $i = 1;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $time_logout_display = $row['time_logout'] ? htmlspecialchars($row['time_logout']) : date('H:i:s');
            $geotagging = htmlspecialchars($row['geotagging'] ?? ''); 
            $geotagging_array = explode(',', $geotagging);
            $latitude = $geotagging_array[0] ?? '';
            $longitude = $geotagging_array[1] ?? '';
            echo "
            <tr>
                <td>{$i}</td>
                <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
                <td>" . htmlspecialchars($row['nup'] ?? '') . "</td>
                <td>" . htmlspecialchars($row['nama'] ?? '') . "</td>
                <td>" . htmlspecialchars($row['divisi'] ?? '') . "</td>
                <td>" . htmlspecialchars($row['time_login'] ?? '') . "</td>
                <td>" . htmlspecialchars($row['before_break'] ?? '') . "</td>
                <td>" . htmlspecialchars($row['after_break'] ?? '') . "</td>
                <td id='logout-time-{$row['id']}' class='" . ($row['time_logout'] ? 'inactive' : 'active') . "'>" . htmlspecialchars($time_logout_display) . "</td>
                <td>
                    
                    <a href='#' class='geotagging-link' data-bs-toggle='modal' data-bs-target='#mapModal' data-lat='{$latitude}' data-lng='{$longitude}' style='margin-left: 10px;'>
                        <i class='fa fa-map-location'></i>
                    </a>
                </td>
            </tr>
            ";
            $i++;
        }
    }
?>