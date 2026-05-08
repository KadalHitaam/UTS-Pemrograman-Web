// Fungsi validasi sebelum form disubmit
function validasiForm() {
    let id = document.getElementById('id').value;
    let nim = document.getElementById('nim').value.trim();
    let nama = document.getElementById('nama').value.trim();
    let jurusan = document.getElementById('jurusan').value.trim();
    let foto = document.getElementById('foto');

    // 1. Validasi field tidak boleh kosong
    if (nim === "" || nama === "" || jurusan === "") {
        alert("Peringatan: NIM, Nama, dan Jurusan wajib diisi!");
        return false;
    }

    // 2. Validasi file gambar (jika ada file yang dipilih)
    if (foto.files.length > 0) {
        let file = foto.files[0];
        let allowedTypes = ["image/jpeg", "image/jpg", "image/png"];
        let maxSize = 2 * 1024 * 1024; // 2 MB

        if (!allowedTypes.includes(file.type)) {
            alert("Gagal: File harus berupa gambar (JPG, JPEG, atau PNG).");
            return false;
        }

        if (file.size > maxSize) {
            alert("Gagal: Ukuran file foto maksimal 2 MB.");
            return false;
        }
    } else {
        // Jika sedang tambah data baru (ID kosong) dan foto tidak dipilih
        if (id === "") {
            alert("Peringatan: Foto profil wajib diunggah untuk mahasiswa baru!");
            return false;
        }
    }

    return true; // Lolos validasi, form dilanjutkan ke server
}

// Fungsi konfirmasi sebelum menghapus data
function konfirmasiHapus(namaMahasiswa) {
    return confirm("Apakah Anda yakin ingin menghapus data mahasiswa bernama " + namaMahasiswa + "?");
}