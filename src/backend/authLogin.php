<?php
include("config.php");
session_start();

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Lakukan query ke database
$query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 1) {
    $data = mysqli_fetch_assoc($result);

    // Simpan data ke session
    $_SESSION['username'] = $data['username'];
    $_SESSION['login'] = true;

    header("Location: ../html/index.php");
    exit;
} else {
    // Login gagal
    header("Location: ../html/authentication-login.php?error=1");
    exit;
}
