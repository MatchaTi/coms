<?php
include 'includes/functions.php';
include 'components/avatar.php';

session_start();

$user = $_SESSION['user'];
if (!isset($user)) {
    header('Location: login.php');
}

$profileUser = getProfileUser($_GET['nim']);
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

    <!-- favicon -->
    <link rel="shortcut icon" href="favicon.svg" type="image/x-icon">

    <title><?= $profileUser['user']['username'] ?> | Issue Sedunia</title>
</head>

<body>
    <?php
    include 'components/navbar.php';
    include 'components/dialog.php';
    echo navbar();
    echo dialog();
    ?>
    <h2 class="heading text-center mb-6">Profile</h2>

    <?php if ($profileUser['status']): ?>
        <section class="profile mb-6 p-c cream border rounded-lg shadow">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h3 class="heading text-lg"><?= $profileUser['user']['fullname'] ?></h3>
                    <div><?= $profileUser['user']['username'] ?></div>
                </div>
                <?php
                echo renderAvatar($profileUser['user']['username'], $profileUser['user']['photo'], 'avatar-lg', 'Photo Profile');
                ?>
            </div>
            <div class="mb-2"><?= $profileUser['user']['bio'] ?></div>
            <div class="mb-6 text-sm">Joined <?= explode(' ', $profileUser['user']['joined_at'])[0] ?></div>
            <div class="mb-6 flex items-center gap-3">
                <?php if ($profileUser['user']['link_instagram']): ?>
                    <a href="<?= $profileUser['user']['link_instagram'] ?>" class="h-12 w-12 flex items-center justify-center rounded-full shadow border red">
                        <img src="assets/icons/instagram.svg" alt="Instagram">
                    </a>
                <?php endif; ?>
                <?php if ($profileUser['user']['link_facebook']): ?>
                    <a href="<?= $profileUser['user']['link_facebook'] ?>" class="h-12 w-12 flex items-center justify-center rounded-full shadow border orange">
                        <img src="assets/icons/facebook.svg" alt="Facebook">
                    </a>
                <?php endif; ?>
                <?php if ($profileUser['user']['link_github']): ?>
                    <a href="<?= $profileUser['user']['link_github'] ?>" class="h-12 w-12 flex items-center justify-center rounded-full shadow border yellow">
                        <img src="assets/icons/github.svg" alt="Github">
                    </a>
                <?php endif; ?>
                <?php if ($profileUser['user']['link_linkedin']): ?>
                    <a href="<?= $profileUser['user']['link_linkedin'] ?>" class="h-12 w-12 flex items-center justify-center rounded-full shadow border green">
                        <img src="assets/icons/linkedin.svg" alt="Linkedin">
                    </a>
                <?php endif; ?>
            </div>
            <?php if ($profileUser['user']['nim'] == $user['nim']): ?>
                <div class="flex w-full gap-3">
                    <a href="editProfile.php" class="btn w-full px-6 py-2 pink font-bold flex text-center justify-center border shadow rounded-lg">Edit Profile</a>
                    <a href="logout.php" class="btn w-full px-6 py-2 red font-bold flex text-center justify-center border shadow rounded-lg" onclick="return confirmPrompt(\'Logout\',\'Are you sure you want to logout?\', \'logout.php\')">Logout</a>
                </div>
            <?php endif; ?>
        </section>

        <h2 class="heading text-center mb-6">Posts</h2>
        <?php if ($profileUser['posts']): ?>
            <?php foreach ($profileUser['posts'] as $post): ?>
                <article class="flex gap-6 mb-6 <?= !$post['status'] ? "pending" : "" ?>">
                    <?php
                    echo renderAvatar($profileUser['user']['username'], $profileUser['user']['photo'], 'avatar', 'Photo Profile', 'post-avatar-desktop mt-3');
                    ?>
                    <div class="w-full cream shadow border rounded-lg">
                        <div class="p-c flex items-center justify-between border-b flex-wrap gap-3">
                            <div class="flex items-center gap-3">
                                <div class="post-avatar-mobile avatar white shadow border rounded-full">
                                    <img src="https://ui-avatars.com/api/?name=<?= $profileUser['user']['username'] ?>" alt="Avatar">
                                </div>
                                <h3 class="heading capitalize"><?= $profileUser['user']['username'] ?></h3>
                                <p class="text-sm"><?= explode(' ', $post['created_at'])[0]; ?></p>
                            </div>
                            <div class="flex items-center gap-3 flex-wrap">
                                <div class="capitalize px-6 py-1 font-medium border rounded shadow <?= $post['category']; ?>"><?= $post['category'] ?></div>
                                <?php if (!$post['status']): ?>
                                    <div class="capitalize px-4 py-1 font-medium border rounded shadow red"><?= !$post['status'] ? "Pending" : "" ?></div>
                                <?php endif; ?>
                                <button type="button" class="relative btn-floating w-10 h-10 flex items-center justify-center light-green border shadow rounded">
                                    <img src="assets/icons/menu.svg" alt="menu">
                                    <div class="floating-action cream border shadow rounded">
                                        <a href="editPost.php?id=<?= $post['id'] ?>" class="block px-6 py-2 font-medium border-b">Edit</a>
                                        <a href="deletePost.php?id=<?= $post['id'] ?>" class="block px-6 py-2 font-medium" onclick="return confirmPrompt('Delete Post','Are you sure want to delete this post?', 'deletePost.php?id=<?= $post['id'] ?>')">Delete</a>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="px-6 mt-6 mb-3">
                            <h3 class="px-6 py-4 heading border rounded shadow blue"><?= $post['title']; ?></h3>
                        </div>
                        <div class="px-6 text-justify"><?= $post['description']; ?></div>
                        <?php if ($post['photo']): ?>
                            <div class="px-6">
                                <div class="post-photo w-full rounded shadow border">
                                    <img src="<?= $post['photo'] ?>" alt="Post Image">
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="p-c flex items-center gap-3 flex-wrap">
                            <a href="post.php?id=<?= $post['id'] ?>" class="px-6 py-1 flex gap-1 font-medium border shadow rounded-full red">
                                <img src="assets/icons/comment.svg" alt="comment">
                                <div><?= $post['total_comments'] ?></div>
                            </a>
                            <div class="px-6 py-1 flex gap-1 font-medium border shadow rounded-full yellow">
                                <img src="assets/icons/views.svg" alt="views">
                                <div><?= $post['counter_views'] ?></div>
                            </div>
                            <button onclick="shareLink(<?= $post['id'] ?>)" class="share-btn px-6 py-1 flex gap-1 font-medium border shadow rounded-full green">
                                <img src="assets/icons/share.svg" alt="share">
                            </button>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif ?>
    <?php else: ?>
        <div class="text-center font-bold"><?= $profileUser['message'] ?></div>
    <?php endif; ?>

    <script src="js/script.js"></script>
    <script src="js/dialog.js"></script>
</body>

</html>