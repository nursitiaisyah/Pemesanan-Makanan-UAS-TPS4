<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>LOGIN</title>
    <link rel="icon" type="image/x-icon" href="assets/img/Logo2.png">
    <link rel="shortcut icon" href="assets/login/assets/images/fav.jpg">
    <link rel="stylesheet" href="assets/login/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/login/assets/css/fontawsom-all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/assets/css/style.css" />
    <style>
        .login-box {
            border-top: 5px solid red;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        .full-bg {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f7f7f7;
            height: 100vh;
        }

        body,
        html {
            height: 100%;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container-fluid full-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mx-auto">
                    <div class="login-box">
                        <h3>Form Login</h3>
                        <form action="login_proses.php" method="POST">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-at"></i></span>
                                </div>
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Username" aria-label="Username" aria-describedby="basic-addon1"
                                    required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control" name="password" placeholder="Password"
                                    aria-label="Password" aria-describedby="basic-addon1" required>
                            </div>
                            <button type="submit" class="btn btn-danger btn-block">Login</button>
                        </form>
                        <p class="no-c mt-3">Apakah sudah punya akun? <a href="registrasi.php">Buat Akun</a></p>
                        <p class="no-c"><a href="index.php">Kembali Halaman Beranda</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/login/assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/login/assets/js/popper.min.js"></script>
    <script src="assets/login/assets/js/bootstrap.min.js"></script>
    <script src="assets/login/assets/js/script.js"></script>

    <script>
        $(document).ready(function () {
            $('#username').on('input', function () {
                this.value = this.value.toLowerCase();
            });
        });
    </script>
</body>

</html>