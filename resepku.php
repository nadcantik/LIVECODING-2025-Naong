<?php
session_start();
include 'koneksi.php';


$query = "SELECT * FROM resep ORDER BY id_resep";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Resepku - Keranjang Style</title>
   <link rel="stylesheet" href="css/landingpage.css">
  <link rel="icon" type="image/x-icon" href="foto/logo macook.png">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous"/>
</head>
<style>
    body {
  font-family: 'Poppins', sans-serif;
  background-color: #f9f9f9;
  padding-top: 100px;
}

.container {
  max-width: 800px;
  margin: auto;
}

h2 {
  text-align: center;
  color: #333;
  margin-bottom: 30px;
}

.cart-item {
  display: flex;
  align-items: center;
  background-color: white;
  border: 1px solid #ddd;
  border-radius: 12px;
  padding: 15px;
  margin-bottom: 20px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.cart-item img {
  width: 120px;
  height: 100px;
  object-fit: cover;
  border-radius: 10px;
  margin-right: 20px;
}

.item-info {
  flex-grow: 1;
}

.item-info h4 {
  margin: 0 0 10px;
  font-size: 18px;
  color: #222;
}

.item-info p {
  margin: 4px 0;
  color: #555;
  font-size: 14px;
}

.item-actions {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.btn {
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  text-align: center;
  text-decoration: none;
  color: white;
  font-size: 14px;
  cursor: pointer;
}

.btn.update {
  background-color: #2196f3;
}

.btn.update:hover {
  background-color: #1976d2;
}

.btn.delete {
  background-color: #f44336;
}

.btn.delete:hover {
  background-color: #d32f2f;
}

</style>
<body>
<?php include 'nav.php'; ?>
<div class="container">
  <h2>📖 Resepku</h2>
  <?php while ($data = $result->fetch_assoc()): ?>
  <!-- Mulai Looping PHP -->
  <div class="cart-item">
    <img src="<?= htmlspecialchars($data['gambar_resep']) ?>" alt="Resep">
    <div class="item-info">
      <h4><?= htmlspecialchars($data['nama_resep']) ?></h4>
      <p>⏱ Waktu: <?= htmlspecialchars($data['waktu_memasak']) ?></p>
      <p>👥 Porsi: <?= htmlspecialchars($data['porsi']) ?></p>
    </div>
    <div class="item-actions">
      <a href="edit.php" class="btn update">Edit</a>
      <a href="resepku.php?halaman=hapus&id=<?= $data['id_resep']; ?>" class="btn delete" onclick="return confirm('Yakin ingin menghapus resep ini?')">Hapus</a>
    </div>
  </div>
  <!-- Selesai Looping PHP -->
<?php endwhile; ?>
</div>
<?php
					if(isset($_GET["halaman"])){
						if($_GET["halaman"] == "hapus"){
							include 'hapus.php';
						}
					else{
						include 'resepku.php';
					}
        }
				?>                        

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
</body>
</html>