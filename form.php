<?php
include 'koneksi.php';

$id = ""; $nim = ""; $nama = ""; $jurusan = ""; $foto = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query);
    if ($data) {
        $nim = $data['nim'];
        $nama = $data['nama'];
        $jurusan = $data['jurusan'];
        $foto = $data['foto'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($id) ? 'Edit' : 'Tambah' ?> Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container" style="max-width: 600px;">
        <h2><?= ($id) ? 'Edit' : 'Tambah' ?> Data Mahasiswa</h2>

        <!-- Atribut onsubmit memanggil fungsi dari script.js -->
        <form action="proses.php?aksi=<?= ($id) ? 'edit' : 'tambah' ?>" method="POST" enctype="multipart/form-data" onsubmit="return validasiForm()">
            <input type="hidden" id="id" name="id" value="<?= $id ?>">
            <input type="hidden" name="foto_lama" value="<?= $foto ?>">

            <div class="form-group">
                <label>NIM</label>
                <input type="text" id="nim" name="nim" value="<?= htmlspecialchars($nim) ?>" placeholder="Masukkan NIM...">
            </div>
            
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($nama) ?>" placeholder="Masukkan Nama Lengkap...">
            </div>
            
            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" id="jurusan" name="jurusan" value="<?= htmlspecialchars($jurusan) ?>" placeholder="Contoh: Teknik Informatika">
            </div>
            
            <div class="form-group">
                <label>Foto Profil (JPG/JPEG/PNG, Maks 2MB)</label>
                <?php if ($foto): ?>
                    <div style="margin-bottom: 10px;">
                        <img src="uploads/<?= $foto ?>" class="thumbnail" alt="Foto Saat Ini">
                        <p><small style="color: #666;">Biarkan kosong jika tidak ingin mengubah foto.</small></p>
                    </div>
                <?php endif; ?>
                <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-submit">Simpan Data</button>
                <a href="index.php" class="btn btn-cancel">Batal</a>
            </div>
        </form>
    </div>

    <!-- Menghubungkan file JavaScript -->
    <script src="script.js"></script>
</body>
</html>