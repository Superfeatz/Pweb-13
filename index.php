<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    img {
        width: 120px;
        height: 120px;
        object-fit: cover;
    }
    </style>

</head>
<body>

<h1>Data Siswa</h1>

<p><a href="tambah.php">Tambah Data</a></p>

<table>
    <tr>
        <th>Foto</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>

    <?php
    $sql = "SELECT * FROM siswa ORDER BY id ASC";
    $result = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td align="center">
                    <?php if (!empty($row['foto'])) { ?>
                        <img src="uploads/<?php echo htmlspecialchars($row['foto']); ?>" 
                             alt="Foto <?php echo htmlspecialchars($row['nama']); ?>" 
                             class="foto-siswa">
                    <?php } else { ?>
                        (Tidak ada foto)
                    <?php } ?>
                </td>
                <td><?php echo htmlspecialchars($row['nis']); ?></td>
                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                <td><?php echo htmlspecialchars($row['telepon']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($row['alamat'])); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>">Ubah</a> |
                    <a href="hapus.php?id=<?php echo $row['id']; ?>" 
                       onclick="return confirm('Yakin ingin menghapus data ini?')">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="7" align="center">Belum ada data</td>
        </tr>
        <?php
    }
    ?>
</table>

</body>
</html>
