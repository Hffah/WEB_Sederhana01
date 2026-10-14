<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] != 'admin') {
    header("Location: /perpustakaan/login.php");
    exit;
}
?>