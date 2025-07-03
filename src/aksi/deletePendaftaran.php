<?php
include("../backend/config.php");
session_start();

if (isset($_GET['id'])) {
    $id_pendaftaran = $_GET['id'];

    $sql = "DELETE FROM pendaftaran WHERE id_pendaftaran = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_pendaftaran);

    if ($stmt->execute()) {
        include('../html/header.php');
        $_SESSION['success'] = "Berhasil menghapus data alternatif!";
        header("Location: ../html/pendaftaran.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID tidak ditemukan.";
}
