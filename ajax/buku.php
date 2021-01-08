<?php
sleep(1);
require '../functions.php';
$keyword = $_GET["keyword"];
$query = "SELECT * FROM buku WHERE 
          judul LIKE '%$keyword%' OR
          pengarang LIKE '%$keyword%' OR
          penerbit LIKE '%$keyword%' OR
          halaman LIKE '%$keyword%'
          ";
$book = query($query);
?>
<table border="1" cellpadding="10" cellspacing="0">

  <tr>
    <th>No.</th>
    <th>Aksi</th>
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
      <td>
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