<?php
include "koneksi.php" ; // Pastikan ini ada dan konek DB

$id_kategori = $_GET['id_kategori'] ?? 1; // Default ke kategori id = 1 jika tidak diset

$ktgquery = "SELECT * FROM kategory WHERE id_kategori = ?";
$ktgstmt = $conn->prepare($ktgquery);

if ($ktgstmt) {
    $ktgstmt->bind_param("i", $id_kategori);
    $ktgstmt->execute();
    $resultt = $ktgstmt->get_result();
    $kategory = $resultt->fetch_assoc();
    $ktgstmt->close();
} else {
    die("Query preparation failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kategori</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/kategori.css">
</head>
<body>
 <?php include 'nav.php'; ?>
<br>
<div class="container py-5">
  <h2 class="text-center mb-3"> 
  <?=$kategory ['nama_kategori'] ?> </h2>
  <p class="text-center mb-4">
    <?=$kategory ['Deskripsi_kategori'] ?> 
</p>

  <div class="row">
    <?php
    $query = "SELECT * FROM resep WHERE id_kategori = $id_kategori";
    $result = $conn->query($query);

    while ($data = $result->fetch_assoc()):
    ?>
      <div class="col-md-4 mb-4">
        <div class="recipe-card shadow rounded">
          <img src="<?= htmlspecialchars($data['gambar_resep']) ?>"/>
          <div class="info p-3">
            <div class="tags d-flex justify-content-start mb-2">
              <span class="tag me-2"><img src="foto/clock.png" id="tageasy" alt="" width="18"> <?= htmlspecialchars($data['waktu_memasak']) ?></span>
              <span class="tag easy"><img src="foto/cook.png" id="tageasy" alt="" width="18"> <?= htmlspecialchars($data['porsi']) ?> porsi</span>
            </div>
            <p class="mb-0 fw-bold"><?= htmlspecialchars($data['nama_resep']) ?></p>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
