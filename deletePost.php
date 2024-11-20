<?php
include 'includes/functions.php';
include 'components/nextDialog.php';

echo $_GET['id'];

session_start();

$post = getSinglePost($_GET['id']);

if ($post['user']['nim'] != $_SESSION['user']['nim']) {
  header('Location: index.php');
} else {
  $result = deletePost($_GET['id']);
  echo nextDialog("index.php");
  echo "<script src='js/nextDialog.js'></script>";
  echo "<script> 
    next(
        'Delete Post', 
        '" . $result['message'] . "'
    );
    </script>";
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

  <title>Post | COMS</title>
</head>

<body></body>

</html>
