<?php
session_start();
$favorit = $_SESSION['favorit'] ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Halaman Favorit</title>
  <style>
    .btn { display: inline-block; margin: 5px; padding: 10px; background: #f8b400; color: white; text-decoration: none; border-radius: 5px; }
  </style>
</head>
<body>

  <div class="container">
    <div class="icon-heart">❤️</div>

    <?php if (empty($favorit)) : ?>
      <h2>Halaman favorit masih kosong</h2>
      <p>Simpan resep dan artikel favorit di lain waktu.<br/>Klik untuk menyimpan.</p>
      <div class="btn-container">
        <a href="index.php" class="btn">🍲 Lihat resep</a>
      </div>
    <?php else : ?>
      <h2>Resep Favorit Anda</h2>
      <p>Berikut adalah daftar resep yang Anda simpan:</p>
      <div class="btn-container">
        <?php foreach ($favorit as $judul): ?>
          <a href="resep.php?judul=<?= urlencode($judul) ?>" class="btn"><?= htmlspecialchars($judul) ?></a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</body>
</html>
