<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayam Geprek Nusantara</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-danger">
        <a class="navbar-brand text-white" href="#">AYAM GEPREK NUSANTARA</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" id="orderSummary">
                        Pesanan <span id="orderCount">(0)</span> - <span id="orderTotalPrice">Rp. 0</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <h3 class="mb-4">Daftar Menu</h3>
                <div class="row">
                    <!-- Card Menu Item -->
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="img/ayam_geprek_hot.jpg" class="card-img-top" alt="Ayam Geprek Hot">
                            <div class="card-body">
                                <h5 class="card-title">Ayam Geprek Hot</h5>
                                <p class="card-text">Rp. 12.000</p>
                                <button class="btn btn-primary"
                                    onclick="addToOrder('Ayam Geprek Hot', 12000)">Pesan</button>
                            </div>
                        </div>
                    </div>
                    <!-- Repeat above card for other menu items -->
                </div>
            </div>
            <div class="col-lg-4">
                <h3 class="mb-4">Detail Pesanan</h3>
                <form id="orderForm">
                    <div class="form-group">
                        <label for="orderNumber">No Pesanan</label>
                        <input type="text" class="form-control" id="orderNumber" readonly>
                    </div>
                    <div class="form-group">
                        <label for="customerName">Nama</label>
                        <input type="text" class="form-control" id="customerName">
                    </div>
                    <div class="form-group">
                        <label for="orderDetails">Menu</label>
                        <textarea class="form-control" id="orderDetails" rows="5" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="orderTotal">Total Pembayaran</label>
                        <input type="text" class="form-control" id="orderTotal" readonly>
                    </div>
                    <button type="button" class="btn btn-primary btn-block" onclick="submitOrder()">Buat
                        Pesanan</button>
                    <button type="button" class="btn btn-danger btn-block" onclick="clearOrder()">Hapus Pesanan</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
    <script>
        let orderList = [];
        let totalPrice = 0;

        function addToOrder(menu, price) {
            // Add item to order list
            orderList.push({ menu: menu, price: price });
            totalPrice += price;

            // Update order details and order summary in navbar
            updateOrderDetails();
            updateOrderSummary();
        }

        function updateOrderDetails() {
            let orderDetails = '';
            orderList.forEach((item, index) => {
                orderDetails += `${index + 1}. ${item.menu} - Rp. ${item.price}\n`;
            });

            document.getElementById('orderDetails').value = orderDetails;
            document.getElementById('orderTotal').value = 'Rp. ' + totalPrice;
        }

        function updateOrderSummary() {
            const orderCount = orderList.length;
            document.getElementById('orderCount').innerText = `(${orderCount})`;
            document.getElementById('orderTotalPrice').innerText = `Rp. ${totalPrice}`;
        }

        function clearOrder() {
            orderList = [];
            totalPrice = 0;
            updateOrderDetails();
            updateOrderSummary();
        }

        function submitOrder() {
            const customerName = document.getElementById('customerName').value;
            if (customerName === '') {
                alert('Nama pelanggan harus diisi');
                return;
            }

            // Generate a random order number
            const orderNumber = 'ORD-' + Math.floor(Math.random() * 100000);
            document.getElementById('orderNumber').value = orderNumber;

            // Simpan data pesanan ke database
            // Kode untuk menyimpan data pesanan ke database bisa ditambahkan di sini

            alert('Pesanan berhasil dibuat!\nNo Pesanan: ' + orderNumber);
            clearOrder();
        }

    </script>
</body>

</html>