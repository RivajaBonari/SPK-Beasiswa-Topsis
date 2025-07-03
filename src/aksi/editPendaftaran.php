<?php
include("../backend/config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_pendaftaran = $_POST['id_pendaftaran'];
    $npm = $_POST['npm'];
    $ipk = $_POST['ipk'];
    $penghasilan_ortu = $_POST['penghasilan_ortu'];
    $tanggungan = $_POST['tanggungan'];
    $organisasi = $_POST['organisasi'];
    $status = $_POST['status'];

    // Query update
    $sql = "UPDATE pendaftaran SET 
                npm = ?,
                ipk = ?,
                penghasilan_ortu = ?,
                tanggungan = ?,
                organisasi = ?,
                status = ?
            WHERE id_pendaftaran = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdiissi", $npm, $ipk, $penghasilan_ortu, $tanggungan, $organisasi, $status, $id_pendaftaran);

    if ($stmt->execute()) {
        include('../html/header.php');
        $_SESSION['success'] = "Berhasil mengubah data alternatif!";
        header("Location: ../html/pendaftaran.php");
        exit;
    } else {
        echo "Gagal update data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Metode tidak diizinkan.";
}
