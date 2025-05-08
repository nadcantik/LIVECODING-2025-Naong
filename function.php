<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "macok");

function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function registrasi($data) {
    global $koneksi;

    // Ambil data dari form
    $nama_pengguna = $data["nama_pengguna"];
    $no_telp = $data["no_telp"];
    $Email = $data["Email"];
    $alamat = $data["alamat"];
    $username = strtolower(stripcslashes($data["username"]));
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $konfirmasi_password = mysqli_real_escape_string($koneksi, $data["konfirmasi_password"]);

    if ($password !== $konfirmasi_password) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai');
              </script>";
        return 0;
    }
}

?>