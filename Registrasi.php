<?php
// Konfigurasi koneksi
$host = "localhost";
$user = "root";
$pass = "";
$db   = "macok";

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil data dari POST dengan validasi
  $nama     = $_POST['nama'] ?? '';
  $no_telp  = $_POST['no_telp'] ?? '';
  $email    = $_POST['email'] ?? '';
  $username = $_POST['username'] ?? '';
  $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

  // Validasi sederhana
  if (!$nama || !$no_telp || !$email || !$username || !$password) {
  }

  $sql = "INSERT INTO user (nama, no_telp, email, username, password) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);

  if (!$stmt) {
    die("Query error: " . $conn->error);
  }

  $stmt->bind_param("sssss", $nama, $no_telp, $email, $username, $password);

  if ($stmt->execute()) {
    echo "<script>alert('Registrasi berhasil!'); window.location.href='Login.php';</script>";
  } else {
    echo "<script>alert('Registrasi gagal: " . $stmt->error . "'); window.history.back();</script>";
  }

  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MACook Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/registrasi.css">
</head>
<body>

<div class="container-fluid">
  <div class="row vh-100">
    <div class="col-md-6 d-flex justify-content-center align-items-center">
      <div class="form-container w-75">
        <div class="text-center mb-4">
          <img src="foto/logo macook.png" alt="Logo" width="40%">
        </div>
        <form id="registrasiForm" method="post" action="registrasi.php">
          <input type="text" name="nama" class="form-control" placeholder="Nama" required>
          <input type="text" name="no_telp" class="form-control" placeholder="No telp" required>
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <input type="text" name="username" class="form-control" placeholder="Username" required>
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <button type="submit" class="btn btn-submit w-100">Daftar</button>
        </form>
        <div class="text-center mt-3">
          <small>Sudah Punya Akun? <a href="Login.php">Login</a></small>
        </div>
      </div>
    </div>
    <div class="col-md-6 p-0">
      <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092" alt="Food" class="img-fluid w-100 h-100" style="object-fit: cover;">
    </div>
  </div>
</div>

</body>
</html>
