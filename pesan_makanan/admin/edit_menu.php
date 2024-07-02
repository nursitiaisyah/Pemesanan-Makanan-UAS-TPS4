<?php
include 'koneksi.php';

$id = $_GET['id'];
$sql = "SELECT * FROM menu_makanan WHERE id = $id";
$result = mysqli_query($koneksi, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "Menu tidak ditemukan!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_menu = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);

    // Penanganan unggahan file
    $gambar_menu = $row['url_gambar']; // Pertahankan gambar lama jika tidak ada file baru yang diunggah
    if (isset($_FILES['gambar_menu']) && $_FILES['gambar_menu']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["gambar_menu"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Periksa apakah file benar-benar gambar
        $check = getimagesize($_FILES["gambar_menu"]["tmp_name"]);
        if ($check !== false) {
            // Periksa ukuran file (batas 2MB)
            if ($_FILES["gambar_menu"]["size"] <= 2000000) {
                // Izinkan jenis file tertentu
                if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                    if (move_uploaded_file($_FILES["gambar_menu"]["tmp_name"], $target_file)) {
                        $gambar_menu = $target_file;
                    } else {
                        echo "Maaf, terjadi kesalahan saat mengunggah file Anda.";
                    }
                } else {
                    echo "Maaf, hanya file JPG, JPEG, & PNG yang diperbolehkan.";
                }
            } else {
                echo "Maaf, ukuran file Anda terlalu besar.";
            }
        } else {
            echo "File bukan gambar.";
        }
    }

    $sql = "UPDATE menu_makanan SET nama='$nama_menu', deskripsi='$deskripsi', harga='$harga', url_gambar='$gambar_menu' WHERE id=$id";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>
                alert('Menu berhasil diperbarui');
                window.location.href = 'data_menu.php';
              </script>";
    } else {
        echo "Kesalahan saat memperbarui data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT MENU</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/Logo2.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <link href="../assets/styles.css" rel="stylesheet">
    <style>
        body {
            margin-top: -30px;
        }

        .container {
            padding-top: -40px;
            padding-bottom: 20px;
        }
    </style>

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
        <h2 class="mb-4">Edit Menu</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_menu" class="form-label">Nama Menu</label>
                <input type="text" class="form-control" id="nama_menu" name="nama_menu"
                    value="<?php echo $row['nama']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                    required><?php echo $row['deskripsi']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $row['harga']; ?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="gambar_menu" class="form-label">Gambar Menu</label>
                <input type="file" class="form-control" id="gambar_menu" name="gambar_menu">
                <img src="<?php echo $row['url_gambar']; ?>" alt="Gambar Menu" class="img-fluid mt-2"
                    style="max-width: 200px;">
            </div>
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="data_menu.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>

<?php
mysqli_close($koneksi);
?>