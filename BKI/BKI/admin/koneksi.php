<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "bki";

$koneksi = new mysqli($host, $username, $password, $database);
if ($koneksi->connect_error) {
    die("Koneksi Gagal: " . $koneksi->connect_error);
}

function feedback($data) {
    global $koneksi;

    $name    = htmlspecialchars(trim($data['name']));
    $email   = htmlspecialchars(trim($data['email']));
    $subject = htmlspecialchars(trim($data['subject']));
    $message = htmlspecialchars(trim($data['message']));

    $stmt = $koneksi->prepare("INSERT INTO feedback (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    $stmt->execute();
    return $stmt->affected_rows;
}

function tambah_user($data) {
    global $koneksi;

    $nup = htmlspecialchars($data['nup']);
    $nama = htmlspecialchars($data['nama']);
    $divisi = htmlspecialchars($data['divisi']);
    $username = htmlspecialchars($data['username']);
    $password = md5(htmlspecialchars($data['password']));
    $status = htmlspecialchars($data['status']);
    $image = upload_file();

    $nup_prefix = substr($nup, 0, 3);
    if ($nup_prefix == '190') {
        $role = 'Super-Admin, User';
    } elseif ($nup_prefix == '180') {
        $role = 'Admin, User';
    } elseif ($nup_prefix == '170') {
        $role = 'Super-Admin';
    } elseif ($nup_prefix == '160') {
        $role = 'Admin';
    } elseif ($nup_prefix == '150') {
        $role = 'User';
    } else {
        $role = 'User';
    }

    $stmt = $koneksi->prepare("INSERT INTO users (nup, nama, divisi, username, password, role, status, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nup, $nama, $divisi, $username, $password, $role, $status, $image);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

function tambah_time($data) {
    global $koneksi;

    $tanggal = htmlspecialchars($data['tanggal']);
    $user_id = htmlspecialchars($data['user_id']);
    $time_login = htmlspecialchars($data['time_login']);
    $before_break = htmlspecialchars($data['before_break']);
    $after_break = htmlspecialchars($data['after_break']);
    $time_logout = htmlspecialchars($data['time_logout']);
    $geotagging = htmlspecialchars($data['geotagging']);

    $stmt = $koneksi->prepare("INSERT INTO time (tanggal, user_id, time_login, before_break, after_break, time_logout, geotagging) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssss", $tanggal, $user_id, $time_login, $before_break, $after_break, $time_logout, $geotagging);

    $stmt->execute();
    return $stmt->affected_rows;
}

function tambah_planning($data) {
    global $koneksi;

    $tanggal = $data['tanggal'];
    $user_id = $data['user_id'];
    $deskripsi = $data['deskripsi'];
    $gambar = $data['gambar'];
    $time_upload_activity_planning = $data['time_upload_activity_planning'];
    $status = $data['status'];
    $history_update = 0;

     // Jika gambar ada, set status dan increment history_update
     if (!empty($gambar)) {
        $status = 'Completed';
        $history_update = 1; // Set history_update to 1 when an image is uploaded
    } else {
        $status = 'On-progress';
    }
    
    $query = "INSERT INTO planning (tanggal, user_id, deskripsi, gambar, time_upload_activity_planning, status, history_update)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    
    if (!$stmt) {
        die('Prepare failed: ' . $koneksi->error);
    }

    $stmt->bind_param("sissssi", $tanggal, $user_id, $deskripsi, $gambar, $time_upload_activity_planning, $status, $history_update);
    
    if ($stmt->execute()) {
        return $stmt->affected_rows;
    } else {
        die('Execute failed: ' . $stmt->error);
    }
}

function hapus_feedback($id) {
    global $koneksi;

    $stmt = $koneksi->prepare("DELETE FROM feedback WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

function hapus_user($id) {
    global $koneksi;

    $stmt = $koneksi->prepare("SELECT image FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row['image']) {
        unlink('img/' . $row['image']);
    }

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

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $stmt = $koneksi->prepare("SELECT image FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row['image']) {
            unlink('img/' . $row['image']);
        }

        $image = upload_file();
        $stmt = $koneksi->prepare("UPDATE users SET nup = ?, nama = ?, divisi = ?, username = ?, password = ?, role = ?, status = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $nup, $nama, $divisi, $username, $password, $role, $status, $image, $id);
    } else {
        $stmt = $koneksi->prepare("UPDATE users SET nup = ?, nama = ?, divisi = ?, username = ?, password = ?, role = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $nup, $nama, $divisi, $username, $password, $role, $status, $id);
    }

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
    $gambar = isset($data['gambar']) ? $data['gambar'] : '';
    $time_upload_activity_planning = isset($data['time_upload_activity_planning']) ? htmlspecialchars($data['time_upload_activity_planning']) : '';
    $deskripsi = htmlspecialchars($data['deskripsi']);
    $status = isset($data['status']) ? htmlspecialchars($data['status']) : '';
    $history_update = isset($data['history_update']) ? htmlspecialchars($data['history_update']) : 0;

    $stmt = $koneksi->prepare("SELECT gambar, deskripsi, history_update, time_upload_activity_planning, time_upload_avident FROM planning WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $existing_data = $result->fetch_assoc();
    $existing_time_upload_activity_planning = $existing_data['time_upload_activity_planning'];
    $existing_time_upload_avident = $existing_data['time_upload_avident'];
    $existing_gambar = $existing_data['gambar'];
    $existing_deskripsi = $existing_data['deskripsi'];
    $existing_history_update = $existing_data['history_update'];

    // Compare new description with existing description
    if ($deskripsi != $existing_deskripsi) {
        $history_update = $existing_history_update + 1; // Increment history_update if the description is changed
    } else {
        $history_update = $existing_history_update;
    }

    $time_upload_activity_planning = !empty($time_upload_activity_planning) ? $time_upload_activity_planning : $existing_time_upload_activity_planning;
    $time_upload_avident = isset($data['time_upload_avident']) ? htmlspecialchars($data['time_upload_avident']) : $existing_time_upload_avident;

    $stmt = $koneksi->prepare("UPDATE planning SET tanggal=?, user_id=?, gambar=?, time_upload_avident=?, time_upload_activity_planning=?, deskripsi=?, status=?, history_update=? WHERE id=?");
    $stmt->bind_param("sissssssi", $tanggal, $user_id, $gambar, $time_upload_avident, $time_upload_activity_planning, $deskripsi, $status, $history_update, $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

function upload_file() {
    $namaFile = $_FILES['image']['name'];
    $ukuranFile = $_FILES['image']['size'];
    $error = $_FILES['image']['error'];
    $tmpName = $_FILES['image']['tmp_name'];

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