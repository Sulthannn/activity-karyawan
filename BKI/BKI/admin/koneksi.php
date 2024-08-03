<?php
$host = "localhost"; // Ubah jika perlu
$username = "root"; // Ubah jika perlu
$password = ""; // Ubah jika perlu
$database = "bki"; // Ubah jika perlu

// Membuat koneksi ke database
$koneksi = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi Gagal: " . $koneksi->connect_error);
}

// Fungsi untuk menambah data ke tabel users
function tambah_user($data) {
    global $koneksi;

    $nup = htmlspecialchars($data['nup']);
    $nama = htmlspecialchars($data['nama']);
    $divisi = htmlspecialchars($data['divisi']);
    $username = htmlspecialchars($data['username']);
    $password = password_hash(htmlspecialchars($data['password']), PASSWORD_DEFAULT);
    $role = htmlspecialchars($data['role']);
    $status = htmlspecialchars($data['status']);

    $stmt = $koneksi->prepare("INSERT INTO users (nup, nama, divisi, username, password, role, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nup, $nama, $divisi, $username, $password, $role, $status);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

// Fungsi untuk menambah data ke tabel time
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

function tambah_avident($data) {
    global $koneksi;

    $tanggal = $data['tanggal'];
    $user_id = $data['user_id'];
    $gambar = $data['gambar'];
    $time_upload_avident = $data['time_upload_avident'];

    $query = "INSERT INTO avident (tanggal, user_id, gambar, time_upload_avident) VALUES (?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param('ssss', $tanggal, $user_id, $gambar, $time_upload_avident);

    return $stmt->execute();
}

// Fungsi untuk menambah data ke tabel planning
function tambah_planning($data) {
    global $koneksi;

    $tanggal = htmlspecialchars($data['tanggal']);
    $user_id = htmlspecialchars($data['user_id']);
    $deskripsi = htmlspecialchars($data['deskripsi']);
    $time_upload_activity_planning = htmlspecialchars($data['time_upload_activity_planning']);

    $stmt = $koneksi->prepare("INSERT INTO planning (tanggal, user_id, deskripsi, time_upload_activity_planning) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $tanggal, $user_id, $deskripsi, $time_upload_activity_planning);

    $stmt->execute();
    return $stmt->affected_rows;
}

// Fungsi untuk menghapus data dari tabel users
function hapus_user($id) {
    global $koneksi;

    $stmt = $koneksi->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

// Fungsi untuk menghapus data dari tabel time
function hapus_time($id) {
    global $koneksi;

    $stmt = $koneksi->prepare("DELETE FROM time WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

// Fungsi untuk menghapus data dari tabel avident
function hapus_avident($id) {
    global $koneksi;

    $stmt = $koneksi->prepare("DELETE FROM avident WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

// Fungsi untuk menghapus data dari tabel planning
function hapus_planning($id) {
    global $koneksi;

    $stmt = $koneksi->prepare("DELETE FROM planning WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

// Fungsi untuk mengupdate data tabel users
function update_user($data) {
    global $koneksi;

    $id = $data['id'];
    $nup = htmlspecialchars($data['nup']);
    $nama = htmlspecialchars($data['nama']);
    $divisi = htmlspecialchars($data['divisi']);
    $username = htmlspecialchars($data['username']);
    $password = password_hash(htmlspecialchars($data['password']), PASSWORD_DEFAULT);
    $role = htmlspecialchars($data['role']);
    $status = htmlspecialchars($data['status']);

    $stmt = $koneksi->prepare("UPDATE users SET nup=?, nama=?, divisi=?, username=?, password=?, role=?, status=? WHERE id=?");
    $stmt->bind_param("sssssssi", $nup, $nama, $divisi, $username, $password, $role, $status, $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

// Fungsi untuk mengupdate data tabel time
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

// Fungsi untuk mengupdate data tabel avident
function update_avident($data) {
    global $koneksi;

    $id = $data['id'];
    $tanggal = htmlspecialchars($data['tanggal']);
    $user_id = htmlspecialchars($data['user_id']);
    $gambar = upload_file();
    $time_upload_avident = htmlspecialchars($data['time_upload_avident']);

    $stmt = $koneksi->prepare("UPDATE avident SET tanggal=?, user_id=?, gambar=?, time_upload_avident=? WHERE id=?");
    $stmt->bind_param("sissi", $tanggal, $user_id, $gambar, $time_upload_avident, $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

// Fungsi untuk mengupdate data tabel planning
function update_planning($data) {
    global $koneksi;

    $id = $data['id'];
    $tanggal = htmlspecialchars($data['tanggal']);
    $user_id = htmlspecialchars($data['user_id']);
    $deskripsi = htmlspecialchars($data['deskripsi']);

    // Fetch the existing time from the database
    $stmt = $koneksi->prepare("SELECT time_upload_activity_planning FROM planning WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $existing_time = $result->fetch_assoc()['time_upload_activity_planning'];

    // Use the existing time if not provided in the form
    $time_upload_activity_planning = isset($data['time_upload_activity_planning']) ? htmlspecialchars($data['time_upload_activity_planning']) : $existing_time;

    $stmt = $koneksi->prepare("UPDATE planning SET tanggal=?, user_id=?, deskripsi=?, time_upload_activity_planning=? WHERE id=?");
    $stmt->bind_param("sissi", $tanggal, $user_id, $deskripsi, $time_upload_activity_planning, $id);
    
    $stmt->execute();
    return $stmt->affected_rows;
}

// Fungsi untuk mengupload file gambar
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

    if ($ukuranFile > 2048000) { // 2 MB
        echo "<script>alert('Ukuran File Max 2 MB');</script>";
        die();
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.' . $extensifile;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}
?>
