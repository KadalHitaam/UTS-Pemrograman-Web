<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h2>Daftar Mahasiswa</h2>
        
        <a href="form.php" class="btn btn-add">+ Tambah Data Mahasiswa</a>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>NIM</th>
                    <th>Nama Lengkap</th>
                    <th>Jurusan</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM mahasiswa ORDER BY id DESC");
                while ($row = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <img src="uploads/<?= $row['foto']; ?>" class="thumbnail" alt="Foto Profil">
                    </td>
                    <td><strong><?= htmlspecialchars($row['nim']); ?></strong></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><span style="background: #f3e8ff; padding: 4px 10px; border-radius: 20px; font-size: 13px; color: #6b21a8; font-weight: 600;"><?= htmlspecialchars($row['jurusan']); ?></span></td>
                    <td style="text-align: center;">
                        <a href="form.php?id=<?= $row['id']; ?>" class="btn btn-edit">Edit</a>
                        <!-- Memanggil fungsi konfirmasi dari script.js -->
                        <a href="proses.php?aksi=hapus&id=<?= $row['id']; ?>" class="btn btn-delete" onclick="return konfirmasiHapus('<?= htmlspecialchars($row['nama'], ENT_QUOTES); ?>');">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Menghubungkan file JavaScript -->
    <script src="script.js"></script>
</body>
</html>