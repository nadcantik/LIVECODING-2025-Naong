<?php
session_start();
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['id_user'] = $row['id'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }

    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
 <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login| Macook</title>
  <link rel="icon" type="image/x-icon" href="foto/logo macook.png">
  <link rel="stylesheet" href="css/login.css">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous"/>
</head>
</head>
<body>

<div class="container-fluid">
  <div class="row vh-100">
    <!-- Image Left -->
    <div class="col-md-6 p-0">
        <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092" alt="Food" class="img-fluid w-100 h-100" style="object-fit: cover;">
    </div>

    <!-- Login Form Right -->
    <div class="col-md-6 d-flex justify-content-center align-items-center">
      <div class="login-container w-75">
        <div class="text-center mb-4">
          <img src="foto/logo macook.png" alt="Logo" width="35%">
        </div>
        <form id="loginForm" method="post" action="login.php">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button type="submit" class="btn btn-login w-100" name="login">Login</button>
        </form>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger mt-3" role="alert">
      <?php echo $error; ?>
    </div>
  <?php endif; ?>

        <div class="text-center mt-3">
          <small>Belum Punya Akun? <a href="registrasi.php">Daftar</a></small>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
