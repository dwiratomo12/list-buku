<?php

require_once __DIR__ . '/vendor/autoload.php';

require 'functions.php'; // memanggil file functioin.php
$book = query("SELECT * FROM buku");

$mpdf = new \Mpdf\Mpdf();

$html = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Buku</title>
  <link rel="stylesheet" href="css/print.css">
</head>
<body>
  <h1>Daftar Buku</h1>
  <table border="1" cellpadding="10" cellspacing="0">

      <tr>
        <th>No.</th>
        <th>Gambar</th>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Halaman</th>
        <th>Harga</th>
        <th>Penerbit</th>
      </tr>';

$i = 1;
foreach ($book as $row) {
  // .= adalah menggabungkan string sebelumnya dengan string selanjutnya
  $html .= '<tr>
          <td>' . $i++ . '</td>
          <td><img src="buku/' . $row["gambar"] . '"></td>
          <td>' . $row["judul"] . '</td>
          <td>' . $row["pengarang"] . '</td>
          <td>' . $row["halaman"] . '</td>
          <td>' . $row["harga"] . '</td>
          <td>' . $row["penerbit"] . '</td>
      </tr>';
}

$html .= '</table>
      
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output('daftar-buku.pdf', 'I');
