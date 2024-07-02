<?php
include 'koneksi.php';

// Mengambil data pengguna dan menu makanan untuk form select
$usersQuery = "SELECT id, nama_lengkap FROM users";
$usersResult = mysqli_query($koneksi, $usersQuery);

$menuQuery = "SELECT id, nama, harga FROM menu_makanan";
$menuResult = mysqli_query($koneksi, $menuQuery);

// Mengambil data pesanan berdasarkan ID
if (isset($_GET['id'])) {
    $pesanan_id = $_GET['id'];
    $pesananQuery = "SELECT * FROM pesanan WHERE id = '$pesanan_id'";
    $pesananResult = mysqli_query($koneksi, $pesananQuery);
    $pesanan = mysqli_fetch_assoc($pesananResult);

    // Mengambil data menu yang dipilih untuk pesanan ini
    $pesananMenuQuery = "SELECT menu_makanan_id FROM pesanan_menu WHERE pesanan_id = '$pesanan_id'";
    $pesananMenuResult = mysqli_query($koneksi, $pesananMenuQuery);
    $selectedMenuIds = [];
    while ($row = mysqli_fetch_assoc($pesananMenuResult)) {
        $selectedMenuIds[] = $row['menu_makanan_id'];
    }
}

// Menangani pengiriman form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users_id = $_POST['users_id'];
    $menu_makanan_ids = json_decode($_POST['menu_makanan_id']); // Array of selected menu items
    $nomor_pesanan = $_POST['nomor_pesanan'];
    $total_harga = $_POST['total_harga'];
    $status = $_POST['status'];
    $tanggal_dibuat = date('Y-m-d H:i:s');

    // Update pesanan
    $updatePesananQuery = "UPDATE pesanan SET users_id = '$users_id', nomor_pesanan = '$nomor_pesanan', total_harga = '$total_harga', status = '$status', tanggal_dibuat = '$tanggal_dibuat' WHERE id = '$pesanan_id'";
    if (mysqli_query($koneksi, $updatePesananQuery)) {
        // Delete old menu items
        $deleteMenuQuery = "DELETE FROM pesanan_menu WHERE pesanan_id = '$pesanan_id'";
        mysqli_query($koneksi, $deleteMenuQuery);

        // Insert new selected menu items
        foreach ($menu_makanan_ids as $menu_makanan_id) {
            $insertMenuQuery = "INSERT INTO pesanan_menu (pesanan_id, menu_makanan_id) VALUES ('$pesanan_id', '$menu_makanan_id')";
            mysqli_query($koneksi, $insertMenuQuery);
        }

        echo "<script>alert('Pesanan berhasil diubah!'); window.location.href='data_pesanan.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah pesanan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/Logo2.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <link href="../assets/styles.css" rel="stylesheet">
    <style>
        body {
            margin-top: -30px;
        }

        .form-control {
            width: 100%;
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
        <h2>Edit Pesanan</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nomor_pesanan" class="form-label">No Pesanan</label>
                <input type="text" class="form-control" id="nomor_pesanan" name="nomor_pesanan"
                    value="<?php echo $pesanan['nomor_pesanan']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="users_id" class="form-label">Nama Pelanggan</label>
                <select class="form-select" id="users_id" name="users_id" required>
                    <option value="">Pilih Pelanggan</option>
                    <?php
                    while ($user = mysqli_fetch_assoc($usersResult)) {
                        $selected = $user['id'] == $pesanan['users_id'] ? 'selected' : '';
                        echo "<option value='" . $user['id'] . "' $selected>" . $user['nama_lengkap'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="menu_makanan_id" class="form-label">Nama Menu</label>
                <select class="form-select" id="menu_makanan_id">
                    <?php
                    while ($menu = mysqli_fetch_assoc($menuResult)) {
                        echo "<option value='" . $menu['id'] . "' data-harga='" . $menu['harga'] . "'>" . $menu['nama'] . "</option>";
                    }
                    ?>
                </select>
                <button type="button" class="btn btn-primary mt-2" id="addMenuButton">Tambah Menu</button>
            </div>
            <div class="mb-3">
                <label class="form-label">Menu yang dipilih</label>
                <ul id="selectedMenuList">
                    <?php
                    foreach ($selectedMenuIds as $menuId) {
                        $menuQuery = "SELECT nama, harga FROM menu_makanan WHERE id = '$menuId'";
                        $menuResult = mysqli_query($koneksi, $menuQuery);
                        $menu = mysqli_fetch_assoc($menuResult);
                        echo "<li data-id='" . $menuId . "' data-harga='" . $menu['harga'] . "'>" . $menu['nama'] . " - " . $menu['harga'] . " <button class='btn btn-danger btn-sm ms-2'>Hapus</button></li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="number" class="form-control" id="total_harga" name="total_harga"
                    value="<?php echo $pesanan['total_harga']; ?>" readonly required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status Pesanan</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Pending" <?php echo $pesanan['status'] == 'Pending' ? 'selected' : ''; ?>>Pending
                    </option>
                    <option value="Proses" <?php echo $pesanan['status'] == 'Proses' ? 'selected' : ''; ?>>Proses</option>
                    <option value="Selesai" <?php echo $pesanan['status'] == 'Selesai' ? 'selected' : ''; ?>>Selesai
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="data_pesanan.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('addMenuButton').addEventListener('click', function () {
            var menuSelect = document.getElementById('menu_makanan_id');
            var selectedMenuId = menuSelect.value;
            var selectedMenuText = menuSelect.options[menuSelect.selectedIndex].text;
            var selectedMenuHarga = parseFloat(menuSelect.options[menuSelect.selectedIndex].getAttribute('data-harga'));

            if (selectedMenuId) {
                var selectedMenuList = document.getElementById('selectedMenuList');
                var listItem = document.createElement('li');
                listItem.textContent = selectedMenuText + ' - ' + selectedMenuHarga;
                listItem.setAttribute('data-id', selectedMenuId);
                listItem.setAttribute('data-harga', selectedMenuHarga);

                var removeButton = document.createElement('button');
                removeButton.textContent = 'Hapus';
                removeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');
                removeButton.addEventListener('click', function () {
                    selectedMenuList.removeChild(listItem);
                    updateTotalHarga();
                });

                listItem.appendChild(removeButton);
                selectedMenuList.appendChild(listItem);
                updateTotalHarga();
            }
        });

        function updateTotalHarga() {
            var selectedMenuListItems = document.getElementById('selectedMenuList').getElementsByTagName('li');
            var totalHarga = 0;
            for (var i = 0; i < selectedMenuListItems.length; i++) {
                totalHarga += parseFloat(selectedMenuListItems[i].getAttribute('data-harga'));
            }
            document.getElementById('total_harga').value = totalHarga;
        }

        document.querySelector('form').addEventListener('submit', function (event) {
            var selectedMenuIds = [];
            var selectedMenuListItems = document.getElementById('selectedMenuList').getElementsByTagName('li');
            for (var i = 0; i < selectedMenuListItems.length; i++) {
                selectedMenuIds.push(selectedMenuListItems[i].getAttribute('data-id'));
            }

            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'menu_makanan_id';
            hiddenInput.value = JSON.stringify(selectedMenuIds);

            this.appendChild(hiddenInput);
        });

        // Menghapus event listener Hapus pada elemen menu yang sudah ada
        document.querySelectorAll('#selectedMenuList .btn-danger').forEach(button => {
            button.addEventListener('click', function () {
                this.parentElement.remove();
                updateTotalHarga();
            });
        });
    </script>
</body>

</html>

<?php
mysqli_close($koneksi);
?>