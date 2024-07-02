<?php
include 'koneksi.php';

// Query untuk mendapatkan data menu
$sql = "SELECT * FROM menu_makanan";
$result = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DATA MENU</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/Logo2.png">
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="../assets/styles.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
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
            <a class="nav-link active" aria-current="page" href="halaman_admin.php">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="data_menu.php">Data Menu</a>
          </li>
          </li>

          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="data_pesanan.php">Data Pesanan</a>
          </li>

          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="data_transaksi.php">Data Pembayaran</a>
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
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navbar -->

  <div class="container mt-5">
    <h2 class="mb-4">Data Menu</h2>
    <!-- Add Button -->
    <div class="d-flex justify-content-start mt-2">
      <a href="tambah_menu.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Tambah Menu</a>
    </div>

    <!-- Search Input -->
    <div class="row mb-3">
      <div class="col-md-5 offset-md-9 d-flex justify-content-end">
        <div class="input-group">
          <input type="text" id="searchInput" class="form-control" placeholder="Cari...">
          <button class="btn btn-outline-secondary" type="button" id="button-search">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="thead-dark">
          <tr>
            <th>No</th>
            <th>Nama Menu</th>
            <th>Gambar Menu</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody id="menuTable">
          <?php
          if (mysqli_num_rows($result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $no . "</td>";
              echo "<td>" . $row['nama'] . "</td>";
              echo "<td><img src='" . $row['url_gambar'] . "' alt='" . $row['nama'] . "' class='img-fluid' style='max-width: 100px;'></td>";
              echo "<td>" . $row['deskripsi'] . "</td>";
              echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
              echo "<td>
                                <a href='edit_menu.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Edit</a>
                                <a href='hapus_menu.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Hapus</a>
                              </td>";
              echo "</tr>";
              $no++;
            }
          } else {
            echo "<tr><td colspan='6' class='text-center'>No data available</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
      const searchValue = this.value.toLowerCase();
      const rows = document.querySelectorAll('#menuTable tr');

      rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let match = false;

        cells.forEach(cell => {
          if (cell.innerText.toLowerCase().includes(searchValue)) {
            match = true;
          }
        });

        if (match) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  </script>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/popper.min.js"></script>
</body>

</html>

<?php
mysqli_close($koneksi);
?>