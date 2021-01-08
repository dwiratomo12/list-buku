<?php
//koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "phpdasar");


function query($query)
{
  global $koneksi;
  $result = mysqli_query($koneksi, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function tambah($data)
{
  global $koneksi;
  // ambil data dari tiap elemen dalam form
  $judul = htmlspecialchars($data["judul"]);
  $pengarang = htmlspecialchars($data["pengarang"]);
  $halaman = htmlspecialchars($data["halaman"]);
  $harga = htmlspecialchars($data["harga"]);
  $penerbit = htmlspecialchars($data["penerbit"]);
  // htmlspecialchars( biar input tidak dapat menggunakan fungsi html

  // upload gambar dulu
  $gambar = upload();
  if (!$gambar) {
    return false;
  }

  // query insert data
  $query = " INSERT INTO buku VALUES
            ('', '$judul','$pengarang','$halaman','$harga','$penerbit','$gambar')";
  mysqli_query($koneksi, "$query");

  return mysqli_affected_rows($koneksi);
}

function upload()
{
  global $koneksi;
  $namaFile = $_FILES['gambar']['name'];
  $ukuranFile = $_FILES['gambar']['size'];
  $error = $_FILES['gambar']['error'];
  $tmpName = $_FILES['gambar']['tmp_name'];

  // cek apakah tidak ada gambar yang di upload
  if ($error === 4) {
    echo "<script>
          alert('pilih gambar terlebih dahulu!');
          </script>";
    return false;
  }

  // cek apakah yang di upload itu gambar
  $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
  $ekstensiGambar = explode('.', $namaFile); // explode adalah memecah sebuah string menjadi array
  $ekstensiGambar = strtolower(end($ekstensiGambar));
  if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
    echo "<script>
          alert('Yang di Upload Bukan Gambar YAAA!');
          </script>";
    return false;
  }

  // cek jika ukurannya terlalu besar
  if ($ukuranFile > 1000000) { // 1000000 byte(1 juta) = 1mb
    echo "<script>
          alert('Ukuran Gambar Max 1mb');
          </script>";
    return false;
  }

  // lolos pengecekan, gambar siap diupload
  // generate nama gambar baru
  $namaFileBaru = uniqid(); //uniqid() fungsi untuk membangkitkan string angka random yang nantinya akan jadi nama gambar
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiGambar;

  move_uploaded_file($tmpName, 'buku/' . $namaFileBaru);

  return $namaFileBaru;
}

function hapus($id)
{
  global $koneksi;
  $pilih = mysqli_query($koneksi, "SELECT * from buku where id = $id");
  $data = mysqli_fetch_array($pilih);
  $gambar = $data["gambar"];

  unlink("buku/" . $gambar); //hapus file gambar buku di dalam folder
  mysqli_query($koneksi, "DELETE FROM buku WHERE id = $id");

  return mysqli_affected_rows($koneksi);
}

function ubah($data)
{
  global $koneksi;
  // ambil data dari tiap elemen dalam form
  $id = $data["id"];
  $judul = htmlspecialchars($data["judul"]);
  $pengarang = htmlspecialchars($data["pengarang"]);
  $halaman = htmlspecialchars($data["halaman"]);
  $harga = htmlspecialchars($data["harga"]);
  $penerbit = htmlspecialchars($data["penerbit"]);

  $gambarLama = htmlspecialchars($data["gambarLama"]);
  // cek apakah user pilih gambar baru atau tidak
  if ($_FILES['gambar']['error'] === 4) {
    $gambar = $gambarLama;
  } else {
    $gambar = upload();
  }

  // query insert data
  $query = " UPDATE buku SET 
            judul = '$judul',
            pengarang = '$pengarang',
            halaman = '$halaman',
            harga = '$harga',
            penerbit = '$penerbit',
            gambar = '$gambar'
            WHERE id = $id
            ";

  mysqli_query($koneksi, "$query");

  return mysqli_affected_rows($koneksi);
}

function cari($keyword)
{
  $query = "SELECT * FROM buku WHERE 
            judul LIKE '%$keyword%' OR
            pengarang LIKE '%$keyword%' OR
            penerbit LIKE '%$keyword%' OR
            halaman LIKE '%$keyword%'
            ";

  return query($query);
}

function registrasi($data)
{
  global $koneksi;

  $username = strtolower(stripslashes($data["username"]));
  $password = mysqli_real_escape_string($koneksi, $data["password"]);
  $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);

  // cek username sudah ada atau belum
  $result = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username'");
  if (mysqli_fetch_assoc($result)) {
    echo "<script>
          alert('username sudah terdaftar!');
          </script>";
    return false;
  }

  // cek konfirmasi password
  if ($password !== $password2) {
    echo "<script>
          alert('konfirmasi password tidak sesuai!');
          </script>";
    return false;
  }

  // enkripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);

  // tambahkan userbaru ke database
  mysqli_query($koneksi, "INSERT INTO user VALUES('','$username','$password')");

  return mysqli_affected_rows($koneksi);
}
