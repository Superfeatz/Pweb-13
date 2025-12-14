<?php
include 'config.php';

// handle submit
if (isset($_POST['simpan'])) {
    $nis           = $_POST['nis'];
    $nama          = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telepon       = $_POST['telepon'];
    $alamat        = $_POST['alamat'];

    $nama_foto_baru = "";

    // kalau ada file foto yang diupload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $tmp_name   = $_FILES['foto']['tmp_name'];
        $nama_file  = $_FILES['foto']['name'];
        $ukuran     = $_FILES['foto']['size'];

        // batasi tipe file
        $ext_valid = ['jpg','jpeg','png','gif'];
        $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        if (!in_array($ext, $ext_valid)) {
            echo "<script>alert('Tipe file harus JPG/PNG/GIF');</script>";
        } elseif ($ukuran > 2 * 1024 * 1024) { // 2MB
            echo "<script>alert('Ukuran file maksimal 2MB');</script>";
        } else {
            // buat nama unik
            $nama_foto_baru = date('YmdHis') . '_' . rand(100,999) . '.' . $ext;
            move_uploaded_file($tmp_name, 'uploads/' . $nama_foto_baru);
        }
    }

    // simpan ke DB
    $sql = "INSERT INTO siswa (nis, nama, jenis_kelamin, telepon, alamat, foto)
            VALUES ('$nis', '$nama', '$jenis_kelamin', '$telepon', '$alamat', '$nama_foto_baru')";

    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Tambah Data Siswa</h1>
<p><a href="index.php">Kembali ke Data Siswa</a></p>

<form action="" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>NIS</td>
            <td><input type="text" name="nis" required></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><input type="text" name="nama" required></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>
                <label><input type="radio" name="jenis_kelamin" value="Laki-laki" required> Laki-laki</label>
                <label><input type="radio" name="jenis_kelamin" value="Perempuan" required> Perempuan</label>
            </td>
        </tr>
        <tr>
            <td>Telepon</td>
            <td><input type="text" name="telepon"></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><textarea name="alamat" rows="3"></textarea></td>
        </tr>
        <tr>
            <td>Foto</td>
            <td><input type="file" name="foto" accept="image/*"></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" name="simpan">Simpan</button>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
