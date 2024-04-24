<?php
session_start();
include 'koneksi.php';

$foto_id = $_GET['foto_id'];

// Fungsi untuk mengecek apakah pengguna anonim telah memberikan like pada suatu foto
function hasAnonymousLiked($foto_id) {
    if (isset($_COOKIE['anonymous_likes'])) {
        $liked_photos = json_decode($_COOKIE['anonymous_likes'], true);
        return in_array($foto_id, $liked_photos);
    }
    return false;
}

// Cek apakah user sudah login
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Jika user sudah login, lakukan proses like seperti biasa
    $ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id' AND user_id='$user_id'");
    if (mysqli_num_rows($ceksuka) == 1) {
        while($row = mysqli_fetch_array($ceksuka)){
            $like_id = $row['like_id'];
            $query = mysqli_query($koneksi, "DELETE FROM like_foto WHERE like_id='$like_id'");
            header("Location: ../index.php");
            exit();
        }
    } else {
        $tanggal_like = date('Y-m-d');
        $query = mysqli_query($koneksi, "INSERT INTO like_foto VALUES('','$foto_id','$user_id','$tanggal_like')");
        header("Location: ../index.php");
        exit();
    }
} else {
    // Jika user belum login, lakukan proses like sebagai pengguna anonim
    if (!hasAnonymousLiked($foto_id)) {
        // Jika pengguna anonim belum memberikan like pada foto ini, simpan informasi like ke dalam cookie
        $liked_photos = isset($_COOKIE['anonymous_likes']) ? json_decode($_COOKIE['anonymous_likes'], true) : [];
        $liked_photos[] = $foto_id;
        setcookie('anonymous_likes', json_encode($liked_photos), time() + (86400 * 30), "/"); // Cookie berlaku selama 30 hari
    }
    header("Location: ../index.php");
    exit();
}
?>
