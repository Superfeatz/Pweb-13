<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// ambil data untuk tahu nama file foto
$sql = "SELECT foto FROM siswa WHERE id = $id";
$res = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($res);

if ($data) {
    $foto = $data['foto'];

    // hapus data
    $sql_del = "DELETE FROM siswa WHERE id = $id";
    $q = mysqli_query($koneksi, $sql_del);

    if ($q) {
        // hapus file foto
        if (!empty($foto) && file_exists('uploads/'.$foto)) {
            unlink('uploads/'.$foto);
        }
    }
}

header("Location: index.php");
exit;
