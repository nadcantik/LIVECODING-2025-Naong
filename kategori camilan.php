<?php
require 'function.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resep Kue</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/kategori.css">
</head>
<body>

<div class="container py-5">
  <h2 class="text-center mb-3">Kue</h2>
  <p class="text-center mb-4">
    Ragam inspirasi kue favorit keluarga. Kue ulang tahun, kue bolu, hingga jajanan pasar yang lembut dan manis.
  </p>

  <div class="row">
    <?php
    $query = "SELECT * FROM resep WHERE id_kategori = '3'";
    $result = $koneksi->query($query);

    while ($data = $result->fetch_assoc()):
    ?>
      <div class="col-md-4 mb-4">
        <div class="recipe-card shadow rounded">
          <img src="foto/<?= htmlspecialchars($data['gambar']) ?>"/>
          <div class="info p-3">
            <div class="tags d-flex justify-content-start mb-2">
              <span class="tag me-2"><img src="foto/clock.png" id="tageasy" alt="" width="18"> <?= htmlspecialchars($data['waktu_memasak']) ?></span>
              <span class="tag easy"><img src="foto/cook.png" id="tageasy" alt="" width="18"> <?= htmlspecialchars($data['porsi']) ?> porsi</span>
            </div>
            <p class="mb-0 fw-bold"><?= htmlspecialchars($data['judul']) ?></p>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
