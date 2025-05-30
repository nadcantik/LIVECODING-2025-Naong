<?php
include "koneksi.php"; // Pastikan koneksi ke database sudah benar
if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = null; // Inisialisasi jika belum ada session
}

?>


<style>
        nav {
        background-color: #FEF9E1;
    }

    .profil img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 50px;
        }

    header {
      background-size: cover;
      height: 300px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      padding: 20px;
    }

    header h1 {
      font-size: 2.5rem;
      margin: 0;
    }

    header p {
      font-size: 1rem;
      max-width: 400px;
      margin-top: 10px;
    }

    .search-box {
        display: flex;
        align-items: center;
        background-color: white;
        border: 1.5px solid #ccc;
        border-radius: 999px;
        padding: 5px 15px;
        width: 400px; 
        margin-right: 50px;
        }

    .search-box input[type="text"] {
        border: none;
        outline: none;
        flex: 1;
        font-size: 16px;
        color: #333;
        padding-left: 0px;
    }

    .search-box button {
        background: none;
        border: none;
        color: #ccc;
        cursor: pointer;
        font-size: 18px;
    }
</style>
 <?php if(isset($_SESSION["id_user"])):
    $query = "SELECT * FROM user WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_SESSION['id_user']);
    $stmt->execute();
    $hasil = $stmt->get_result();
    $user = $hasil->fetch_assoc();
    ?>
    <nav class="navbar navbar-expand-lg fixed-top" style="font-family: poppins, sans-serif;">
    <div class="container-fluid ms-3" >
      <img src="foto/logo macook.png" width="8%">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-5">
          <li class="nav-item" style="margin: 5px;">
            <a class="nav-link active" aria-current="page" href="index.php">Beranda</a>
          </li>
          <li class="nav-item dropdown" style="margin: 5px;">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Kategori
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="kategori.php?id=1">Masakan Rumahan</a></li>
              <li><a  class="dropdown-item" href="kategori.php?id=2">kue</a></li>
              <li><a class="dropdown-item" href="kategori.php?id=3">Minuman</a></li>
              <li><a class="dropdown-item" href="kategori.php?id=4">Camilan</a></li>
            </ul>
              </li>
              <li class="nav-item" style="margin: 5px;">
                <a class="nav-link" href="tampilan unggah.php">Unggah Resepmu</a>
              </li>
        </ul>
      </div>
       <form class="search-box">
        <button type="submit"><i class="fas fa-search"></i></button>
        <input type="text" placeholder="Mau masak apa hari ini?..."> 
      </form>
      <a href="favorit.php" class="icon-button me-3" title="Favorit">
        <i class="fas fa-heart fa-lg text-danger"></i>
      </a>
      <div class="profil">
        <a href="halaman profil.php"><img src="foto/<?= $user['profil_user'] ?>" alt="Profil"></a>
      </div>
  </nav>
  
<?php else: ?>
<nav class="navbar navbar-expand-lg fixed-top" style="font-family: poppins, sans-serif;">
  <div class="container-fluid ms-3">
    <img src="foto/logo macook.png" width="8%">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-5">
        <li class="nav-item" style="margin: 5px;">
          <a class="nav-link active" aria-current="page" href="index.php">Beranda</a>
        </li>
        <li class="nav-item dropdown" style="margin: 5px;">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Kategori</a>
          <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="kategori.php?id=1">Masakan Rumahan</a></li>
              <li><a  class="dropdown-item" href="kategori.php?id=2">kue</a></li>
              <li><a class="dropdown-item" href="kategori.php?id=3">Minuman</a></li>
              <li><a class="dropdown-item" href="kategori.php?id=4">Camilan</a></li>
          </ul>
        </li>
        <li class="nav-item" style="margin: 5px;">
          <a class="nav-link" href="unggah resep.php">Unggah Resepmu</a>
        </li>
      </ul>
    </div>
    <div class="d-flex">
      <button class="btn btn-masuk me-3" type="button" onclick="window.location.href='login.php'">Masuk</button>

    </div>
</nav>
<?php endif; ?>