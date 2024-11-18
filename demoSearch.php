<?php
require 'includes/connection.php';
require 'includes/functions.php';


if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $searchResults = search($conn, $keyword);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian</title>
</head>

<body>
    <h1>Pencarian Username dan Judul Postingan</h1>

    <form action="" method="POST">
        <label for="keyword">Kata Kunci:</label>
        <input type="text" id="keyword" name="keyword" required>
        <button type="submit" name="search">Cari</button>
    </form>

    <?php if (isset($searchResults)): ?>
        <h2>Hasil Pencarian untuk "<?php echo htmlspecialchars($keyword); ?>"</h2>

        <h3>Pengguna:</h3>
        <?php if (count($searchResults['users']) > 0): ?>
            <ul>
                <?php foreach ($searchResults['users'] as $user): ?>
                    <li>
                        Username: <?php echo htmlspecialchars($user['username']); ?> -
                        Nama Lengkap: <?php echo htmlspecialchars($user['fullname']); ?> -
                        Email: <?php echo htmlspecialchars($user['email']); ?> -
                        Biografi: <?php echo htmlspecialchars($user['bio']); ?> -
                        Role: <?php echo htmlspecialchars($user['role']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Tidak ada pengguna dengan username yang sesuai.</p>
        <?php endif; ?>

        <h3>Postingan:</h3>
        <?php if (count($searchResults['posts']) > 0): ?>
            <ul>
                <?php foreach ($searchResults['posts'] as $post): ?>
                    <li>
                        Judul: <?php echo htmlspecialchars($post['title']); ?> <br>
                        Konten: <?php echo htmlspecialchars($post['content']); ?> <br>
                        Penulis: <?php echo htmlspecialchars($post['author_username']); ?> (<?php echo htmlspecialchars($post['author_fullname']); ?>) <br>
                        jumlah lihat : <?php echo htmlspecialchars($post['watching_counter']); ?> <br>
                        jumlah share : <?php echo htmlspecialchars($post['share_counter']); ?> <br>
                        Jumlah Komentar: <?php echo htmlspecialchars($post['comment_count']); ?> <br>
                        <?php
                        if ($post['photo']) {
                            ?>
                            <img src="<?php echo $post['photo'] ?>" alt="">
                        <?php
                        } else {
                            ?>
                            Ga ada gambar bah <br>
                        <?php
                        }
                        ?>
                        Tanggal Dibuat: <?php echo htmlspecialchars($post['created_at']); ?> <br>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Tidak ada postingan dengan judul yang sesuai.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>