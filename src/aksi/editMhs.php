<?php
include("../backend/config.php");
session_start();

$npm = $_POST['npm'];
$nama = $_POST['nama_mahasiswa'];
$gender = $_POST['gender'];
$telepon = $_POST['telepon'];
$alamat = $_POST['alamat'];

$sql = "UPDATE mahasiswa SET 
          nama_mahasiswa='$nama',
          gender='$gender',
          telepon='$telepon',
          alamat='$alamat'
        WHERE npm='$npm'";

if ($conn->query($sql)) {
    include('../html/header.php');
    $_SESSION['success'] = "Berhasil mengubah data mahasiswa!";
    header("Location: ../html/data.php");
    exit;
    
} else {
    echo "Gagal update data";
}
?>
