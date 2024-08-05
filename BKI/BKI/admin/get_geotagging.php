<?php
session_start();
include("koneksi.php");

$query = "
SELECT p.id, p.tanggal, p.time_login, p.time_logout, p.geotagging, 
    u.nup, u.nama, u.divisi
FROM time p
JOIN users u ON p.user_id = u.id
WHERE u.status = 'active'
";
$result = mysqli_query($koneksi, $query);

$i = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $time_logout_display = $row['time_logout'] ? htmlspecialchars($row['time_logout']) : date('H:i:s');
        echo "
        <tr>
            <td>{$i}</td>
            <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
            <td>" . htmlspecialchars($row['nup'] ?? '') . "</td>
            <td>" . htmlspecialchars($row['nama'] ?? '') . "</td>
            <td>" . htmlspecialchars($row['divisi'] ?? '') . "</td>
            <td>" . htmlspecialchars($row['time_login'] ?? '') . "</td>
            <td id='logout-time-{$row['id']}' class='" . ($row['time_logout'] ? 'inactive' : 'active') . "'>" . htmlspecialchars($time_logout_display) . "</td>
            <td>" . htmlspecialchars($row['geotagging'] ?? '') . "</td>
        </tr>
        ";
        $i++;
    }
}
?>