<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "bki";

$koneksi = new mysqli($host, $username, $password, $database);
if ($koneksi->connect_error) {
    die("Koneksi Gagal: " . $koneksi->connect_error);
}

function tambah_user($data) {
    global $koneksi;

    $nup = htmlspecialchars($data['nup']);
    $nama = htmlspecialchars($data['nama']);
    $divisi = htmlspecialchars($data['divisi']);
    $username = htmlspecialchars($data['username']);
    $password = md5(htmlspecialchars($data['password']));
    $role = htmlspecialchars($data['role']);
    $status = htmlspecialchars($data['status']);

    $stmt = $koneksi->prepare("INSERT INTO users (nup, nama, divisi, username, password, role, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nup, $nama, $divisi, $username, $password, $role, $status);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

function tambah_time($data) {
    global $koneksi;

    $tanggal = htmlspecialchars($data['tanggal']);
    $user_id = htmlspecialchars($data['user_id']);
    $time_login = htmlspecialchars($data['time_login']);
    $time_logout = htmlspecialchars($data['time_logout']);
    $geotagging = htmlspecialchars($data['geotagging']);

    $stmt = $koneksi->prepare("INSERT INTO time (tanggal, user_id, time_login, time_logout, geotagging) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss", $tanggal, $user_id, $time_login, $time_logout, $geotagging);

    $stmt->execute();
    return $stmt->affected_rows;
}

function tambah_planning($data) {
    global $koneksi;

    $tanggal = $data['tanggal'];
    $user_id = $data['user_id'];
    $deskripsi = $data['deskripsi'];
    $time_upload_activity_planning = $data['time_upload_activity_planning'];
    $status = $data['status'];
    $history_update = $data['history_update'];

    $query = "INSERT INTO planning (tanggal, user_id, deskripsi, time_upload_activity_planning, status, history_update) 
                VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    
    if (!$stmt) {
        die('Prepare failed: ' . $koneksi->error);
    }

    $stmt->bind_param("sissss", $tanggal, $user_id, $deskripsi, $time_upload_activity_planning, $status, $history_update);

    if ($stmt->execute()) {
        return $stmt->affected_rows;
    } else {
        die('Execute failed: ' . $stmt->error);
    }
}

function hapus_user($id) {
    global $koneksi;

    $stmt = $koneksi->prepare("DELETE FROM time WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt = $koneksi->prepare("DELETE FROM planning WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt = $koneksi->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->affected_rows;
}

function hapus_time($id) {
    global $koneksi;

    $stmt = $koneksi->prepare("DELETE FROM time WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

function hapus_planning($id) {
    global $koneksi;

    $stmt = $koneksi->prepare("DELETE FROM planning WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

function update_user($data) {
    global $koneksi;

    $id = $data['id'];
    $nup = htmlspecialchars($data['nup']);
    $nama = htmlspecialchars($data['nama']);
    $divisi = htmlspecialchars($data['divisi']);
    $username = htmlspecialchars($data['username']);
    $password = md5(htmlspecialchars($data['password']));
    $role = htmlspecialchars($data['role']);
    $status = htmlspecialchars($data['status']);

    $stmt = $koneksi->prepare("UPDATE users SET nup=?, nama=?, divisi=?, username=?, password=?, role=?, status=? WHERE id=?");
    $stmt->bind_param("sssssssi", $nup, $nama, $divisi, $username, $password, $role, $status, $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

function update_time($data) {
    global $koneksi;

    $id = $data['id'];
    $tanggal = htmlspecialchars($data['tanggal']);
    $user_id = htmlspecialchars($data['user_id']);
    $time_login = htmlspecialchars($data['time_login']);
    $time_logout = htmlspecialchars($data['time_logout']);
    $geotagging = htmlspecialchars($data['geotagging']);

    $stmt = $koneksi->prepare("UPDATE time SET tanggal=?, user_id=?, time_login=?, time_logout=?, geotagging=? WHERE id=?");
    $stmt->bind_param("sisssi", $tanggal, $user_id, $time_login, $time_logout, $geotagging, $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

function update_planning($data) {
    global $koneksi;

    $id = $data['id'];
    $tanggal = htmlspecialchars($data['tanggal']);
    $user_id = htmlspecialchars($data['user_id']);
    $gambar = $data['gambar'];
    $time_upload_avident = $data['time_upload_avident'];
    $deskripsi = htmlspecialchars($data['deskripsi']);
    $time_upload_activity_planning = htmlspecialchars($data['time_upload_activity_planning']);
    $history_update = htmlspecialchars($data['history_update']);
    $status = htmlspecialchars($data['status']);
    
    $stmt = $koneksi->prepare("SELECT time_upload_activity_planning, time_upload_avident FROM planning WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $existing_times = $result->fetch_assoc();
    $existing_time_upload_activity_planning = $existing_times['time_upload_activity_planning'];
    $existing_time_upload_avident = $existing_times['time_upload_avident'];

    $time_upload_activity_planning = isset($data['time_upload_activity_planning']) ? htmlspecialchars($data['time_upload_activity_planning']) : $existing_time_upload_activity_planning;
    $time_upload_avident = isset($data['time_upload_avident']) ? htmlspecialchars($data['time_upload_avident']) : $existing_time_upload_avident;

    $stmt = $koneksi->prepare("UPDATE planning SET tanggal=?, user_id=?, gambar=?, time_upload_avident=?, deskripsi=?, time_upload_activity_planning=?, history_update=?, status=? WHERE id=?");
    $stmt->bind_param("sissssssi", $tanggal, $user_id, $gambar, $time_upload_avident, $deskripsi, $time_upload_activity_planning, $history_update, $status, $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

function upload_file() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    $extensifileValid = ['jpg', 'jpeg', 'png'];
    $extensifile = explode('.', $namaFile);
    $extensifile = strtolower(end($extensifile));

    if (!in_array($extensifile, $extensifileValid)) {
        echo "<script>alert('Format Tidak Valid');</script>";
        die();
    }

    if ($ukuranFile > 2048000) {
        echo "<script>alert('Ukuran File Max 2 MB');</script>";
        die();
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.' . $extensifile;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}
?>