<?php
session_start();
require 'functions.php';

// cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];

  //ambil username berdasarkan id
  $result = mysqli_query($koneksi, "SELECT  username FROM user WHERE id = $id");
  $row = mysqli_fetch_assoc($result);

  // cek cookie dan username
  if ($key === hash('sha256', $row['username'])) {
    $_SESSION['login'] = true;
  }
}

if (isset($_SESSION["login"])) {
  header("Location: index.php");
  exit;
}


if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");

  // cek usernamenya
  if (mysqli_num_rows($result) === 1) {
    // cek password
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) { // cek string sama atau tidak dengan password yang dibuat dengan password_hash
      // set session
      $_SESSION["login"] = true;

      // cek remember me
      if (isset($_POST['remember'])) {
        //buat cookie
        setcookie('id', $row['id'], time() + 60);
        setcookie('key', hash('sha256', $row['username']), time() + 60);
      }
      header("Location: index.php");
      exit;
    }
  }

  $error = true;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Login</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>


  <form action="" method="POST">
    <div class="container">
      <h3>Halaman Login</h3>

      <?php if (isset($error)) : ?>
        <p style="color: red; font-style: italic; ">username / password salah</p>
      <?php endif; ?>

      <div id="frame">
        <div class="form-group">
          <input type="text" name="username" required>
          <label>Username</label>
        </div>
        <div class="form-group">
          <input type="password" name="password" required>
          <label>Password</label>
        </div>
        <div>
          <input type="checkbox" name="remember" id="remember">
          <label for="remember">Remember me</label>
        </div>

        <button type="submit" name="login" class="tombol_login">Login</button>
        <br> <br>
        <button type="submit" class="tombol_registrasi">Registrasi</button>

      </div>
    </div>
  </form>

</body>

</html>