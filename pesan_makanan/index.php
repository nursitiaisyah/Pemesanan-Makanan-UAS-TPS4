<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AYAM GEPREK NUSANTARA</title>
    <link rel="icon" type="image/x-icon" href="assets/img/Logo2.png">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="assets/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <style>
    #tentang-kami {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding top: 15px 0; /* Atur padding sesuai kebutuhan */
    }
</style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">AYAM GEPREK NUSANTARA</a>  
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#menu">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#tentang-kami">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#kontak">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-light" onclick="window.location.href='login.php'">Login</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar -->

    <!-- Slide -->
    <div id="carouselExampleDark" class="carousel carousel-dark slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner" style="height: 578px">
            <div class="carousel-item active" data-bs-interval="10000">
                <img src="assets/img/1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block text-dark">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="assets/img/2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block text-dark">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/img/3.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block text-dark">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <div class="carousel-caption d-block position-absolute top-50 start-50 translate-middle text-center">
            <h1 class="text-white" style="text-shadow: 2px 2px 4px #000;">Selamat Datang Di Restoran Ayam Geprek Nusantara</h1>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- Slide -->

    <!-- Menu Title -->
    <div id="menu" class="container mt-4">
        <h2 class="text-center">Menu</h2>
    </div>
    <!-- Menu Title -->

    <!-- Katalog -->
    <div class="container-fluid p-4">
        <div class="row row-cols-1 row-cols-md-3 g-4 text-center mb-3">
            <div class="col">
                <div class="card">
                    <img src="assets/img/1.jpg" class="card-img-top" alt="..." style="height: 220px">
                    <div class="card-body">
                        <h5 class="card-title">Ayam Geprek Krispi</h5>
                        <p class="card-text">Rp. 12.000</p>
                        <a href="login.php" class="btn btn-primary">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="assets/img/2.jpg" class="card-img-top" alt="..." style="height: 220px">
                    <div class="card-body">
                        <h5 class="card-title">Ayam Geprek Bakar</h5>
                        <p class="card-text">Rp. 12.000</p>
                        <a href="login.php" class="btn btn-primary">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="assets/img/3.jpg" class="card-img-top" alt="..." style="height: 220px">
                    <div class="card-body">
                        <h5 class="card-title">Ayam Geprek Keju</h5>
                        <p class="card-text">Rp. 12.000</p>
                        <a href="login.php" class="btn btn-primary">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Katalog -->

    <!-- Katalog 2 -->
    <div class="container-fluid p-4">
        <div class="row row-cols-1 row-cols-md-3 g-4 text-center mb-3">
            <div class="col">
                <div class="card">
                    <img src="assets/img/m1.jpg" class="card-img-top" alt="..." style="height: 220px">
                    <div class="card-body">
                        <h5 class="card-title">Es Teh Manis</h5>
                        <p class="card-text">Rp. 12.000</p>
                        <a href="login.php" class="btn btn-primary">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="assets/img/m2.jpg" class="card-img-top" alt="..." style="height: 220px">
                    <div class="card-body">
                        <h5 class="card-title">Es Jeruk</h5>
                        <p class="card-text">Rp. 12.000</p>
                        <a href="login.php" class="btn btn-primary">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="assets/img/m3.jpg" class="card-img-top" alt="..." style="height: 220px">
                    <div class="card-body">
                        <h5 class="card-title">Air Mineral</h5>
                        <p class="card-text">Rp. 12.000</p>
                        <a href="login.php" class="btn btn-primary">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Katalog 2 -->

    <!-- Tentang Kami -->
<div id="tentang-kami" class="container mt-4">
    <h2 class="text-center mb-4">Tentang Kami</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="assets/img/2.jpg" class="img-fluid" alt="Tentang Kami">
            </div>
            <div class="col-md-6">
                <p>Selamat datang di Ayam Geprek Nusantara! Kami adalah restoran yang menawarkan berbagai macam ayam geprek dengan cita rasa khas Nusantara. Kami berkomitmen untuk memberikan pengalaman kuliner terbaik dengan menggunakan bahan-bahan berkualitas dan resep tradisional yang autentik.</p>
                <p>Ayam Geprek Nusantara berdiri sejak tahun 2020 dan telah melayani ribuan pelanggan dengan berbagai menu andalan seperti Ayam Geprek Krispi, Ayam Geprek Keju, dan masih banyak lagi. Kami selalu berusaha untuk meningkatkan kualitas pelayanan dan variasi menu kami.</p>
                <p>Kami percaya bahwa makanan enak bisa membuat hari Anda lebih baik. Oleh karena itu, kami berusaha untuk menyajikan makanan yang lezat dengan harga yang terjangkau. Terima kasih telah memilih Ayam Geprek Nusantara sebagai destinasi kuliner Anda.</p>
            </div>
        </div>
    </div>
</div>
<!-- Tentang Kami --><!-- Tentang Kami -->

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5">
        <div id="kontak" class="container py-4">
            <div class="row">
                <div class="col-md-4">
                    <h5>Kontak Kami</h5>
                    <ul class="list-unstyled">
                        <li>Alamat: Jl. Pahlawan No. 123, Jakarta</li>
                        <li>Telepon: +62 21 1234 5678</li>
                        <li>Email: info@ayamgeprek.com</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Jam Operasional</h5>
                    <ul class="list-unstyled">
                        <li>Senin - Jumat: 10:00 - 22:00</li>
                        <li>Sabtu - Minggu: 12:00 - 24:00</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Media Sosial</h5>
                    <ul class="list-unstyled d-flex social-icons">
                        <li><a href="https://www.facebook.com/ayamgepreknusantara" target="_blank"><i class="fab fa-facebook"></i></a></li>
                        <li><a href="https://www.instagram.com/ayamgepreknusantara" target="_blank"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="https://www.youtube.com/ayamgepreknusantara" target="_blank"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bg-secondary text-center py-3">
            &copy; 2024 Ayam Geprek Nusantara. Nur Siti Aisyah.
        </div>
    </footer>
    <!-- Footer -->

    <script src="assets/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
