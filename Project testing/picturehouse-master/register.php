<?php // register.php
  include "db_connect.php";
  include "console_log.php";

  // Sign Up
  if (
    !isset($_SESSION['user_email']) &&
    !empty($_POST['email']) &&
    !empty($_POST['name']) &&
    !empty($_POST['password']) &&
    !empty($_POST['password2'])
  ) {

    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password != $password2) {
      alert("Sorry the passwords do not match");
      exit;
    }

    $password = sha1($password);
    $sql = "INSERT INTO users (email, name, password)
        VALUES ('$email', '$name', '$password')";
    $result = mysqli_query($conn, $sql);

    if ($result) 
      $_SESSION['user_email'] = $email;
    else
      alert("Registeration failed. Please try again.");
  }

  // Log in
  if (!isset($_SESSION['user_email']) && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      consoleLog($email);
      $_SESSION['user_email'] = $email;
    } else {
      alert("Log in failed. Please try again.");
    }

  }

  mysqli_close($conn);
?>