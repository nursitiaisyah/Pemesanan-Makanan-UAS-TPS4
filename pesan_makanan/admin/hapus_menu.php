<?php
// Include file koneksi.php untuk menghubungkan ke database
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mendapatkan informasi gambar
    $sql = "SELECT url_gambar FROM menu_makanan WHERE id = $id"; // Ubah 'gambar_menu' menjadi 'url_gambar'
    $result = mysqli_query($koneksi, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Hapus gambar dari server
        $gambar_menu = $row['url_gambar']; // Ubah 'gambar_menu' menjadi 'url_gambar'
        if (file_exists($gambar_menu)) {
            unlink($gambar_menu);
        }

        // Hapus data menu dari database
        $sql_delete = "DELETE FROM menu_makanan WHERE id = $id";
        if (mysqli_query($koneksi, $sql_delete)) {
            header("Location: data_menu.php?message=Menu berhasil dihapus");
        } else {
            echo "Kesalahan saat menghapus data: " . mysqli_error($koneksi);
        }
    } else {
        echo "Menu tidak ditemukan!";
    }
} else {
    echo "ID tidak ditemukan!";
}

mysqli_close($koneksi);
?>