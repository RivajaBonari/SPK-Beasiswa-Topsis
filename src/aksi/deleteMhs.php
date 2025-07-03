<?php
$x = $_GET['npm'];
include("../backend/config.php");
session_start();
$sql = "delete from mahasiswa where npm='$x'";
$result = $conn->query($sql);
if ($result) {
    include('../html/header.php');
    $_SESSION['success'] = "Berhasil menghapus data mahasiswa!";
    header("Location: ../html/data.php");
    exit;
}