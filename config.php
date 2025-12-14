<?php
$host = "localhost";
$user = "root";      // default XAMPP
$pass = "";          // default XAMPP
$db   = "db_sekolah";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
