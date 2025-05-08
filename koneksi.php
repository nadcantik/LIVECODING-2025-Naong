<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "macok";

$conn = mysqli_connect($host, $username, $password, $database);

function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
