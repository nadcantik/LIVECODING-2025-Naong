<?php
// edit_profile.php

// Include your database connection file
include "koneksi.php"; // Ensure this file contains the correct database connection code

// --- Assuming a user is logged in and their ID is in $_SESSION['user_id'] ---
// For demonstration, let's hardcode a user ID if no session is available
$id = 1; // Replace with $_SESSION['user_id'] in a real application
if (!isset($_SESSION['id'])) {
    // In a real application, redirect to login page
    // header("Location: login.php");
    // exit();
} else {
    $id = $_SESSION['id'];
}
// --- End of user ID assumption ---


$userData = []; // Initialize an empty array to store user data

// 1. Fetch existing user data to pre-fill the form
if ($id) {
    $stmt = $conn->prepare("SELECT nama, profil_user, deskripsi_diri, no_telp, email, username FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        // User not found, handle error (e.g., redirect to an error page)
        echo "User not found!";
        // header("Location: error.php");
        // exit();
    }
    $stmt->close();
}

// 2. Handle form submission (when the user clicks "Perbarui")
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Sanitize and validate inputs
    $nama = htmlspecialchars(trim($_POST['nama'] ?? ''));
    $profil_user = htmlspecialchars(trim($_POST['profil_user'] ?? ''));
    $deskripsi_diri = htmlspecialchars(trim($_POST['deskripsi_diri'] ?? ''));
    $no_telp = htmlspecialchars(trim($_POST['no_telp'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars(trim($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? ''; // New password, not yet hashed

    // Basic validation
    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong.";
    }
    if (empty($username)) {
        $errors[] = "Username tidak boleh kosong.";
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    }

    // If there are no validation errors, proceed with update
    if (empty($errors)) {
        // Build the update query dynamically based on what's provided
        $updateFields = [];
        $params = [];
        $types = "";

        if (!empty($nama)) {
            $updateFields[] = "nama = ?";
            $params[] = $nama;
            $types .= "s";
        }
        if (!empty($profil_user)) {
            $updateFields[] = "profil_user = ?";
            $params[] = $profil_user;
            $types .= "s";
        }
        if (!empty($deskripsi_diri)) {
            $updateFields[] = "deskripsi_diri = ?";
            $params[] = $deskripsi_diri;
            $types .= "s";
        }
        if (!empty($no_telp)) {
            $updateFields[] = "no_telp = ?";
            $params[] = $no_telp;
            $types .= "s";
        }
        if (!empty($email)) {
            $updateFields[] = "email = ?";
            $params[] = $email;
            $types .= "s";
        }
        if (!empty($username)) {
            $updateFields[] = "username = ?";
            $params[] = $username;
            $types .= "s";
        }

        // Only update password if a new one is provided
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $updateFields[] = "password = ?";
            $params[] = $hashed_password;
            $types .= "s";
        }

        if (!empty($updateFields)) {
            $sql = "UPDATE user SET " . implode(", ", $updateFields) . " WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }

            // Add user_id to parameters and 'i' to types
            $params[] = $id;
            $types .= "i";

            // Bind parameters dynamically
            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                // Success: Redirect or show a success message
                echo "<script>alert('Profil berhasil diperbarui!'); window.location.href='index.php';</script>";
                exit();
            } else {
                // Error: Show an error message
                $errors[] = "Gagal memperbarui profil: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errors[] = "Tidak ada perubahan yang dikirimkan.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Profil | MACook</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f7f7f7;
    }
    .edit-container {
      max-width: 700px;
      margin: 40px auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .profile-wrapper {
      position: relative;
      width: 150px;
      height: 150px;
      margin: 40px auto;
    }

    .profile-pic {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #fff;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .overlay-icons {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      display: flex;
      gap: 15px;
      background: rgba(0,0,0,0.5);
      border-radius: 10px;
      padding: 6px 12px;
      align-items: center;
      opacity: 0; /* Hidden by default */
      transition: opacity 0.3s ease;
    }

    .profile-wrapper:hover .overlay-icons {
      opacity: 1; /* Show on hover */
    }

    .overlay-icons i {
      color: white;
      font-size: 1.2rem;
      cursor: pointer;
    }

    .overlay-icons i:hover {
      color: #ffc107;
    }
  </style>
</head>
<body class="bg-light text-center">

<div class="container edit-container">
  <div class="profile-wrapper">
    <img src="foto/naong.jpg" alt="Foto Profil" class="profile-pic">

    <div class="overlay-icons">
      <img src="foto/pencil.png" alt="Ubah Foto" style="width: 25px; cursor: pointer;" onclick="alert('Fungsi ubah foto belum diimplementasikan!')">
      <div style="width:1px; height:20px; background:#fff;"></div>
      <img src="foto/rubbish.png" alt="Hapus Foto" style="width: 25px; cursor: pointer;" onclick="alert('Fungsi hapus foto belum diimplementasikan!')">
    </div>
  </div>

  <form action="" method="post">
    <?php
    // Display validation errors if any
    if (!empty($errors)) {
        echo '<div class="alert alert-danger" role="alert">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
    ?>

    <div class="mb-3">
      <label for="nama" class="form-label">Nama</label>
      <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" value="<?= htmlspecialchars($userData['nama'] ?? '') ?>">
    </div>

    <div class="mb-3">
      <label for="deskripsi_diri" class="form-label">Deskripsi Diri</label>
      <textarea class="form-control" id="deskripsi_diri" name="deskripsi_diri" rows="3" placeholder="Tentang kamu dan masakanmu..."><?= htmlspecialchars($userData['deskripsi_diri'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
      <label for="no_telp" class="form-label">No. Telepon</label>
      <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="08xxxxxxxxxx" value="<?= htmlspecialchars($userData['no_telp'] ?? '') ?>">
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" value="<?= htmlspecialchars($userData['email'] ?? '') ?>">
    </div>

    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="Username login" value="<?= htmlspecialchars($userData['username'] ?? '') ?>">
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
    </div>

    <div class="d-flex justify-content-between">
      <button type="submit" class="btn btn-dark px-5">Perbarui</button>
      <a href="index.php" class="btn btn-light border">Batal</a>
    </div>

  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>