<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: Halaman_login.php");
    exit;
}

require 'koneksi.php';
require '../../../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $export_date = htmlspecialchars($_POST['export_date']);
    $filename = "planning_export_$export_date.pdf";

    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('BKI');
    $pdf->SetTitle('Planning Export');
    $pdf->SetSubject('Export Planning Data');
    $pdf->SetKeywords('TCPDF, PDF, export, planning');

    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->AddPage('L');

    $html = "
    <h2>Planning Export - $export_date</h2>
    <table border=\"1\" cellpadding=\"4\">
        <thead>
            <tr style='text-align: center;'>
                <th>No.</th>
                <th>Date</th>
                <th>NUP</th>
                <th>Name</th>
                <th>Division</th>
                <th>Description</th>
                <th>Upload Time</th>
                <th>Image Path</th>
                <th>Status</th>
                <th>History</th>
            </tr>
        </thead>
        <tbody>";

    $query = "
        SELECT p.id, p.tanggal, p.deskripsi, p.time_upload_activity_planning, p.status, p.gambar, p.history_update,
            u.nup, u.nama, u.divisi
        FROM planning p
        JOIN users u ON p.user_id = u.id
        WHERE p.tanggal = '$export_date' AND u.status = 'Active'
        ORDER BY p.status DESC, p.time_upload_activity_planning ASC
    ";

    $result = mysqli_query($koneksi, $query);
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $status = !empty($row['gambar']) ? 'Completed' : 'On-progress';
        $deskripsi = htmlspecialchars($row['deskripsi']);
        $gambar = !empty($row['gambar']) ? 'path/to/images/' . implode(',', explode(',', $row['gambar'])) : '';

        $html .= "<tr style='text-align: center;'>
                    <td>$i</td>
                    <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
                    <td>" . htmlspecialchars($row['nup']) . "</td>
                    <td>" . htmlspecialchars($row['nama']) . "</td>
                    <td>" . htmlspecialchars($row['divisi']) . "</td>
                    <td>$deskripsi</td>
                    <td>" . htmlspecialchars($row['time_upload_activity_planning']) . "</td>
                    <td>$gambar</td>
                    <td>$status</td>
                    <td>" . htmlspecialchars($row['history_update']) . "</td>
                </tr>";
        $i++;
    }

    $html .= "</tbody></table>";

    // Tambahkan HTML ke PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output PDF
    $pdf->Output($filename, 'D');

    exit;
}
?>