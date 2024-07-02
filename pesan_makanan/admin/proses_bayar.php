<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $kembalian = $_POST['kembalian'];

    $sql = "UPDATE transaksi SET jumlah_bayar = '$jumlah_bayar', kembalian = '$kembalian', status = 'Selesai' WHERE id = '$id'";

    if (mysqli_query($koneksi, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
}

mysqli_close($koneksi);
?>