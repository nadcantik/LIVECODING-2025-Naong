<?php session_start();

include "koneksi.php";

// Ambil ID user
if (isset($_GET['id'])) {
    $id_user = $_GET['id']; // Bisa menampilkan profil orang lain
} else {
    $id_user = $_SESSION['id']; // Profil sendiri
}

$query = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

// Ambil semua resep milik user ini
$queryResep = "SELECT * FROM resep WHERE id_user = ?";
$stmtResep = $conn->prepare($queryResep);
$stmtResep->bind_param("i", $id_user);
$stmtResep->execute();
$resultResep = $stmtResep->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $user = null; // Atau bisa redirect ke halaman
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil| Macook</title>
  <link rel="icon" type="image/x-icon" href="foto/logo macook.png">
  <link rel="stylesheet" href="css/profil.css">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous"/>
</head>
<body>
<?php include "nav.php"; ?>

  <div class="container text-center " style="margin-top: 125px;">
    <div class="profile-header mx-auto mb-3">Halaman Profil</div>

    <div class="profile-pic">
     <img src="<?= $user['profil_user'] ?>" alt="Profil">
    </div>
    <h5><?= $user['nama'] ?></h5>
    <p class="text-muted"><?= $user['username'] ?> </p>
    <p><?= $user['deskripsi_diri'] ? $user['deskripsi_diri'] : 'tidak ada deskripsi' ?></p>

    <a href="edit profil.php" class="btn-follow px-4 mb-3">Edit Profil</a>

    <div class="footer">
        <div class="container">
         <div class="row">
          <div class="col">
            <img id="logofooter" src="foto/logo macook.png" alt="">
            <h3>Lokasi</h3>
            <div class="col">         
              <h4>Kunjungi Akun Kami</h4>
              <a href="https://www.instagram.com/nadsfaa_/?hl=en" target="_blank"><img id="foto" src="foto/ig.png" alt="ig"></a>
              <a href="https://wa.me/6289682248714?text=Halo%20saya%20tertarik%20dengan%20produk%20Anda" target="_blank"><img id="foto" src="foto/wa.png" alt="wa"></a>
            </div> 
          </div>
          <div class="col" id="col2">
            <h3>Bantuan</h3><br>
            <p id="foot">Kebijakan Privasi</p>
          </div>
          <div class="col">
              <h3>Kontak kami</h3><br>
              <p id="foot">Nama: Nadtasya Faizah</p>
              <a href="mailto:nadtasyafaizahaqilah@gmail.com"><p id="foot">Email: @nadtasyafaizahmyflower.com</p></a>
              <a href="https://wa.me/6289682248714?text=Halo%20saya%20tertarik%20dengan%20produk%20Anda"><p id="foot">No Hp: +62 89682248714</p></a>
          </div>
        </div> 
        </div>
</div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>
