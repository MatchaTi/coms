<?php

require 'includes/connection.php';
require 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = 8; //sembarang aja bah. tapi nnt pake session['user]['id'] aja

    $categoryId = $_POST['category'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imgFile = isset($_FILES['img']) ? $_FILES['img'] : null;

    $result = addPost($conn, $userId, $categoryId, $title, $content, $imgFile);
    echo "<script>alert('" . $result['message'] . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Postingan</title>
</head>
<body>
    <h1>Tambah Postingan Baru</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="category">Kategori:</label>
        <select name="category" id="category" required>
            <option value="1">Front-end</option>
            <option value="2">Back-end</option>
            <option value="3">Full-stack</option>
        </select><br><br>

        <label for="title">Judul:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="content">Konten:</label><br>
        <textarea id="content" name="content" rows="5" cols="30" required></textarea><br><br>

        <label for="img">Gambar (Optional, Max 2MB):</label>
        <input type="file" id="img" name="img" accept="image/jpeg, image/png, image/gif"><br><br>

        <button type="submit">Tambah Postingan</button>
    </form>
</body>

</html>
