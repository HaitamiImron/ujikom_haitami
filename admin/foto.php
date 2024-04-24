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

    <style>
    
        footer {
            background-color: #333; /* Warna latar belakang footer */
            color: #fff; /* Warna teks footer */
            padding: 3px; /* Ruang dalam footer */
            text-align: center; /* Teks di tengah */
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
  <a class="navbar-brand text-light" href="index.php">Website Galeri Foto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-light" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="foto.php">Foto</a>
                </li>
            </ul>
        </div>
        <a href="../config/aksi_logout.php" class="btn btn-outline-light m-1">Keluar</a>
    </div>
</nav>

<div class="container mt-2 min-vh-100">
    <div class="row">
        <div class="col-md-4">
            <div class="card mt-2">
                <div class="card-header bg-secondary text-light">Tambah Foto</div>
                <div class="card-body bg-secondary">
                    <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data">
                        <label class="form-label text-light">Judul Foto</label>
                        <input type="text" name="judul_foto" class="form-control" required>
                        <label class="form-label text-light">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi_foto" required></textarea>
                        <label class="form-label text-light">File</label>
                        <input type="file" class="form-control" name="lokasi_file" required>
                        <button type="submit" class="btn btn-dark mt-2" name="tambah">Tambah Data</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mt-2">
                <div class="card-header bg-secondary text-light">Data Galeri Foto</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="table-secondary">#</th>
                                <th class="table-secondary">Foto</th>
                                <th class="table-secondary">Judul Foto</th>
                                <th class="table-secondary">Deskripsi</th>
                                <th class="table-secondary">Tanggal</th>
                                <th class="table-secondary">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $user_id = $_SESSION['user_id'];
                            $sql = mysqli_query($koneksi, "SELECT * FROM foto WHERE user_id='$user_id'");
                            while($data = mysqli_fetch_array($sql)){
                            ?>
                        
                            <tr>
                               <td><?php echo $no++ ?></td>
                               <td><img src="../asset/img/<?php echo $data['lokasi_file'] ?>" width="100"></td>
                               <td><?php echo $data['judul_foto']?></td>
                               <td><?php echo $data['deskripsi_foto']?></td>
                               <td><?php echo $data['tanggal_unggah']?></td>
                               <td>
                               <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['foto_id']?>">Edit</button>
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="edit<?php echo $data['foto_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="../config/aksi_foto.php" method ="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="foto_id" value="<?php echo $data['foto_id']?>">
                                                        <label class="form-label">Judul Foto</label>
                                                        <input type="text" name="judul_foto" value="<?php echo $data['judul_foto']?>" class="form-control" required>
                                                        <label class="form-label">Deskripsi</label>
                                                        <textarea class="form-control" name="deskripsi_foto" required><?php echo $data['deskripsi_foto']?></textarea>
                                                        <label class="form-label">Foto</label>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <img src="../asset/img/<?php echo $data['lokasi_file'] ?>"width="100">
                                                            </div>
                                                            <div class="col-md-8">
                                                                <label class="form-label">Ganti File</label>
                                                                <input type="file" class="form-control" name="lokasi_file">
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['foto_id']?>">Hapus</button>

                                    <div class="modal fade" id="hapus<?php echo $data['foto_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="../config/aksi_foto.php" method ="POST">
                                                        <input type="hidden" name="foto_id" value="<?php echo $data['foto_id']?>">
                                                        Apakah anda yakin akan menghapus data <strong><?php echo $data['judul_foto'] ?> </strong> ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="hapus" class="btn btn-primary">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>UJI KOMPETENSI KEAHLIAN RPL 2024</p>
</footer>
<script type="text/javascript" src="../asset/js/bootstrap.min.js"></script>
</body>
</html>
