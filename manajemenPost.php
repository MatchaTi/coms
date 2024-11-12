<?php
include 'components/avatar.php';
include 'includes/functions.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$result = getAllPosts(true, $page);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $result = searchUser($name);
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

    <section>
        <h1 class="heading-2 mb-6">Manajemen Post</h1>
        <form action="" class="mb-6" method="POST">
            <input type="text" name="name" class="p-6 rounded border shadow w-full" placeholder="Search posts">
        </form>
        <div class="mb-10 grid rounded border shadow w-full">
            <div class="p-6 grid grid-cols-4 items-center border-b">
                <div class="font-bold">Author</div>
                <div class="font-bold">Title</div>
                <div class="font-bold">Tags</div>
                <div class="font-bold">Action</div>
            </div>
            <?php if ($result): ?>
                <?php foreach ($result as $post): ?>
                    <div class="p-6 grid grid-cols-4 items-center border-b">
                        <a href="userDetail.php?nim=<?= $post['user']['nim'] ?>"><?= $post['user']['username'] ?></a>
                        <a href="postDetail.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                        <div class="capitalize"><?= $post['category'] ?></div>
                        <?php if ($post['status']): ?>
                            <a href="adminApprovePost.php?id=<?= $post['id'] ?>&status=delete" class="py-4 bg-red w-full text-center shadow border rounded" onclick="return confirm('Are you sure want to delete this post?')">Delete Post</a>
                        <?php else: ?>
                            <div class="w-full flex items-center justify-between gap-6">
                                <a href="adminApprovePost.php?id=<?= $post['id'] ?>&status=approve" class="py-4 bg-green w-full text-center shadow border rounded" onclick="return confirm('Are you sure want to approve this post?')">Approve</a>
                                <a href="adminApprovePost.php?id=<?= $post['id'] ?>&status=reject" class="py-4 bg-red w-full text-center shadow border rounded" onclick="return confirm('Are you sure want to reject this post?')">Reject</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="px-4 py-4">Belum Ada Post</div>
            <?php endif; ?>
        </div>
        <div class="flex items-center justify-end">
            <div class="">
                <?php if ($page > 1): ?>
                    <a href="manajemenPost.php?page=<?= $page - 1; ?>" class="py-4 px-6 bg-blue w-full text-center shadow border rounded">Previous</a>
                <?php endif; ?>
                <?php if ($result): ?>
                    <a href="manajemenPost.php?page=<?= $page + 1; ?>" class="py-4 px-6 bg-blue w-full text-center shadow border rounded">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>

</html>