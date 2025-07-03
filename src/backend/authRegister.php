<?php
include("config.php");

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validasi: jika salah satu input kosong
if (empty($username) || empty($email) || empty($password)) {
    // Redirect kembali ke halaman register dengan pesan error
    header("Location: ../html/authentication-register.php?error=empty");
    exit;
}

// Query insert
$sql = "INSERT INTO user(username, email, password) VALUES ('$username', '$email', '$password')";
$exe = $conn->query($sql);

if ($exe) {
    // Jika berhasil, redirect ke login dengan pesan sukses
    header("Location: ../html/authentication-login.php?register=success");
} else {
    // Jika gagal insert
    header("Location: ../html/authentication-register.php?error=fail");
}
?>
