<?php
// Lakukan proses logout di sini, seperti menghapus session atau melakukan tindakan logout lainnya

// Misalnya, jika menggunakan session, bisa seperti ini:
session_start();
session_destroy(); // Hapus semua session

// Redirect ke halaman login.php setelah logout
header("Location: index.php");
exit;
?>
