<?php
include 'includes/connection.php';
include 'includes/functions.php';
include 'components/nextDialog.php';

session_start();

if (isset($_SESSION['user'])) {
  header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nim = htmlspecialchars($_POST['nim']);
  $password = htmlspecialchars($_POST['password']);
  $result = login($nim, $password);
  if ($result['status']) {
    echo nextDialog("login.php");
    $_SESSION['user'] = $result['data'];
    if ($result['data']['role'] == 'admin') {
      echo nextDialog("admin.php");
      echo "<script src='js/nextDialog.js'></script>";
      echo "<script> 
    next(
        'Login Successful', 
        '" . $result['message'] . "'
    );
    </script>";
    } else {
      echo nextDialog("index.php");
      echo "<script src='js/nextDialog.js'></script>";
      echo "<script> 
    next(
        'Login Successful', 
        '" . $result['message'] . "'
    );
    </script>";
    }
  } else {
    echo nextDialog("login.php");
    echo "<script src='js/nextDialog.js'></script>";
    echo "<script> 
    next(
        'Login Failed', 
        '" . $result['message'] . "'
    );
    </script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

  <!-- styles -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/components.css">
  <link rel="stylesheet" href="css/auth.css">

  <!-- favicon -->
  <link rel="shortcut icon" href="favicon.svg" type="image/x-icon">

  <title>Login | COMS</title>
</head>

<body>
  <div class="auth w-full flex items-center gap-6">
    <div>
      <h1 class="heading">COMS</h1>
      <p>Coms helps you connect and share with students, lecturers, and the community at Mulawarman University, strengthening connections and collaboration in the academic environment.</p>
    </div>
    <form action="" method="POST" class="mb-6 p-c w-full cream border shadow rounded-lg">
      <h2 class="heading mb-6 text-center">Login</h2>
      <div class="mb-6">
        <label for="nim" class="font-bold block mb-2">NIM</label>
        <input type="text" name="nim" id="nim" placeholder="Ex: 2309106065" class="w-full red p-c rounded-lg border shadow" maxlength="10">
      </div>
      <div class="mb-10">
        <label for="password" class="font-bold block mb-2">Password</label>
        <input type="password" name="password" id="password" placeholder="Min 4 characters" class="w-full green p-c rounded-lg border shadow" maxlength="50">
      </div>
      <button type="submit" class="btn auth w-full px-6 font-bold py-2 flex text-center justify-center border shadow rounded-lg">Login</button>
      <div class="mt-3 text-center">Don't have account? <a href="register.php" class="blue px-1 py-1">Register</a></div>
    </form>
  </div>
</body>

</html>
