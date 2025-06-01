<?php
include 'koneksi.php';

// Ambil ID dari URL dan pastikan aman
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Jalankan query untuk ambil resep
$query = mysqli_query($conn, "SELECT * FROM resep WHERE id_resep = $id");
if (!$query) {
    die("Query error: " . mysqli_error($conn));
}

$resep = mysqli_fetch_assoc($query);

if (!$resep) {
    echo "<h1>Resep tidak ditemukan.</h1>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($resep['nama_resep']) ?> | Macook</title>
  <link rel="stylesheet" href="css/deskripsi.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous"/>
</head>

<body>
<?php include 'nav.php'; ?>

<div class="container">
  <div class="row g-4">
    <div class="col-lg-5 col-md-6">
      <img src="<?= htmlspecialchars($resep['gambar_resep']) ?>" alt="<?= htmlspecialchars($resep['nama_resep']) ?>" class="img-fluid rounded shadow">
    </div>
    <div class="col-lg-7 col-md-6">
      <h1 class="fw-bold"><?= htmlspecialchars($resep['nama_resep']) ?></h1>
      <p class="text-muted"><?= htmlspecialchars($resep['deskripsi']) ?></p>
      <button id="favBtn" class="btn btn-outline-danger btn-fav mb-3" data-resep="<?= $resep['id_resep'] ?>">🤍 Simpan ke Favorit</button>

      <div class="row text-center mb-3">
        <div class="col"><div class="badge-custom">🍽️ <?= htmlspecialchars($resep['porsi']) ?></div></div>
        <div class="col"><div class="badge-custom">⏱️ <?= htmlspecialchars($resep['waktu_memasak']) ?></div></div>
        <div class="col"><div class="badge-custom">🍳 <?= htmlspecialchars($resep['id_kategori']) ?></div></div>
      </div>

      <div class="section-box">
        <h5>🧂 Bahan-bahan</h5>
        <ul>
          <?php foreach (explode("\n", trim($resep['bahan'], "[]\"")) as $bahan): ?>
            <li><?= htmlspecialchars(trim($bahan, ' "')) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="section-box">
        <h5>👩‍🍳 Cara Memasak</h5>
        <ol>
          <?php foreach (explode("\n", trim($resep['cara_memasak'], "[]\"")) as $langkah): ?>
            <li><?= htmlspecialchars(trim($langkah, ' "')) ?></li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>
  </div>



<script>
  const favButton = document.querySelector('.btn-fav');
  favButton.addEventListener('click', function(e) {
    e.preventDefault();
    const resepId = favButton.getAttribute('data-resep');

    fetch('', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'resep_id=' + resepId
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'saved') {
        favButton.classList.add('saved', 'btn-danger');
        favButton.classList.remove('btn-outline-danger');
        favButton.innerHTML = '❤️ Disimpan ke Favorit';
        alert('Resep telah disimpan ke favorit!');
      } else {
        favButton.classList.remove('saved', 'btn-danger');
        favButton.classList.add('btn-outline-danger');
        favButton.innerHTML = '🤍 Simpan ke Favorit';
        alert('Resep dihapus dari favorit!');
      }
    });
  });
</script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</html>
