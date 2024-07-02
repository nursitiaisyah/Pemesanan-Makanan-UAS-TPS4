<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DASHBOARD ADMIN</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/Logo2.png">
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="../assets/styles.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
  <style>
    .welcome-banner {
      background-color: #FFA500;
      /* Bootstrap danger color */
      color: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
    }

    .welcome-banner h1 {
      margin: 0;
      font-size: 2rem;
      font-weight: bold;
    }

    .welcome-banner p {
      margin: 0;
      font-size: 1.2rem;
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
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navbar -->

  <div class="container mt-5">
    <div class="welcome-banner">
      <h1>Selamat Datang "ADMIN"</h1>
      <p>DI RESTORANT AYAM GEPREK NUSANTARA</p>
    </div>
  </div>
  <script src="../assets/js/jquery-3.6.0.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap JS and dependencies (for example, jQuery) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>