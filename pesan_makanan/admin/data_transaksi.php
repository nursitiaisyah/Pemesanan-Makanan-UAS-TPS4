<?php
include 'koneksi.php';

// Query untuk mendapatkan data transaksi
$sql = "SELECT transaksi.id, transaksi.nomor_pesanan, transaksi.tanggal_transaksi, users.nama_lengkap, GROUP_CONCAT(menu_makanan.nama SEPARATOR ', ') AS nama_menu, transaksi.total_harga, transaksi.jumlah_bayar, transaksi.kembalian, transaksi.status 
        FROM transaksi 
        JOIN users ON transaksi.users_id = users.id 
        JOIN pesanan ON transaksi.nomor_pesanan = pesanan.nomor_pesanan
        JOIN pesanan_menu ON pesanan.id = pesanan_menu.pesanan_id
        JOIN menu_makanan ON pesanan_menu.menu_makanan_id = menu_makanan.id
        GROUP BY transaksi.id";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <link href="../assets/styles.css" rel="stylesheet">
    <style>
        body {
            margin-top: -30px;
        }

        .form-control {
            width: 100px;
            /* Menyesuaikan lebar kolom */
            max-width: 100%;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">AYAM GEPREK NUSANTARA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="halaman_admin.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="data_menu.php">Data Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="data_pesanan.php">Data Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="data_pembayaran.php">Data Pembayaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="data_pelanggan.php">Data Pelanggan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="data_transaksi.php">Data Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar -->

    <div class="container mt-5">
        <h2>Data Transaksi</h2>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>No. Pesanan</th>
                        <th>Tanggal Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Nama Menu</th>
                        <th>Total Harga</th>
                        <th>Jumlah Bayar</th>
                        <th>Kembalian</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="transaksiTable">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . $row['nomor_pesanan'] . "</td>";
                            echo "<td>" . $row['tanggal_transaksi'] . "</td>";
                            echo "<td>" . $row['nama_lengkap'] . "</td>";
                            echo "<td>" . $row['nama_menu'] . "</td>";
                            echo "<td class='total-harga' id='total_harga_" . $row['id'] . "'>" . $row['total_harga'] . "</td>";
                            echo "<td><input type='number' class='form-control jumlah-bayar' data-id='" . $row['id'] . "' value='" . $row['jumlah_bayar'] . "'></td>";
                            echo "<td class='kembalian' id='kembalian_" . $row['id'] . "'>" . $row['kembalian'] . "</td>";
                            echo "<td class='status' id='status_" . $row['id'] . "'>" . $row['status'] . "</td>";
                            echo "<td><button class='btn btn-success bayar' data-id='" . $row['id'] . "'>Bayar</button></td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.jumlah-bayar').on('input', function () {
                var id = $(this).data('id');
                var jumlahBayar = parseFloat($(this).val());
                var totalHarga = parseFloat($('#total_harga_' + id).text());
                var kembalian = jumlahBayar - totalHarga;
                if (!isNaN(kembalian)) {
                    $('#kembalian_' + id).text(kembalian);
                }
            });

            $('.bayar').on('click', function () {
                var id = $(this).data('id');
                var jumlahBayar = parseFloat($('.jumlah-bayar[data-id="' + id + '"]').val());
                var totalHarga = parseFloat($('#total_harga_' + id).text());
                var kembalian = jumlahBayar - totalHarga;

                if (jumlahBayar < totalHarga) {
                    alert('Jumlah bayar tidak boleh kurang dari total harga');
                    return;
                }

                // AJAX request to update the status and save the pembayaran
                $.ajax({
                    url: 'proses_bayar.php',
                    method: 'POST',
                    data: {
                        id: id,
                        jumlah_bayar: jumlahBayar,
                        kembalian: kembalian
                    },
                    success: function (response) {
                        if (response == "success") {
                            $('#status_' + id).text('Selesai');
                            alert('Pembayaran berhasil!');
                        } else {
                            alert('Pembayaran gagal!');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>

<?php
mysqli_close($koneksi);
?>