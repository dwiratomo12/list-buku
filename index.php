<?php
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require 'functions.php'; // memanggil file functioin.php
$book = query("SELECT * FROM buku");

// tombol cari ditekan
if (isset($_POST["cari"])) {
  $book = cari($_POST["keyword"]);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Admin</title>
  <style>
    .loader {
      width: 150px;
      position: absolute;
      top: 102px;
      left: 23%;
      z-index: -1;
      display: none;
    }

    @media print {

      .logout,
      .tambah,
      .form-cari,
      .aksi {
        display: none;
      }
    }
  </style>
</head>

<body>
  <a href="logout.php" class="logout">Logout</a> | <a href="cetak.php" target="_blank">Cetak</a>
  <h1>Daftar Buku</h1>
  <a href="tambah.php" class="tambah">Tambah data buku</a>
  <br><br>


  <form action="" method="POST" class="form-cari">

    <input type="text" name="keyword" size="45" autofocus placeholder="Masukkan pencarian..." autocomplete="off" id="keyword">
    <button type="submit" name="cari" id="tombol-cari">Cari</button>

    <img src="img/loader.gif" class="loader">

  </form>
  <br>
  <div id="container">
    <table border="1" cellpadding="10" cellspacing="0">

      <tr>
        <th>No.</th>
        <th class="aksi">Aksi</th>
        <th>Gambar</th>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Halaman</th>
        <th>Harga</th>
        <th>Penerbit</th>
      </tr>

      <?php $i = 1; ?>
      <?php foreach ($book as $row) : ?>
        <tr>
          <td><?= $i; ?></td>
          <td class="aksi">
            <a href="ubah.php?id=<?= $row["id"]; ?>">Ubah</a> |
            <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin data ingin dihapus?');">Hapus</a>
          </td>
          <td><img src="buku/<?= $row["gambar"]; ?>"></td>
          <td><?= $row["judul"]; ?></td>
          <td><?= $row["pengarang"]; ?></td>
          <td><?= $row["halaman"]; ?></td>
          <td><?= $row["harga"]; ?></td>
          <td><?= $row["penerbit"]; ?></td>
        </tr>
        <?= $i++; ?>
      <?php endforeach; ?>

    </table>
  </div>

  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/script.js"></script>
</body>

</html>