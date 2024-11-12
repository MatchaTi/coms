<?php
include 'components/avatar.php';
include 'includes/functions.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $caption = htmlspecialchars($_POST['caption']);
    $category = htmlspecialchars($_POST['category']);
    $photo = isset($_FILES['photo']) ? $_FILES['photo'] : null;

    $result = addPost($user['nim'], $title, $caption, $category, $photo);
    echo "<script>alert('" . $result['message'] . "')</script>";
}

$posts = getAllPosts()
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- styles -->
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="stylesheet" href="css/style.css">

    <title>Home</title>
</head>

<body>
    <?php
    include 'components/navbar.php';
    ?>
    <h2 class="mb-6 heading-2 text-center">Posts</h2>
    <button type="button" class="upload-btn mb-6 p-6 w-full flex gap-6 items-center rounded shadow border bg-cream">
        <?php
        echo renderAvatar($user['username'], $user['photo']);
        ?>
        <p class="font-semibold">What's the error you're stuck on? Let's solve it!</p>
    </button>

    <dialog class="dialog w-full">
        <div class="w-full flex gap-6 bg-cream rounded border shadow p-6">
            <?php
            echo renderAvatar($user['username'], $user['photo']);
            ?>
            <form action="" class="w-full" method="POST" enctype="multipart/form-data">
                <div class="mb-6 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div>
                            <div class="mb-1 heading-2"><?= $user['username'] ?></div>
                        </div>
                        <select class="px-6 py-3 rounded-full shadow border bg-pink" name="category">
                            <option value="1" selected>Front-End</option>
                            <option value="2">Back-End</option>
                            <option value="3">Fullstack</option>
                        </select>
                    </div>
                    <button type="button" class="py-2 px-2 rounded bg-blue border shadow">
                        <img src="assets/icons/arrow.svg" alt="arrow">
                    </button>
                </div>
                <input type="text" name="title" id="title" class="w-full mb-6 p-6 rounded shadow border bg-pink" placeholder="Title" required>
                <textarea name="caption" id="caption" class="mb-6 w-full leading-relaxed rounded shadow border bg-purple p-4" placeholder="Caption" rows="5" maxlength="255"></textarea>
                <input type="file" name="photo" id="photo" class="mb-6 w-full rounded shadow border bg-blue px-4 py-4">
                <div class="flex items-center gap-3">
                    <button type="submit" class="w-full py-4 rounded shadow border">Submit</button>
                </div>
            </form>

        </div>
    </dialog>

    <?php if ($posts): ?>
        <?php foreach ($posts as $post): ?>
            <article class="mb-6 p-6 w-full flex gap-6 rounded shadow border bg-cream">
                <?php
                echo renderAvatar($post['user']['username'], $post['user']['photo'])
                    ?>
                <div class="w-full">
                    <div class="mb-6 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div>
                                <div class="mb-1 heading-2"><?= $post['user']['username'] ?></div>
                                <div><?= explode(' ', $post['created_at'])[0] ?></div>
                            </div>
                            <div class="px-6 py-3 rounded-full shadow border bg-pink capitalize"><?= $post['category'] ?></div>
                        </div>
                        <div>
                            <img src="assets/icons/option.svg" alt="option">
                        </div>
                    </div>
                    <div class="mb-6 p-6 rounded shadow border bg-blue">
                        <h3 class="heading-2"><?= $post['title'] ?></h3>
                    </div>
                    <p class="mb-6 leading-relaxed"><?= $post['description'] ?></p>
                    <?php if ($post['photo']): ?>
                        <div class="post-photo mb-6 p-1 rounded border shadow">
                            <img src="<?= $post['photo'] ?>" alt="post">
                        </div>
                    <?php endif; ?>
                    <div class="flex items-center gap-3">
                        <div class="px-6 py-2 flex items-center gap-2 rounded-full border shadow bg-red">
                            <img src="assets/icons/comment.svg" alt="comment">
                            <span><?= $post['total_comments'] ?></span>
                        </div>
                        <div class="px-6 py-2 flex items-center gap-2 rounded-full border shadow bg-yellow">
                            <img src="assets/icons/view.svg" alt="view">
                            <span><?= $post['counter_views'] ?></span>
                        </div>
                        <div class="px-6 py-2 rounded-full border shadow bg-green">
                            <img src="assets/icons/share.svg" alt="share">
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center font-semibold">No posts!</div>
    <?php endif; ?>

    <script src="js/script.js"></script>
</body>

</html>