<?php
include 'components/avatar.php';
include 'includes/functions.php';

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
    <!-- styles -->
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="stylesheet" href="css/admin.css">

    <title>Admin | Coms</title>
</head>

<body>
    <?php
    include 'components/navbarAdmin.php';
    ?>

    <section>
        <h1 class="heading-2 mb-6">Manajemen Post</h1>
        <div class="mb-10 p-6 rounded border shadow w-full">
            <h2 class="heading-2 mb-6">Detail Post</h2>
            <?php if ($post): ?>
                <article class="mb-6 w-full flex gap-6 bg-cream">
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
                            <div class="post-photo mb-10 p-1 rounded border shadow">
                                <img src="<?= $post['photo'] ?>" alt="post">
                            </div>
                        <?php endif; ?>
                        <div class="grid grid-cols-4">
                            <?php if ($post['status']): ?>
                                <a href="adminApprovePost.php?id=<?= $post['id'] ?>&status=delete" class="py-4 bg-red w-full text-center shadow border rounded" onclick="return confirm('Are you sure want to delete this post?')">Delete Post</a>
                            <?php else: ?>
                                <div class="w-full flex items-center justify-between gap-6">
                                    <a href="adminApprovePost.php?id=<?= $post['id'] ?>&status=approve" class="py-4 bg-green w-full text-center shadow border rounded" onclick="return confirm('Are you sure want to approve this post?')">Approve</a>
                                    <a href="adminApprovePost.php?id=<?= $post['id'] ?>&status=reject" class="py-4 bg-red w-full text-center shadow border rounded" onclick="return confirm('Are you sure want to reject this post?')">Reject</a>
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
</body>

</html>