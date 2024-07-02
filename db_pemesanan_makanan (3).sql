-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Jul 2024 pada 01.06
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pemesanan_makanan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `menu_makanan_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_makanan`
--

CREATE TABLE `menu_makanan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `url_gambar` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu_makanan`
--

INSERT INTO `menu_makanan` (`id`, `nama`, `deskripsi`, `harga`, `url_gambar`, `tanggal_dibuat`) VALUES
(1, 'Ayam Geprek Original', 'Ayam geprek dengan struktur gurih', 12000, '../uploads/1.jpg', '2024-06-22 22:22:54'),
(7, 'Es Jeruk', 'Jeruk Asli', 5000, '../uploads/m2.jpg', '2024-06-29 00:02:30'),
(9, 'Ayam Geprek Cabe Hijau', 'Dengan sambal hijau', 14000, '../uploads/images.jpeg', '2024-06-30 02:15:31'),
(14, 'Ayam Geprek Spesial Super', 'Gurih', 13000, '../uploads/111.jpeg', '2024-07-01 11:34:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `nomor_pesanan` varchar(20) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status` enum('pending','selesai','dibatalkan') DEFAULT 'pending',
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `users_id`, `nomor_pesanan`, `total_harga`, `status`, `tanggal_dibuat`) VALUES
(30, 3, 'P00003', 17000, 'pending', '2024-06-28 22:12:33'),
(31, 5, 'P00004', 36000, 'pending', '2024-06-28 22:15:01'),
(32, 7, 'P00005', 17000, 'pending', '2024-06-28 23:21:23'),
(33, 4, 'P00006', 12000, 'pending', '2024-06-28 23:30:48'),
(37, 6, 'P00008', 12000, 'pending', '2024-06-29 13:47:01'),
(38, 5, 'P00009', 36000, 'pending', '2024-06-29 10:38:29'),
(40, 5, 'P00010', 19000, 'pending', '2024-06-29 21:16:02'),
(46, 3, 'P00011', 31000, 'pending', '2024-07-01 06:25:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan_menu`
--

CREATE TABLE `pesanan_menu` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `menu_makanan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan_menu`
--

INSERT INTO `pesanan_menu` (`id`, `pesanan_id`, `menu_makanan_id`) VALUES
(19, 38, 1),
(25, 37, 1),
(26, 40, 9),
(27, 40, 7),
(36, 46, 9),
(37, 46, 7),
(38, 46, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `nomor_pesanan` varchar(50) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `users_id` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `nomor_pesanan`, `tanggal_transaksi`, `users_id`, `total_harga`, `jumlah_bayar`, `kembalian`, `status`) VALUES
(1, 'P00005', '2024-06-29 06:21:23', 7, 17000, 20000, 3000, 'Selesai'),
(2, 'P00008', '2024-06-29 17:09:47', 6, 24000, 50000, 26000, 'Selesai'),
(3, 'P00009', '2024-06-29 17:38:29', 5, 36000, 100000, 64000, 'Selesai'),
(4, 'P00010', '2024-06-30 04:16:02', 5, 19000, 20000, 1000, 'Selesai'),
(5, 'P00011', '2024-07-01 06:32:07', 5, 19000, 50000, 31000, 'Selesai'),
(6, 'P00011', '2024-07-01 06:39:29', 5, 17000, 20000, 3000, 'Selesai'),
(7, 'P00012', '2024-07-01 06:40:54', 6, 26000, 30000, 4000, 'Selesai'),
(8, 'P00013', '2024-07-01 07:30:38', 6, 17000, 0, 0, 'Pending'),
(9, 'P00011', '2024-07-01 13:25:15', 3, 31000, 35000, 4000, 'Selesai'),
(10, 'P00012', '2024-07-01 14:22:54', 3, 18000, 20000, 2000, 'Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pelanggan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `alamat`, `no_telepon`, `email`, `username`, `password`, `role`) VALUES
(1, 'Nur Siti Aisyah', 'Desa Salak Kecamatan Randuagung Kabupaten Lumajang', '081333641651', 'nur617859@gmail.com', 'admin', '$2y$10$ZL0EKHUp1UxJScfqa3ZJBugDtNCg/4DLFjz7SiglnB/cPq6nEe6hS', 'admin'),
(3, 'Riska', 'Jakarta', '087334552123', 'riska1212@gmail.com', 'riska', '$2y$10$c76NPzPD0LhfGE27s1NlgOgUnthZ/tNoLOU8C9X7a2GH7womvb4/O', ''),
(4, 'putri', 'Bangkalan', '087345234665', 'putri2023@gmail.com', 'putri12', '$2y$10$5PBZc3fGxh5hRGeM/Io9oOfmTTA5ndA1ggPl9GqyQJqdybvYLz3zi', ''),
(5, 'Tiara', 'Surabaya', '089776554321', 'tiara23@gmail.com', 'tiara', '$2y$10$k2ijzuLj/pB8Xwctn.bd8em8Fwk0354xsMIDACgOKs2bzaOQn41AK', 'pelanggan'),
(6, 'Rani', 'Lumajang', '089678567665', 'rani09@gmail.com', 'rani', '$2y$10$m7C4Gb.Vx3DOElJcn24sROaoJ5ZfAGfSOB9hn53gEaXxUj0D26V0G', 'pelanggan'),
(7, 'Eko Wahyudi', 'Kediri', '089776554321', 'eko1212@gmail.com', 'eko', '$2y$10$Nkecs4d1d9gMxrTps7d.9.3mb8LyrGkntdpz7SUxZ54R.s07yvv8C', 'pelanggan'),
(10, 'andre', 'Malang', '089765454321', 'andre1212@gmail.com', 'andre', '$2y$10$x.E.EUkLHE3HrQjVoWi8y.8/lzRCzFnBp57I3Qy9vlFFzuoQdrLl2', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id` (`pesanan_id`),
  ADD KEY `menu_id` (`menu_makanan_id`);

--
-- Indeks untuk tabel `menu_makanan`
--
ALTER TABLE `menu_makanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nama` (`nama`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_pesanan` (`nomor_pesanan`),
  ADD KEY `pesanan_ibfk_1` (`users_id`);

--
-- Indeks untuk tabel `pesanan_menu`
--
ALTER TABLE `pesanan_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_menu_ibfk_1` (`pesanan_id`),
  ADD KEY `pesanan_menu_ibfk_2` (`menu_makanan_id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menu_makanan`
--
ALTER TABLE `menu_makanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `pesanan_menu`
--
ALTER TABLE `pesanan_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`menu_makanan_id`) REFERENCES `menu_makanan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan_menu`
--
ALTER TABLE `pesanan_menu`
  ADD CONSTRAINT `pesanan_menu_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_menu_ibfk_2` FOREIGN KEY (`menu_makanan_id`) REFERENCES `menu_makanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
