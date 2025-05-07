<?php
include "koneksi.php";

$host = "localhost";
$dbname = "macok"; 
$user = "root";
$pass = ""; 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

// Cek user di database
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php"); // Ganti dengan halaman setelah login
        exit();
    } else {
        echo "Password salah!";
    }
} else {
    echo "Username tidak ditemukan!";
}

$conn->close();
?>
