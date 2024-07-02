<?php
session_start(); // Memulai sesi

include 'koneksi.php';

// Pastikan pengguna login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['nama_lengkap'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

// Mengambil data menu makanan untuk form select
$menuQuery = "SELECT id, nama, harga, url_gambar FROM menu_makanan";
$menuResult = mysqli_query($koneksi, $menuQuery);

// Generate Nomor Pesanan Otomatis
$lastOrderQuery = "SELECT nomor_pesanan FROM pesanan ORDER BY id DESC LIMIT 1";
$lastOrderResult = mysqli_query($koneksi, $lastOrderQuery);
$lastOrderNumber = mysqli_fetch_assoc($lastOrderResult)['nomor_pesanan'];

if ($lastOrderNumber) {
    $lastNumber = (int) substr($lastOrderNumber, 1);
    $newOrderNumber = "P" . str_pad($lastNumber + 1, 5, "0", STR_PAD_LEFT);
} else {
    $newOrderNumber = "P00001";
}

// Menangani pengiriman form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users_id = $_SESSION['user_id'];
    $menu_makanan_ids = json_decode($_POST['menu_makanan_id']); // Array of selected menu items
    $nomor_pesanan = $_POST['nomor_pesanan'];
    $total_harga = $_POST['total_harga'];
    $status = 'Pending';
    $tanggal_dibuat = date('Y-m-d H:i:s');

    // Insert pesanan
    $insertPesananQuery = "INSERT INTO pesanan (users_id, nomor_pesanan, total_harga, status, tanggal_dibuat)
                           VALUES ('$users_id', '$nomor_pesanan', '$total_harga', '$status', '$tanggal_dibuat')";
    if (mysqli_query($koneksi, $insertPesananQuery)) {
        $pesanan_id = mysqli_insert_id($koneksi);

        // Insert each selected menu item
        foreach ($menu_makanan_ids as $menu_makanan_id) {
            $insertMenuQuery = "INSERT INTO pesanan_menu (pesanan_id, menu_makanan_id) VALUES ('$pesanan_id', '$menu_makanan_id')";
            mysqli_query($koneksi, $insertMenuQuery);
        }

        // Insert new transaction into the transaksi table
        $insertTransaksiQuery = "INSERT INTO transaksi (users_id, nomor_pesanan, total_harga, jumlah_bayar, kembalian, status, tanggal_transaksi)
                                 VALUES ('$users_id', '$nomor_pesanan', '$total_harga', 0, 0, 'Pending', '$tanggal_dibuat')";
        if (mysqli_query($koneksi, $insertTransaksiQuery)) {
            echo "<script>alert('Pesanan dan transaksi berhasil ditambahkan!'); window.location.href='halaman_pesanan.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan transaksi!');</script>";
        }
    } else {
        echo "<script>alert('Gagal menambahkan pesanan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAFTAR MENU</title>
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

        .menu-card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            border-radius: 5px;
            margin-bottom: 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 90%;
        }

        .menu-card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .menu-card img {
            border-radius: 5px 5px 0 0;
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .container-menu {
            display: flex;
        }

        .menu-list {
            flex: 3;
        }

        .order-details {
            flex: 1;
            padding-left: 20px;
        }

        .selected-menu-list {
            list-style: none;
            padding: 0;
        }

        .selected-menu-list li {
            background: #f9f9f9;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
        }

        .btn-remove {
            color: red;
            cursor: pointer;
        }


        .container h4 {
            text-align: center;
            margin-top: -10px;
            /* Adjust the value as needed to move the text closer to the image */
            font-size: 20px;
            /* Adjust this value to change the font size */
        }

        .container .price {
            text-align: center;
            margin: 10px 0;
            /* Adjust the value as needed */
        }

        .container .add-menu-button {
            display: block;
            margin: 10px auto;
            /* Adjust the value as needed */
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
    <div class="container mt-5 container-menu">
        <!-- Daftar Menu -->
        <div class="menu-list">
            <h2>Daftar Menu</h2>
            <div class="row">
                <?php while ($menu = mysqli_fetch_assoc($menuResult)) { ?>
                    <div class="col-md-4 d-flex">
                        <div class="menu-card flex-fill">
                            <img src="<?php echo '../uploads/' . $menu['url_gambar']; ?>" alt="Menu Image"
                                style="width:100%">
                            <div class="container p-2">
                                <h4><b><?php echo $menu['nama']; ?></b></h4>
                                <p class="price"><?php echo 'Rp. ' . number_format($menu['harga'], 0, ',', '.'); ?></p>
                                <button class="btn btn-primary add-menu-button" data-id="<?php echo $menu['id']; ?>"
                                    data-nama="<?php echo $menu['nama']; ?>"
                                    data-harga="<?php echo $menu['harga']; ?>">Pesan</button>
                            </div>

                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- Detail Pesanan -->
        <div class="order-details">
            <h2>Detail Pesanan</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="nomor_pesanan" class="form-label">No Pesanan</label>
                    <input type="text" class="form-control" id="nomor_pesanan" name="nomor_pesanan"
                        value="<?php echo $newOrderNumber; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="users_id" class="form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="users_id" name="users_id"
                        value="<?php echo $_SESSION['nama_lengkap']; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Menu yang dipilih</label>
                    <ul id="selectedMenuList" class="selected-menu-list"></ul>
                </div>
                <div class="mb-3">
                    <label for="total_harga" class="form-label">Total Harga</label>
                    <input type="number" class="form-control" id="total_harga" name="total_harga" readonly required>
                </div>
                <button type="submit" class="btn btn-primary">Buat Pesanan</button>
                <button type="button" class="btn btn-danger" id="clearOrderButton">Hapus Pesanan</button>
            </form>
        </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.add-menu-button').forEach(function (button) {
            button.addEventListener('click', function () {
                var menuId = this.getAttribute('data-id');
                var menuNama = this.getAttribute('data-nama');
                var menuHarga = parseFloat(this.getAttribute('data-harga'));

                var selectedMenuList = document.getElementById('selectedMenuList');
                var newMenuItem = document.createElement('li');
                newMenuItem.setAttribute('data-id', menuId);
                newMenuItem.setAttribute('data-harga', menuHarga);
                newMenuItem.innerHTML = menuNama + ' - ' + menuHarga.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) +
                    ' <span class="btn-remove">x</span>';
                selectedMenuList.appendChild(newMenuItem);

                var totalHargaInput = document.getElementById('total_harga');
                var currentTotal = parseFloat(totalHargaInput.value) || 0;
                totalHargaInput.value = currentTotal + menuHarga;
            });
        });

        document.getElementById('selectedMenuList').addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-remove')) {
                var menuItem = e.target.parentElement;
                var menuHarga = parseFloat(menuItem.getAttribute('data-harga'));

                var totalHargaInput = document.getElementById('total_harga');
                var currentTotal = parseFloat(totalHargaInput.value) || 0;
                totalHargaInput.value = currentTotal - menuHarga;

                menuItem.remove();
            }
        });

        document.querySelector('form').addEventListener('submit', function (e) {
            var selectedMenuList = document.getElementById('selectedMenuList').children;
            var menuIds = [];
            for (var i = 0; i < selectedMenuList.length; i++) {
                menuIds.push(selectedMenuList[i].getAttribute('data-id'));
            }
            var menuIdsInput = document.createElement('input');
            menuIdsInput.type = 'hidden';
            menuIdsInput.name = 'menu_makanan_id';
            menuIdsInput.value = JSON.stringify(menuIds);
            this.appendChild(menuIdsInput);
        });

        document.getElementById('clearOrderButton').addEventListener('click', function () {
            document.getElementById('selectedMenuList').innerHTML = '';
            document.getElementById('total_harga').value = 0;
        });
    </script>
</body>

</html>