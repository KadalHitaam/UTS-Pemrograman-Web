<?php
include 'koneksi.php';

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';

// --- PROSES TAMBAH & EDIT DATA ---
if ($aksi == 'tambah' || $aksi == 'edit') {
    $id      = $_POST['id'] ?? '';
    $nim     = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $foto_lama = $_POST['foto_lama'] ?? '';
    
    $nama_foto = $foto_lama;

    // Cek unggahan foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $file_name = $_FILES['foto']['name'];
        $file_size = $_FILES['foto']['size'];
        $file_tmp  = $_FILES['foto']['tmp_name'];
        
        $x = explode('.', $file_name);
        $ekstensi = strtolower(end($x));
        $ekstensi_diperbolehkan = array('jpg', 'png', 'jpeg');

        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            if ($file_size <= 2097152) { // 2MB
                $nama_foto_baru = time() . '_' . uniqid() . '.' . $ekstensi;
                $path = 'uploads/' . $nama_foto_baru;

                if (move_uploaded_file($file_tmp, $path)) {
                    $nama_foto = $nama_foto_baru;
                    
                    if ($aksi == 'edit' && $foto_lama != "" && file_exists("uploads/" . $foto_lama)) {
                        unlink("uploads/" . $foto_lama);
                    }
                } else {
                    echo "<script>alert('Gagal mengunggah gambar.'); window.history.back();</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Ukuran file terlalu besar. Maksimal 2MB.'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Ekstensi file tidak diperbolehkan.'); window.history.back();</script>";
            exit;
        }
    }

    if ($aksi == 'tambah') {
        $query = "INSERT INTO mahasiswa (nim, nama, jurusan, foto) VALUES ('$nim', '$nama', '$jurusan', '$nama_foto')";
    } else if ($aksi == 'edit') {
        $query = "UPDATE mahasiswa SET nim='$nim', nama='$nama', jurusan='$jurusan', foto='$nama_foto' WHERE id='$id'";
    }

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil disimpan!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// --- PROSES HAPUS DATA ---
if ($aksi == 'hapus') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $query_foto = mysqli_query($koneksi, "SELECT foto FROM mahasiswa WHERE id='$id'");
        $data_foto = mysqli_fetch_assoc($query_foto);
        
        if ($data_foto['foto'] != "" && file_exists("uploads/" . $data_foto['foto'])) {
            unlink("uploads/" . $data_foto['foto']);
        }

        $query = "DELETE FROM mahasiswa WHERE id='$id'";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
}

?>