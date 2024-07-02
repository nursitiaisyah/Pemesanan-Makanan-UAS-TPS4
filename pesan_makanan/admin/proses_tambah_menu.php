<?php
include 'koneksi.php';

// Buat folder uploads jika belum ada
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_menu = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["gambar_menu"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["gambar_menu"]["tmp_name"]);
    if ($check === false) {
        die("File yang diunggah bukan gambar.");
    }

    // Check file size (max 2MB)
    if ($_FILES["gambar_menu"]["size"] > 2000000) {
        die("Maaf, ukuran file terlalu besar. Maksimum 2MB.");
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        die("Maaf, hanya file JPG, JPEG, & PNG yang diizinkan.");
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        die("Maaf, file sudah ada.");
    }

    // Try to upload file
    if (!move_uploaded_file($_FILES["gambar_menu"]["tmp_name"], $target_file)) {
        die("Maaf, terjadi kesalahan saat mengunggah file.");
    }

    // Insert data into database
    $sql = "INSERT INTO menu_makanan (nama, deskripsi, harga, url_gambar) VALUES ('$nama_menu', '$deskripsi', '$harga', '$target_file')";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>
                alert('Menu berhasil ditambahkan');
                window.location.href = 'data_menu.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }

    mysqli_close($koneksi);
}
?>