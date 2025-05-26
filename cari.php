<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "macok";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangkap keyword dari input user
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$sql = "SELECT * FROM resep WHERE nama_resep LIKE ?";
$stmt = $conn->prepare($sql);
$search = "%" . $keyword . "%";
$stmt->bind_param("s", $search);
$stmt->execute();

$result = $stmt->get_result();
?>

<h2>Hasil Pencarian untuk: <?= htmlspecialchars($keyword) ?></h2>
<ul>
<?php while ($row = $result->fetch_assoc()): ?>
  <li><?= htmlspecialchars($row['nama_resep']) ?></li>
<?php endwhile; ?>
</ul>

<?php
$stmt->close();
$conn->close();
?>
