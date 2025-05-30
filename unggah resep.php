<?php
// Koneksi dan logika backend
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

include "koneksi.php"; // Pastikan koneksi ke database sudah benar

$is_edit = isset($_GET['edit']);
$resep_data = [];

if ($is_edit) {
    $id_resep = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM resep WHERE id_resep = ?");
    $stmt->bind_param("i", $id_resep);
    $stmt->execute();
    $result = $stmt->get_result();
    $resep_data = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_resep = $_POST['nama_masakan'];
    $deskripsi = $_POST['deskripsi'];
    $porsi = $_POST['sajian'];
    $waktu = $_POST['waktu'];
    $id_kategori = $_POST['id_kategori'];
    $id_user = $_POST['id_user'];

    $bahan = isset($_POST['bahan']) ? $_POST['bahan'] : [];
    $langkah = isset($_POST['langkah']) ? $_POST['langkah'] : [];

    $gabung_bahan = json_encode(array_filter($bahan));
    $gabung_langkah = json_encode(array_filter($langkah));

    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $gambar = $_FILES["foto_utama"]["name"];
    $target_file = $target_dir . basename($gambar);
    move_uploaded_file($_FILES["foto_utama"]["tmp_name"], $target_file);

    if ($is_edit) {
        $sql = "UPDATE resep SET gambar_resep=?, nama_resep=?, deskripsi=?, porsi=?, waktu_memasak=?, id_user=?, id_kategori=?, bahan=?, cara_memasak=? WHERE id_resep=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssiissi", $target_file, $nama_resep, $deskripsi, $porsi, $waktu, $id_user, $id_kategori, $gabung_bahan, $gabung_langkah, $id_resep);
    } else {
        $sql = "INSERT INTO resep (gambar_resep, nama_resep, deskripsi, porsi, waktu_memasak, id_user, id_kategori, bahan, cara_memasak)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssiiss", $target_file, $nama_resep, $deskripsi, $porsi, $waktu, $id_user, $id_kategori, $gabung_bahan, $gabung_langkah);
    }

    if ($stmt->execute()) {
        $success_message = $is_edit ? "Resep berhasil diperbarui!" : "Resep berhasil diunggah!";
    } else {
        $error_message = "Gagal menyimpan data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $is_edit ? 'Edit Resep' : 'Unggah Resep' ?> | Macook</title>
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

  <h3 class="text-center"><?= $is_edit ? 'Edit Resep Kamu' : 'Bagikan resep andalanmu' ?></h3>

  <form action="" method="POST" enctype="multipart/form-data">
    <div class="upload-area mb-4">
      <div>
        <img src="https://cdn-icons-png.flaticon.com/512/1093/1093078.png" width="50" alt="Upload Icon" />
        <p>Unggah foto maksimal 2 MB</p>
      </div>
      <label class="form-label fw-bold">Unggah foto masakanmu</label>
      <input type="file" name="foto_utama" class="form-control w-25 mx-auto mb-3" <?= $is_edit ? '' : 'required' ?>>
    </div>

    <div class="mb-3">
      <label>Nama masakan:</label>
      <input type="text" name="nama_masakan" class="form-control" 
        value="<?= $is_edit ? htmlspecialchars($resep_data['nama_resep']) : '' ?>" required>
    </div>

    <div class="mb-3">
      <label>Penjelasan singkat:</label>
      <textarea name="deskripsi" class="form-control" required><?= $is_edit ? htmlspecialchars($resep_data['deskripsi']) : '' ?></textarea>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label>Berapa sajian?</label>
        <select name="sajian" class="form-select" required>
          <option value="1 to 2" <?= $is_edit && $resep_data['porsi'] == '1 to 2' ? 'selected' : '' ?>>1 to 2 porsi</option>
          <option value="5 to 10" <?= $is_edit && $resep_data['porsi'] == '5 to 10' ? 'selected' : '' ?>>5 to 10 porsi</option>
        </select>
      </div>
      <div class="col-md-4">
        <label>Waktu memasak</label>
        <select name="waktu" class="form-select" required>
          <?php foreach ([15, 30, 45, 60] as $waktu): ?>
            <option value="<?= $waktu ?>" <?= $is_edit && $resep_data['waktu_memasak'] == $waktu ? 'selected' : '' ?>>
              <?= $waktu ?> mnt
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <label>Kategori</label>
        <select name="id_kategori" class="form-select" required>
          <?php
          $kategori = [1 => 'Masakan rumahan', 2 => 'Kue', 3 => 'Minuman', 4 => 'Camilan'];
          foreach ($kategori as $key => $label):
          ?>
            <option value="<?= $key ?>" <?= $is_edit && $resep_data['id_kategori'] == $key ? 'selected' : '' ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <input type="hidden" name="id_user" value="1">

    <label>Masukkan rincian bahan:</label>
    <div id="bahan-list">
      <?php
        $bahan_array = $is_edit ? json_decode($resep_data['bahan'], true) : [''];
        foreach ($bahan_array as $bahan_item):
      ?>
        <div class="d-flex mb-2">
          <input type="text" name="bahan[]" class="form-control" value="<?= htmlspecialchars($bahan_item) ?>" placeholder="Contoh: 2 sdm garam">
          <button class="btn btn-primary btn-add ms-2" type="button" onclick="addBahan()">+</button>
        </div>
      <?php endforeach; ?>
    </div>

    <label class="mt-4">Cara memasak:</label>
    <div id="langkah-list">
      <?php
        $langkah_array = $is_edit ? json_decode($resep_data['cara_memasak'], true) : [''];
        foreach ($langkah_array as $langkah_item):
      ?>
        <div class="step-container mb-3">
          <textarea name="langkah[]" class="form-control mb-1" rows="2"><?= htmlspecialchars($langkah_item) ?></textarea>
          <button class="btn btn-primary btn-add ms-2" type="button" onclick="addLangkah()">+</button>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="text-end mt-4">
      <button type="submit" class="btn btn-warning"><?= $is_edit ? '💾 Simpan Perubahan' : '📤 Bagikan Sekarang' ?></button>
    </div>
  </form>

  <?php if ($is_edit): ?>
    <form action="hapus_resep.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus resep ini?');">
      <input type="hidden" name="id_resep" value="<?= $id_resep ?>">
      <button type="submit" class="btn btn-danger mt-3">🗑 Hapus Resep</button>
    </form>
  <?php endif; ?>
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
