<?php
include 'koneksi.php';

// Memeriksa apakah form pencarian telah disubmit
if (isset($_POST['pencarian'])) {
    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    // Query untuk mendapatkan data transaksi sesuai dengan rentang tanggal
    $sql = "SELECT transaksi.id, transaksi.nomor_pesanan, transaksi.tanggal_transaksi, users.nama_lengkap, GROUP_CONCAT(menu_makanan.nama SEPARATOR ', ') AS nama_menu, transaksi.total_harga, transaksi.jumlah_bayar, transaksi.kembalian, transaksi.status 
            FROM transaksi 
            JOIN users ON transaksi.users_id = users.id 
            JOIN pesanan ON transaksi.nomor_pesanan = pesanan.nomor_pesanan
            JOIN pesanan_menu ON pesanan.id = pesanan_menu.pesanan_id
            JOIN menu_makanan ON pesanan_menu.menu_makanan_id = menu_makanan.id
            WHERE transaksi.tanggal_transaksi BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            GROUP BY transaksi.id";
} else {
    // Default query untuk mendapatkan semua data transaksi
    $sql = "SELECT transaksi.id, transaksi.nomor_pesanan, transaksi.tanggal_transaksi, users.nama_lengkap, GROUP_CONCAT(menu_makanan.nama SEPARATOR ', ') AS nama_menu, transaksi.total_harga, transaksi.jumlah_bayar, transaksi.kembalian, transaksi.status 
            FROM transaksi 
            JOIN users ON transaksi.users_id = users.id 
            JOIN pesanan ON transaksi.nomor_pesanan = pesanan.nomor_pesanan
            JOIN pesanan_menu ON pesanan.id = pesanan_menu.pesanan_id
            JOIN menu_makanan ON pesanan_menu.menu_makanan_id = menu_makanan.id
            GROUP BY transaksi.id";
}

$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATA LAPORAN</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/Logo2.png">
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

        @media print {

            .print-button,
            .search-form {
                display: none;
            }

            .navbar,
            footer {
                display: none;
            }
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
                        <a class="nav-link active" aria-current="page" href="data_laporan.php">Data Laporan</a>
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
        <h2>Data Laporan</h2>

        <!-- Form Pencarian Tanggal -->
        <form method="post" class="search-form mb-3">
            <div class="row">
                <div class="col-md-3">
                    <label for="tanggal_awal">Tanggal Pembayaran Awal</label>
                    <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="tanggal_akhir">Tanggal Pembayaran Akhir</label>
                    <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control" required>
                </div>
                <div class="col-md-3 align-self-end">
                    <button type="submit" name="pencarian" class="btn btn-danger">Pencarian</button>
                </div>
            </div>
        </form>

        <!-- Tombol Print -->
        <button class="btn btn-primary mb-3 print-button" onclick="window.print()">Print</button>

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
                    </tr>
                </thead>
                <tbody id="laporanTable">
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
                            echo "<td>" . $row['total_harga'] . "</td>";
                            echo "<td>" . $row['jumlah_bayar'] . "</td>";
                            echo "<td>" . $row['kembalian'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>

<?php
mysqli_close($koneksi);
?>