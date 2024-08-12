<?php
session_start();

if (isset($_POST['role'])) {
    $_SESSION['role'] = $_POST['role'];
    header("Location: dashboard.php");
    exit;
} else {
    header("Location: pilih_role.php");
    exit;
}
?>