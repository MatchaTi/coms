<?php
include 'includes/connection.php';
include 'includes/functions.php';
include 'components/avatar.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
}

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$post = getSinglePost($id);
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
    <link rel="stylesheet" href="css/admin.css">

    <!-- favicon -->
    <link rel="shortcut icon" href="favicon.svg" type="image/x-icon">

    <title>Post Detail | Coms</title>
</head>

<body>
    <?php
    include 'components/dialog.php';
    echo dialog();
    ?>
    <h2 class="heading mb-6">Post Detail</h2>

    <nav class="px-4 navbar cream shadow border rounded-full">
        <div class="w-full">
            <a href="index.php" class="logo rounded-full mb-6">
                <img src="assets/icons/logo.png" alt="logo">
            </a>
            <div class="">
                <a href="admin.php" class="dashboard mb-6 px-6 py-3 flex gap-3 items-center border shadow rounded-full yellow">
                    <img src="assets/icons/dashboard.svg" alt="Dashboard">
                    <span class="font-bold">Dashboard</span>
                </a>
                <a href="manajemenUser.php" class="profile mb-6 px-6 py-3 flex gap-3 items-center rounded-full">
                    <img src="assets/icons/profile.svg" alt="Profile">
                    <span class="font-bold">Manajemen User</span>
                </a>
                <a href="manajemenPost.php" class="posts mb-6 px-6 py-3 flex gap-3 items-center rounded-full">
                    <img src="assets/icons/post.svg" alt="Posts">
                    <span class="font-bold">Manajemen Post</span>
                </a>
            </div>
        </div>
        <div>
            <a href="logout.php" class="logout setting-icon setting px-6 py-3 flex items-center gap-3 rounded-full" onclick="return confirmPrompt('Logout','Are you sure you want to logout?', 'logout.php')">
                <img src="assets/icons/logout.svg" alt="logout">
                <span class="font-bold">Logout</span>
            </a>
        </div>
    </nav>

    <section class="h-full">
        <div class="mb-10 p-6 rounded border shadow w-full">
            <?php if ($post): ?>
                <article class="mb-6 w-full flex gap-6 cream">
                    <?php
                    echo renderAvatar($post['user']['username'], $post['user']['photo'])
                        ?>
                    <div class="w-full">
                        <div class="mb-6 flex items-center justify-between gap-6">
                            <div class="flex items-center gap-6">
                                <div>
                                    <div class="mb-1 heading-2"><?= $post['user']['username'] ?></div>
                                    <div><?= explode(' ', $post['created_at'])[0] ?></div>
                                </div>
                                <div class="px-6 py-3 rounded-full shadow border pink capitalize"><?= $post['category'] ?></div>
                            </div>
                        </div>
                        <div class="mb-6 p-6 rounded shadow border blue">
                            <h3 class="heading-2"><?= $post['title'] ?></h3>
                        </div>
                        <p class="mb-6 leading-relaxed"><?= $post['description'] ?></p>
                        <?php if ($post['photo']): ?>
                            <div class="post-photo mb-10 p-1 rounded border shadow">
                                <img src="<?= $post['photo'] ?>" alt="post">
                            </div>
                        <?php endif; ?>
                        <div class="grid grid-cols-4">
                            <?php if ($post['status']): ?>
                                <a href="adminApprovePost.php?id=<?= $post['id'] ?>&status=delete" class="py-4 red w-full text-center shadow border rounded" onclick="return confirmPrompt('Delete','Are you sure you want to delete this post?', 'adminApprovePost.php?id=<?= $post['id'] ?>&status=delete')">
                                    <span class="font-bold">Delete</span>
                                </a>
                            <?php else: ?>
                                <div class="w-full flex items-center justify-between gap-6">
                                    <a href="adminApprovePost.php?id=<?= $post['id'] ?>&status=approve" class="py-4 green w-full text-center shadow border rounded" onclick="return confirmPrompt('Approve','Are you sure you want to approve this post?', 'adminApprovePost.php?id=<?= $post['id'] ?>&status=approve')">
                                        <span class="font-bold">Approve</span>
                                    </a>
                                    <a href="adminApprovePost.php?id=<?= $post['id'] ?>&status=reject" class="py-4 red w-full text-center shadow border rounded" onclick="return confirmPrompt('Reject','Are you sure you want to reject this post?', 'adminApprovePost.php?id=<?= $post['id'] ?>&status=reject')">
                                        <span class="font-bold">Reject</span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php else: ?>
                <div>Post tidak ditemukan</div>
            <?php endif; ?>
        </div>
    </section>

    <script src="js/script.js"></script>
    <script src="js/dialog.js"></script>
    <script src="js/navbar.js"></script>
    <script src="js/admin.js"></script>
</body>

</html>