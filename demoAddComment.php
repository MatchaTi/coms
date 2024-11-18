<?php

require 'includes/connection.php';
require 'includes/functions.php';

if (isset($_POST['comment'])) {
    $postId = 5;  // ID postingan untuk implementasi gunakan $_GET['id']
    $userId = 7;  // ID user gunakan $_SESSION['user']['id']
    $content = $_POST['content'];

    $result = addComment($conn, $postId, $userId, $content);
    echo "<script>alert('" . $result['message'] . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Komentar</title>
</head>

<body>
    <h1>Tambah Komentar pada Postingan</h1>
    <form action="" method="POST">

        <label for="content">Komentar:</label><br>
        <textarea id="content" name="content" rows="4" cols="30" required></textarea><br><br>

        <button type="submit" name="comment">Tambah Komentar</button>
    </form>
</body>
</html>
