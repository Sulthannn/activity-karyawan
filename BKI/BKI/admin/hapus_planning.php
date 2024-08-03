<?php
    include ("koneksi.php");

    $id = $_GET['id'];
    $query = "DELETE FROM planning WHERE id = $id";

    if(mysqli_query($koneksi, $query)){

        header("Location: planning.php");
        
    }else{

        echo "Tidak Berhasil";
        
    }
?>