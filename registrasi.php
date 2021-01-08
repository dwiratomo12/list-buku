<?php
require 'functions.php';

if (isset($_POST["register"])) {
  if (registrasi($_POST) > 0) {
    echo "<script>
            alert('user baru berhasil ditambahkan !');
            </script>";
  } else {
    echo mysqli_error($koneksi);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Registrasi</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div class="kotak_login">
    <h1>Halaman Registrasi</h1>

    <form action="" method="POST">

      <label for="username">Username : </label>
      <input type="text" name="username" class="form_login">


      <label for="password">password : </label>
      <input type="password" name="password" class="form_login">


      <label for="password2">konfirmasi password : </label>
      <input type="password" name="password2" class="form_login">


      <button type="submit" name="register" class="tombol_login">Sign Up</button>
    </form>
  </div>


</body>

</html>