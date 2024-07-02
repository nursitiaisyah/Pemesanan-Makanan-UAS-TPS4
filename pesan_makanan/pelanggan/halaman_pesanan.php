<?php
session_start(); // Memulai sesi

include 'koneksi.php';

// Pastikan pengguna login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

// Ambil peran pengguna dari sesi
$role = $_SESSION['role'];
$userId = $_SESSION['user_id'];

// Query untuk mendapatkan data pesanan berdasarkan peran pengguna
if ($role === 'admin') {
    $sql = "SELECT pesanan.id, users.nama_lengkap, GROUP_CONCAT(menu_makanan.nama SEPARATOR ', ') AS nama_menu, pesanan.nomor_pesanan, pesanan.total_harga, pesanan.status, pesanan.tanggal_dibuat 
            FROM pesanan 
            JOIN users ON pesanan.users_id = users.id 
            JOIN pesanan_menu ON pesanan.id = pesanan_menu.pesanan_id
            JOIN menu_makanan ON pesanan_menu.menu_makanan_id = menu_makanan.id
            GROUP BY pesanan.id";
} else {
    $sql = "SELECT pesanan.id, users.nama_lengkap, GROUP_CONCAT(menu_makanan.nama SEPARATOR ', ') AS nama_menu, pesanan.nomor_pesanan, pesanan.total_harga, pesanan.status, pesanan.tanggal_dibuat 
            FROM pesanan 
            JOIN users ON pesanan.users_id = users.id 
            JOIN pesanan_menu ON pesanan.id = pesanan_menu.pesanan_id
            JOIN menu_makanan ON pesanan_menu.menu_makanan_id = menu_makanan.id
            WHERE pesanan.users_id = '$userId'
            GROUP BY pesanan.id";
}

$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATA PESANAN</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/Logo2.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <link href="../assets/styles.css" rel="stylesheet">
    <style>
        body {
            margin-top: -30px;
        }

        .form-control {
            width: 10px;
            /* Atur lebar sesuai kebutuhan */
            max-width: 50%;
            /* Maksimum lebar sesuai parentnya */
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
                        <a class="nav-link active" aria-current="page" href="halaman_pelanggan.php">Data Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="halaman_pesanan.php">Data Pesanan</a>
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
        <h2>Data Pesanan</h2>
        <!-- Add Button -->
        <?php if ($role === 'admin') { ?>
            <div class="d-flex justify-content-start mt-2">
                <a href="tambah_pesanan.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Tambah Pesanan</a>
            </div>
        <?php } ?>
        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Nama Menu</th>
                        <th>Nomor Pesanan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <?php if ($role === 'admin') { ?>
                            <th>Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody id="pesananTable">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . $row['nama_lengkap'] . "</td>";
                            echo "<td>" . $row['nama_menu'] . "</td>";
                            echo "<td>" . $row['nomor_pesanan'] . "</td>";
                            echo "<td>" . $row['total_harga'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>" . $row['tanggal_dibuat'] . "</td>";
                            if ($role === 'admin') {
                                echo "<td>
                                        <a href='edit_pesanan.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i></a>
                                        <a href='hapus_pesanan.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a>
                                      </td>";
                            }
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
mysqli_close($koneksi);
?>