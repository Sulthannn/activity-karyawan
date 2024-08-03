<?php
    session_start();
    session_destroy();

    header ("location: Halaman_login.php");
?>