<?php

$query = $conn->query("SELECT * FROM resep WHERE id_resep = '$_GET[id]'");
$data = $query->fetch_assoc();

$conn->query("DELETE FROM resep WHERE id_resep = '$_GET[id]'");
echo "<script>location='resepku.php';</script>";
?>