<?php
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}
require 'functions.php';

// ambil data dari URL
$id = $_GET["id"];

// query data buku berdasarkan id
$buku = query("SELECT * FROM buku WHERE id = $id")[0];

// koneksi ke DBMS
$koneksi = mysqli_connect("localhost", "root", "", "phpdasar");

// cek apakah tombol submit sudah ditekan
if (isset($_POST["submit"])) {
  // cek apakah data berhasil diubah atau tidak
  if (ubah($_POST) > 0) {
    echo "
    <script>
      alert('Data berhasil diubah!');
      document.location.href = 'index.php';
    </script>";
  } else {
    echo "
    <script>
      alert('Data gagal diubah!');
      document.location.href = 'index.php';
    </script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubah data buku</title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
  <div class="kotak_login">
    <p class="tulisan_login">Ubah Data Buku</p>
    <!-- <h1>Tambah Data Buku</h1> -->

    <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $buku["id"]; ?>">
      <input type="hidden" name="gambarLama" value="<?= $buku["gambar"]; ?>">


      <label for="judul">Judul : </label>
      <input type="text" name="judul" id="judul" class="form_login" required value="<?= $buku["judul"]; ?>">


      <label for=" pengarang">Pengarang : </label>
      <input type="text" name="pengarang" id="pengarang" class="form_login" required value="<?= $buku["pengarang"]; ?>">


      <label for="halaman">Halaman : </label>
      <input type="text" name="halaman" id="halaman" class="form_login" required value="<?= $buku["halaman"]; ?>">


      <label for="harga">Harga : </label>
      <input type="text" name="harga" id="harga" class="form_login" required value="<?= $buku["harga"]; ?>">


      <label for="penerbit">Penerbit : </label>
      <input type="text" name="penerbit" id="penerbit" class="form_login" required value="<?= $buku["penerbit"]; ?>">


      <label for="gambar">Gambar : </label> <br>
      <img src="buku/<?= $buku['gambar']; ?>" width="50"><br>
      <input type="file" name="gambar" id="gambar" class="form_login" required>


      <button type="submit" name="submit" class="tombol_login">Ubah</button>



    </form>
  </div>

</body>

</html>