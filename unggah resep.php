<?php

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $user = "root";
    $password = ""; // sesuaikan dengan server kamu
    $database = "macok";

    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Ambil data dari form
    $nama_resep = $_POST['nama_masakan'];
    $deskripsi = $_POST['deskripsi'];
    $porsi = $_POST['sajian'];
    $waktu = $_POST['waktu'];
    $id_kategori = (int)$_POST['id_kategori'];
    $id_user = (int)$_POST['id_user'];

    $bahan = isset($_POST['bahan']) ? $_POST['bahan'] : [];
    $langkah = isset($_POST['langkah']) ? $_POST['langkah'] : [];

    $gabung_bahan = json_encode(array_filter($bahan));
    $gabung_langkah = json_encode(array_filter($langkah));

    // Upload gambar
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $gambar = $_FILES["foto_utama"]["name"];
    $target_file = $target_dir . basename($gambar);

    // Validasi ukuran file
    if ($_FILES["foto_utama"]["size"] > 2 * 1024 * 1024) {
        $error_message = "Ukuran file terlalu besar. Maksimum 2 MB.";
    } else {
        move_uploaded_file($_FILES["foto_utama"]["tmp_name"], $target_file);

        // Query insert
        $sql = "INSERT INTO resep 
            (gambar_resep, nama_resep, deskripsi, porsi, waktu_memasak, id_user, id_kategori, bahan, cara_memasak)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssiiss", $target_file, $nama_resep, $deskripsi, $porsi, $waktu, $id_user, $id_kategori, $gabung_bahan, $gabung_langkah);

        if ($stmt->execute()) {
            $success_message = "Resep berhasil diunggah!";
        } else {
            $error_message = "Gagal menyimpan data: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>form unggah | Macook</title>
  <link rel="icon" type="image/x-icon" href="foto/logo macook.png">
  <link rel="stylesheet" href="css/formunggah.css">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'nav.php'; ?>

<div class="container" style="margin-top: 120px;">
  <?php if ($success_message): ?>
    <div class="alert alert-success"><?= $success_message ?></div>
  <?php elseif ($error_message): ?>
    <div class="alert alert-danger"><?= $error_message ?></div>
  <?php endif; ?>

  <h3 class="text-center">Bagikan resep andalanmu</h3>

  <form action="" method="POST" enctype="multipart/form-data">
    <div class="upload-area mb-4 text-center">
      <div>
        <img src="https://cdn-icons-png.flaticon.com/512/1093/1093078.png" width="50" alt="Upload Icon" />
        <p>Unggah foto maksimal 2 MB</p>
      </div>
      <label class="form-label fw-bold">Unggah foto masakanmu</label>
      <input type="file" name="foto_utama" class="form-control w-25 mx-auto mb-3" required>
    </div>

    <div class="mb-3">
      <label>Nama masakan:</label>
      <input type="text" name="nama_masakan" class="form-control" placeholder="Ketik nama masakanmu (Maks. 10 kata)" required>
    </div>

    <div class="mb-3">
      <label>Penjelasan singkat:</label>
      <textarea name="deskripsi" class="form-control" placeholder="Tulis cerita menarik di balik resep ini!" required></textarea>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label>Berapa sajian?</label>
        <select name="sajian" class="form-select" required>
          <option value="1 to 2">1 to 2 porsi</option>
          <option value="5 to 10">5 to 10 porsi</option>
        </select>
      </div>
      <div class="col-md-4">
        <label>Waktu memasak</label>
        <select name="waktu" class="form-select" required>
          <option value="15">15 mnt</option>
          <option value="30">30 mnt</option>
          <option value="45">45 mnt</option>
          <option value="60">60 mnt</option>
        </select>
      </div>
      <div class="col-md-4">
        <label>Kategori</label>
        <select name="id_kategori" class="form-select" required>
          <option value="1">Masakan Rumahan</option>
          <option value="2">Kue</option>
          <option value="3">Minuman</option>
          <option value="4">Camilan</option>
        </select>
      </div>
    </div>

    <input type="hidden" name="id_user">

    <label>Masukkan rincian bahan:</label>
    <div id="bahan-list">
      <div class="d-flex mb-2">
        <input type="text" name="bahan[]" class="form-control" placeholder="Contoh: 2 sdm garam">
        <button class="btn btn-primary btn-add ms-2" type="button" onclick="addBahan()">+</button>
      </div>
    </div>

    <label class="mt-4">Cara memasak:</label>
    <div id="langkah-list">
      <div class="step-container mb-3">
        <textarea name="langkah[]" class="form-control" rows="2" placeholder="Contoh: Tumis bawang hingga harum."></textarea>
        <button class="btn btn-primary btn-add ms-2" type="button" onclick="addLangkah()">+</button>
      </div>
    </div>

    <div class="text-end mt-4">
      <button type="submit" class="btn btn-warning">📤 Bagikan Sekarang</button>
    </div>
  </form>
</div>

<script>
function addBahan() {
  const list = document.getElementById('bahan-list');
  const div = document.createElement('div');
  div.classList.add('d-flex', 'mb-2');
  div.innerHTML = `
    <input type="text" name="bahan[]" class="form-control" placeholder="Contoh: 2 sdm garam">
    <button class="btn btn-danger ms-2" type="button" onclick="this.parentElement.remove()">-</button>
  `;
  list.appendChild(div);
}

function addLangkah() {
  const list = document.getElementById('langkah-list');
  const div = document.createElement('div');
  div.classList.add('step-container', 'mb-3');
  div.innerHTML = `
    <textarea name="langkah[]" class="form-control mb-1" rows="2" placeholder="Contoh: Tumis bawang hingga harum."></textarea>
    <button class="btn btn-danger ms-2" type="button" onclick="this.parentElement.remove()">-</button>
  `;
  list.appendChild(div);
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
