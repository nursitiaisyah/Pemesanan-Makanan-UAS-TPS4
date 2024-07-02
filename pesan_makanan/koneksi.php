<?php
$koneksi = mysqli_connect('localhost', 'root', '', 'db_pemesanan_makanan');

/*check connection */
if (mysqli_connect_error()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>
