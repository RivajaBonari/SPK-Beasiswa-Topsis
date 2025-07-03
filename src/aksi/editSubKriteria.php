<?php
include '../backend/config.php';
session_start();

// Cek apakah semua data dikirim melalui POST
if (
    isset($_POST['id_sub_kriteria']) &&
    isset($_POST['nama_sub_kriteria']) &&
    isset($_POST['nilai_min']) &&
    isset($_POST['nilai_max']) &&
    isset($_POST['nilai_kecocokan'])
) {
    // Ambil data dari form
    $id = $_POST['id_sub_kriteria'];
    $nama = $_POST['nama_sub_kriteria'];
    $nilai_min = $_POST['nilai_min'];
    $nilai_max = $_POST['nilai_max'];
    $nilai_kecocokan = $_POST['nilai_kecocokan'];

    // Query update
    $query = "UPDATE sub_kriteria SET 
                nama_sub_kriteria = '$nama',
                nilai_min = '$nilai_min',
                nilai_max = '$nilai_max',
                nilai_kecocokan = '$nilai_kecocokan'
              WHERE id_sub_kriteria = '$id'";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        include('../html/header.php');
        $_SESSION['success'] = "Berhasil mengubah data sub kriteria!";
        header("Location: ../html/sub_kriteria.php");
        exit;
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
} else {
    echo "Data tidak lengkap dikirim!";
}
