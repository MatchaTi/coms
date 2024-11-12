<?php
include 'components/avatar.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- styles -->
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="stylesheet" href="css/admin.css">

    <title>Admin | Coms</title>
</head>

<body>
    <?php
    include 'components/navbarAdmin.php';
    ?>
    <section>hello</section>
</body>

</html>