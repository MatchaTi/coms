<?php
include 'includes/functions.php';
include 'components/nextDialog.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: login.php');
}

$status = $_GET['status'];
$id = $_GET['id'];


if ($status == 'approve') {
  $result = approvePost($id);
  if ($result['status']) {
    echo nextDialog("manajemenPost.php");
    echo "<script src='js/nextDialog.js'></script>";
    echo "<script> 
    next(
        'Approve', 
        '" . $result['message'] . "'
    );
    </script>";
  }
} else if ($status == 'reject') {
  $result = rejectPost($id);
  if ($result['status']) {
    echo nextDialog("manajemenPost.php");
    echo "<script src='js/nextDialog.js'></script>";
    echo "<script> 
    next(
        'Reject', 
        '" . $result['message'] . "'
    );
    </script>";
  }
} else if ($status == 'delete') {
  $result = deletePost($id);
  if ($result['status']) {
    echo nextDialog("manajemenPost.php");
    echo "<script src='js/nextDialog.js'></script>";
    echo "<script> 
    next(
        'Delete', 
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

  <title>Post | COMS</title>
</head>

<body></body>

</html>
