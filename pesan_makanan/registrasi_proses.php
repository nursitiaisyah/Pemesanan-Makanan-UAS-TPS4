<?php
require 'password_compat/lib/password.php'; // Sesuaikan path dengan letak file password.php

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape semua input untuk mencegah SQL injection
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_telepon = mysqli_real_escape_string($koneksi, $_POST['no_telepon']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; // Ambil password mentah dari form

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk menyimpan data user baru
    $query = "INSERT INTO users (nama_lengkap, alamat, no_telepon, email, username, password) 
              VALUES ('$nama_lengkap', '$alamat', '$no_telepon', '$email', '$username', '$hashed_password')";

    if (mysqli_query($koneksi, $query)) {
        // Registrasi berhasil, arahkan ke halaman login
        header('Location: login.php');
        exit;
    } else {
        // Jika terjadi kesalahan dalam query, tampilkan pesan error
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
?>