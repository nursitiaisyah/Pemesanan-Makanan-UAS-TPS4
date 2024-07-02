<?php
require 'password_compat/lib/password.php'; // Sesuaikan path dengan letak file password.php
include 'koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password_input = $_POST['password'];

    // Query untuk mendapatkan user berdasarkan username atau email
    $query = "SELECT * FROM users WHERE username='$username' OR email='$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $stored_hashed_password = $user['password']; // Ambil password yang ter-hash dari database

        // Verifikasi password
        if (password_verify($password_input, $stored_hashed_password)) {
            // Password cocok, simpan informasi pengguna ke dalam session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['role'] = $user['role'];

            // Arahkan pengguna ke halaman yang sesuai berdasarkan role
            if ($user['role'] == 'admin') {
                header('Location: admin/halaman_admin.php');
            } else {
                header('Location: pelanggan/halaman_pelanggan.php');
            }
            exit;
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username atau email tidak ditemukan!";
    }
}
?>