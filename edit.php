<?php
include 'config.php';

// ambil data lama
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id  = $_GET['id'];
$sql = "SELECT * FROM siswa WHERE id = $id";
$res = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($res);

if (!$data) {
    die("Data tidak ditemukan");
}

// handle submit update
if (isset($_POST['update'])) {
    $nis           = $_POST['nis'];
    $nama          = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telepon       = $_POST['telepon'];
    $alamat        = $_POST['alamat'];

    $nama_foto_lama = $data['foto'];
    $nama_foto_baru = $nama_foto_lama; // default: pakai foto lama

    // cek apakah ada foto baru
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $tmp_name   = $_FILES['foto']['tmp_name'];
        $nama_file  = $_FILES['foto']['name'];
        $ukuran     = $_FILES['foto']['size'];

        $ext_valid = ['jpg','jpeg','png','gif'];
        $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        if (!in_array($ext, $ext_valid)) {
            echo "<script>alert('Tipe file harus JPG/PNG/GIF');</script>";
        } elseif ($ukuran > 2 * 1024 * 1024) {
            echo "<script>alert('Ukuran file maksimal 2MB');</script>";
        } else {
            // hapus foto lama kalau ada
            if (!empty($nama_foto_lama) && file_exists('uploads/'.$nama_foto_lama)) {
                unlink('uploads/'.$nama_foto_lama);
            }
            // upload baru
            $nama_foto_baru = date('YmdHis') . '_' . rand(100,999) . '.' . $ext;
            move_uploaded_file($tmp_name, 'uploads/' . $nama_foto_baru);
        }
    }

    $sql_update = "UPDATE siswa SET
                    nis = '$nis',
                    nama = '$nama',
                    jenis_kelamin = '$jenis_kelamin',
                    telepon = '$telepon',
                    alamat = '$alamat',
                    foto = '$nama_foto_baru'
                   WHERE id = $id";

    $q = mysqli_query($koneksi, $sql_update);

    if ($q) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal update data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Data Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Ubah Data Siswa</h1>
<p><a href="index.php">Kembali ke Data Siswa</a></p>

<form action="" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>NIS</td>
            <td><input type="text" name="nis" value="<?php echo htmlspecialchars($data['nis']); ?>" required></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>
                <label>
                    <input type="radio" name="jenis_kelamin" value="Laki-laki"
                        <?php if ($data['jenis_kelamin'] == 'Laki-laki') echo 'checked'; ?>>
                    Laki-laki
                </label>
                <label>
                    <input type="radio" name="jenis_kelamin" value="Perempuan"
                        <?php if ($data['jenis_kelamin'] == 'Perempuan') echo 'checked'; ?>>
                    Perempuan
                </label>
            </td>
        </tr>
        <tr>
            <td>Telepon</td>
            <td><input type="text" name="telepon" value="<?php echo htmlspecialchars($data['telepon']); ?>"></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>
                <textarea name="alamat" rows="3"><?php echo htmlspecialchars($data['alamat']); ?></textarea>
            </td>
        </tr>
        <tr>
            <td>Foto Lama</td>
            <td>
                <?php if (!empty($data['foto'])) { ?>
                    <img src="uploads/<?php echo htmlspecialchars($data['foto']); ?>" 
                         alt="Foto lama" class="foto-siswa"><br>
                <?php } else { ?>
                    (Tidak ada foto)
                <?php } ?>
                <small>Jika ingin ganti, upload foto baru:</small><br>
                <input type="file" name="foto" accept="image/*">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" name="update">Update</button>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
