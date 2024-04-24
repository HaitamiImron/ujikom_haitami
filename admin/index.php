<?php
session_start();
$user_id = $_SESSION['user_id'];
include '../config/koneksi.php';
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login') {
    echo "<script>
    alert('Anda Belum Login!');
    location.href='../index.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan Ujikom</title>
    <link rel="stylesheet" type="text/css" href="../asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>
        footer {
            background-color: #333; /* Warna latar belakang footer */
            color: #fff; /* Warna teks footer */
            padding: 3px; /* Ruang dalam footer */
            text-align: center; /* Teks di tengah */
            position: fixed; /* Footer akan tetap di bagian bawah layar */
            bottom: 0; /* Footer menempel di bagian bawah */
            width: 100%; /* Lebar footer 100% dari layar */
        }

        body{
        background-color: #DCDCDC;
    }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-secondary">  
  <div class="container-fluid">
  <a class="navbar-brand text-light" href="#">Website Galeri Foto</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a href="home.php" class="nav-link text-light">Home</a></li>
        <li class="nav-item"><a href="foto.php" class="nav-link text-light">Foto</a></li>
      </ul>
    </div>
    <a href="../config/aksi_logout.php" class="btn btn-outline-light m-1">Keluar</a>
  </div>
</nav>

<div class="container mt-2">
    <div class="row">
        <?php
            $query = mysqli_query($koneksi, "SELECT * FROM foto INNER JOIN user ON foto.user_id=user.user_id");
            while($data = mysqli_fetch_array($query)){
        ?>
        <div class="col-md-3 mt-2">
            <a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['foto_id'] ?>">
                <div class="card">
                    <img style="height: 12rem;" src="../asset/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top" title="<?php echo $data['judul_foto'] ?>">
                    <div class="card-footer text-center">
                        <?php
                            $foto_id = $data['foto_id'];
                            $ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id' AND user_id='$user_id'");
                            if (mysqli_num_rows($ceksuka) == 1) { ?> 
                                <a href="../config/proses_like.php?foto_id=<?php echo $data['foto_id']?>" class="btn btn-link" name="batalsuka"><i class="fa fa-heart"></i></a>
                            <?php } else { ?>
                                <a href="../config/proses_like.php?foto_id=<?php echo $data['foto_id']?>" class="btn btn-link" name="suka"><i class="fa-regular fa-heart"></i></a>
                            <?php }
                            $like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id'");
                            echo mysqli_num_rows($like). ' Suka';
                        ?>
                        <a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['foto_id'] ?>">
                            <i class="fa-regular fa-comment"></i>
                        </a>
                        <?php 
                            $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE foto_id='$foto_id'");
                            echo mysqli_num_rows($jmlkomen).' Komentar';
                        ?>
                    </div>
                </div>
            </a> 
            
            <!-- Modal -->
            <div class="modal fade" id="komentar<?php echo $data['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Komentar dan Detail Foto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="../asset/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top" title="<?php echo $data['judul_foto'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <div class="mt-2">
                                        <div class="overflow-auto">
                                            <div class="sticky-top">
                                                <strong><?php echo $data['judul_foto'] ?></strong><br>
                                                <span class="badge bg-secondary"><?php echo $data['nama_lengkap'] ?></span>
                                                <span class="badge bg-secondary"><?php echo $data['tanggal_unggah'] ?></span>
                                            </div>
                                            <hr>
                                            <p align="left">
                                                <?php echo $data['deskripsi_foto'] ?>
                                            </p>
                                            <hr>

                                            <div class="overflow-auto" style="max-height: 150px;">
                                                <?php 
                                                    $foto_id = $data['foto_id'];
                                                    $komentar = mysqli_query($koneksi, "SELECT * FROM komentar_foto LEFT JOIN user ON komentar_foto.user_id=user.user_id WHERE komentar_foto.foto_id='$foto_id'");
                                                    while($row = mysqli_fetch_array($komentar)) {
                                                        $nama_lengkap = $row['nama_lengkap'] ? $row['nama_lengkap'] : "Anonim";
                                                ?>
                                                    <p align="left">
                                                        <strong><?php echo $nama_lengkap ?></strong>
                                                        <?php echo $row['isi_komentar']; ?>
                                                    </p>
                                                <?php } ?>
                                                </div>

                                            
                                            <hr>
                                            <div class="sticky-bottom">
                                                <form action="../config/proses_komentar.php" method="POST">
                                                    <div class="input-group">
                                                        <input type="hidden" name="foto_id" value="<?php echo $data['foto_id'] ?>">
                                                        <input type="text" name="isi_komentar" placeholder="Tambah Komentar">
                                                        <div class="input-group-prepend">
                                                            <button type="submit" name="kirimkomentar" class="btn btn-outline-primary">Kirim</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<footer>
    <p>UJI KOMPETENSI KEAHLIAN RPL 2024</p>
</footer>
<script type="text/javascript" src="../asset/js/bootstrap.min.js"></script>
</body>
</html>
