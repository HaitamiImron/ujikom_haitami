<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan Ujikom</title>
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">

    <style>
        footer {
            background-color: #333; /* Warna latar belakang footer */
            color: #fff; /* Warna teks footer */
            padding: 3px; /* Ruang dalam footer */
            text-align: center; /* Teks di tengah */
            bottom: 0; /* Footer menempel di bagian bawah */
            width: 100%; /* Lebar footer 100% dari layar */
        }

        body {
        background-image: url('GREY.png'); /* Ganti path_to_your_background_image.jpg dengan URL gambar Anda */
        background-size: cover; /* Untuk mengatur agar gambar latar belakang menutupi seluruh area body */
        background-position: center; /* Untuk mengatur posisi gambar latar belakang di tengah */
    }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-secondary">
  <div class="container-fluid">
    <a class="navbar-brand text-light" href="index.php">Website Galeri Foto</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
    </div>
    <a href="register.php" class="btn btn-outline-succes m-1 text-light">Daftar</a>
    <a href="login.php" class="btn btn-outline-succes m-1 text-light">Masuk</a>
  </div>
</nav>

<div class="container py-5 min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body bg-secondary">
                    <div class="text-center">
                        <h5>Login</h5>
                    </div>
                    <form action="config/aksi_login.php" method="POST">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>

                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <div class="d-grid mt-2">
                        <button class="btn btn-dark" type="submit" name="kirim">Login</button>
                    </div>
                    </form>
                    <hr>
                    <p>Belum Punya Akun? <a href="register.php" class="text-light">Buat Akun!</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>UJI KOMPETENSI KEAHLIAN RPL 2024</p>
</footer>
<script type="text/javascript" href="asset/js/bootstrap.min.js"></script>
</body>
</html>