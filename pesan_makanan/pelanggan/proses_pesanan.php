<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = mysqli_real_escape_string($koneksi, $_POST['customerName']);
    $orderDetails = mysqli_real_escape_string($koneksi, $_POST['orderDetails']);
    $orderTotal = mysqli_real_escape_string($koneksi, $_POST['orderTotal']);

    // Cari pengguna berdasarkan nama pelanggan
    $sql_user = "SELECT id FROM users WHERE nama_lengkap = '$customerName' LIMIT 1";
    $result_user = mysqli_query($koneksi, $sql_user);
    $row_user = mysqli_fetch_assoc($result_user);

    if ($row_user) {
        $users_id = $row_user['id']; // Ubah ke users_id sesuai dengan nama kolom yang ada di tabel pesanan

        // Ambil nomor pesanan terakhir dari database
        $sql = "SELECT nomor_pesanan FROM pesanan ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($koneksi, $sql);
        $row = mysqli_fetch_assoc($result);

        // Generate nomor pesanan baru
        if ($row) {
            $lastOrderNumberNumeric = intval(substr($row['nomor_pesanan'], 2));
            $newOrderNumberNumeric = $lastOrderNumberNumeric + 1;
            $newOrderNumber = 'PG' . str_pad($newOrderNumberNumeric, 6, '0', STR_PAD_LEFT);
        } else {
            $newOrderNumber = 'PG000001';
        }

        // Masukkan data pesanan ke tabel pesanan
        $sql_insert = "INSERT INTO pesanan (nomor_pesanan, users_id, total_harga, status) VALUES ('$newOrderNumber', '$users_id', '$orderTotal', 'pending')";

        if (mysqli_query($koneksi, $sql_insert)) {
            echo "<script>
                    alert('Pesanan berhasil dibuat! No Pesanan: $newOrderNumber');
                    window.location.href = 'halaman_pelanggan.php';
                  </script>";
        } else {
            echo "Kesalahan saat membuat pesanan: " . mysqli_error($koneksi);
        }
    } else {
        echo "Pengguna dengan nama $customerName tidak ditemukan.";
    }

    mysqli_close($koneksi);
}
?>