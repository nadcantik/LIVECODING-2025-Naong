<?php
// Koneksi dan logika backend
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

include "koneksi.php"; // koneksi

// Cek jika form disubmit
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

    $sql = "INSERT INTO resep (gambar_resep, nama_resep, deskripsi, porsi, waktu_memasak, id_user, id_kategori, bahan, cara_memasak)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssiiss", $target_file, $nama_resep, $deskripsi, $porsi, $waktu, $id_user, $id_kategori, $gabung_bahan, $gabung_langkah);

    if ($stmt->execute()) {
        $id_resep = $stmt->insert_id;
        $success_message = "Resep berhasil diunggah!";
    } else {
        $error_message = "Gagal menyimpan data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- HTML Bagian Tombol -->
  <div class="action-buttons">
    <?php if (isset($resep['id_resep'])): ?>
      <a href="edit_resep.php?id=<?= $resep['id_resep'] ?>" class="btn btn-outline-warning rounded-pill px-4 fw-bold">✏️ Edit Resep</a>
    <?php endif; ?>

    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold" onclick="window.print()">🖨️ Print</button>

    <?php if (isset($resep['id_resep'])): ?>
      <form action="hapus_resep.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus resep ini?');">
        <input type="hidden" name="id_resep" value="<?= $resep['id_resep'] ?>">
        <button type="submit" class="btn btn-outline-danger rounded-pill px-4 fw-bold">🗑️ Hapus</button>
      </form>
    <?php endif; ?>
  </div>
</div>
