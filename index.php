<?php
session_start();
include 'koneksi.php';


$query = "SELECT * FROM resep ORDER BY id_resep DESC LIMIT 6";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Macook</title>
  <link rel="stylesheet" href="css/landingpage.css">
  <link rel="icon" type="image/x-icon" href="foto/logo macook.png">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous"/>
</head>
<body>
<?php include 'nav.php'; ?>
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="foto/sidebar1.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="foto/sidebar2.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="foto/sidebar4.png" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<section class="category-list" style="margin-top: 100px;">
  <img src="foto/Nasi goreng.jpeg" alt="Breakfast" href="kategori.php?id=1"> 
  <img src="foto/Es Selendang Mayang, Khas Betawi.jpeg" alt="Dessert" href="kategori.php?id=2">
  <img src="foto/Oreo-milkshake.jpeg" alt="Drink" href="kategori.php?id=3">
  <img src="foto/roti bakar coklat.jpeg" alt="Snack" href="kategori.php?id=4">
</section>
<a href="tampilan unggah.php">
<button class="upload-btn" id="uploadBtn">Unggah Resepmu</button></a>

<div class="container">
  <div class="row">
    <?php while ($data = $result->fetch_assoc()): ?>
      <div class="col-12 col-sm-6 col-lg-4 mb-4">
        <a href="halaman deskripsi.php?id=<?= $data['id_resep'] ?>" style="text-decoration: none; color: inherit;">
          <div class="recipe-card">
            <img src="<?= htmlspecialchars($data['gambar_resep']) ?>" alt="Foto Masakan">
            <div class="info">
              <div class="tags">
                <span class="tag">
                  <img src="foto/clock.png" id="tageasy" alt="">
                  <?= htmlspecialchars($data['waktu_memasak']) ?>
                </span>
                <span class="tag easy">
                  <img src="foto/cook.png" id="tageasy" alt="">
                  <?= htmlspecialchars($data['porsi']) ?> porsi
                </span>
              </div>
              <p><?= htmlspecialchars($data['nama_resep']) ?></p>
            </div>
          </div>
        </a>
      </div>
    <?php endwhile; ?>
  </div>
</div>


<div class="footer">
  <div class="container">
    <div class="row">
      <div class="col">
        <img id="logofooter" src="foto/logo macook.png" alt="">
        <h3>Lokasi</h3>
        <div class="col">         
          <h4>Kunjungi Akun Kami</h4>
          <a href="https://www.instagram.com/nadsfaa_/?hl=en" target="_blank"><img id="foto" src="foto/ig.png" alt="ig"></a>
          <a href="https://wa.me/6289682248714" target="_blank"><img id="foto" src="foto/wa.png" alt="wa"></a>
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
        <a href="https://wa.me/6289682248714"><p id="foot">No Hp: +62 89682248714</p></a>
      </div>
    </div>
  </div>
</div>

<script>
  const uploadBtn = document.getElementById("uploadBtn");
  uploadBtn.addEventListener("mouseenter", () => uploadBtn.classList.add("animate"));
  uploadBtn.addEventListener("mouseleave", () => uploadBtn.classList.remove("animate"));
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
