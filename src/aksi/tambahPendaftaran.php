<?php
// Koneksi ke database
include("../backend/config.php");
session_start();

// Pastikan data yang diperlukan ada dalam request POST
if (
    isset($_POST['npm']) &&
    isset($_POST['nilai_akademik']) &&
    isset($_POST['penghasilan_ortu']) &&
    isset($_POST['jumlah_tanggungan']) &&
    isset($_POST['prestasi']) &&
    isset($_POST['status'])
) {
    // Menangkap data yang dikirimkan melalui form
    $npm = $_POST['npm'];
    $nilai_akademik = $_POST['nilai_akademik'];
    $penghasilan_ortu = $_POST['penghasilan_ortu'];
    $jumlah_tanggungan = $_POST['jumlah_tanggungan'];
    $prestasi = $_POST['prestasi'];
    $status = $_POST['status'];

    // Query untuk memasukkan data pendaftaran ke tabel pendaftaran
    $sql = "INSERT INTO pendaftaran (npm, nilai_akademik, penghasilan_ortu, jumlah_tanggungan, prestasi, status) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Persiapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter
        $stmt->bind_param("sdddis", $npm, $nilai_akademik, $penghasilan_ortu, $jumlah_tanggungan, $prestasi, $status);

        // Eksekusi statement
        if ($stmt->execute()) {
            include('../html/header.php');
            $_SESSION['success'] = "Berhasil menambah data alternatif!";
            header("Location: ../html/pendaftaran.php");
            exit;
        } else {
            echo "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
        }
    } else {
        echo "Terjadi kesalahan saat menyiapkan query.";
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
} else {
    // Jika data tidak lengkap
    echo "Data tidak lengkap.";
}
?>
