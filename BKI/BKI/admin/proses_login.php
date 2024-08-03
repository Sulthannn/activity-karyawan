<?php
    //start the session
    session_start();
    include ("koneksi.php");

    $username     = $_POST['username'];
    $password     = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' and password = md5('$password')" ;
    $result = mysqli_query($koneksi, $query);
    
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $_SESSION['username'] = $username;
            $_SESSION['username'] = $row['username'];
        }
        header("location: dashboard.php");
    }else{

        header("location: Halaman_login.php");
    }
?>

<!-- echo '<script>alert("Berhasil masuk!"); window.location.href = "Halaman_Beranda.php";</script>';
    } else {
        echo '<script>alert("Gagal masuk. Periksa kembali username dan password Anda."); window.location.href = "Halaman_login.php";</script>';
    } -->