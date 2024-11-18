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
    echo navbar();
    ?>
    <h2 class="heading text-center mb-6">Profile</h2>

    <div class="music-container hidden p-c cream border shadow rounded-lg">
        <h2 class="font-bold mb-6">Soundboard</h2>
    </div>

    <dialog class="dialog cream shadow border rounded-lg">
        <div class="p-c border-b grid grid-cols-3">
            <div class="flex gap-3 items-center">
                <div class="w-5 h-5 rounded-full shadow border red"></div>
                <div class="w-5 h-5 rounded-full shadow border yellow"></div>
                <div class="w-5 h-5 rounded-full shadow border green"></div>
            </div>
            <h2 class="text-center font-bold">New Post</h2>
            <button type="button" class="cancel-post text-end font-medium">Cancel</button>
        </div>
        <div class="p-c flex gap-6">
            <div class="avatar white rounded-full shadow border"></div>
            <form action="" class="w-full" enctype="multipart/form-data" method="POST">
                <div class="mb-6">
                    <label for="kategori" class="heading block mb-2">Category</label>
                    <select name="kategori" id="kategori" class="px-6 py-2 purple rounded shadow border w-full">
                        <option value="Front-End" selected>Front-End</option>
                        <option value="Back-End">Back-End</option>
                        <option value="Full-Stack">Full-Stack</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="title" class="heading block mb-2">Title Post</label>
                    <input type="text" name="title" id="title" placeholder="Raana! What's new?" class="w-full blue p-c rounded-lg border shadow">
                </div>
                <div class="mb-6">
                    <label for="description" class="heading block mb-2">Description Post</label>
                    <input type="text" name="description" id="description" placeholder="What's your describe about this post" class="w-full yellow p-c rounded-lg border shadow">
                </div>
                <div class="mb-10">
                    <label for="photoPost" class="heading block mb-2">Photo Post</label>
                    <input type="file" name="photoPost" id="photoPost" class="mb-6 w-full light-green p-c rounded-lg border shadow">
                    <button type="button" class="btn px-4 py-2 red rounded shadow border font-medium">Delete Photo Post</button>
                </div>
                <button type="submit" class="btn auth w-full px-6 font-bold py-2 flex text-center justify-center border shadow rounded-lg">Post</button>
            </form>
        </div>
    </dialog>

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
            <div class="mb-6 text-sm">Joined <?= explode(' ', $profileUser['user']['created_at'])[0] ?></div>
            <?php if ($profileUser['user']['id'] == $user['id']): ?>
                <div class="flex w-full gap-3">
                    <a href="editProfile.php" class="btn w-full px-6 py-2 pink font-bold flex text-center justify-center border shadow rounded-lg">Edit Profile</a>
                    <a href="logout.php" class="btn w-full px-6 py-2 red font-bold flex text-center justify-center border shadow rounded-lg" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
                </div>
            <?php endif; ?>
        </section>

        <h2 class="heading text-center mb-6">Posts</h2>
        <?php if ($profileUser['posts']): ?>
            <?php foreach ($profileUser['posts'] as $post): ?>
                <article class="flex gap-6 mb-6">
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
                                <div class="px-6 py-1 font-medium border rounded shadow <?= $post['isSolve'] ? 'green' : 'red' ?>"><?= $post['isSolve'] ? 'Solved' : 'Not Solve'; ?></div>
                                <?php if ($user['id'] == $post['user_id']): ?>
                                    <div class="w-10 h-10 flex items-center justify-center light-green border shadow rounded">
                                        <img src="assets/icons/menu.svg" alt="menu">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <h3 class="px-6 py-4 heading"><?= $post['title']; ?></h3>
                        <div class="px-6 text-justify"><?= $post['content']; ?></div>
                        <?php if ($post['photo']): ?>
                            <div class="px-6">
                                <div class="post-photo w-full rounded shadow border">
                                    <img src="<?= $post['photo'] ?>" alt="Post Image">
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="p-c flex items-center gap-3 flex-wrap">
                            <a href="post.php?id=<?= $post['id'] ?>" class="px-6 py-1 flex gap-1 font-medium border shadow rounded pink">
                                <img src="assets/icons/comment.svg" alt="comment">
                                <div><?= $post['comment_count'] ?></div>
                            </a>
                            <div class="px-6 py-1 flex gap-1 font-medium border shadow rounded blue">
                                <img src="assets/icons/views.svg" alt="views">
                                <div><?= $post['watching_counter'] ?></div>
                            </div>
                            <button onclick="shareLink(<?= $post['id'] ?>)" class="share-btn px-6 py-1 flex gap-1 font-medium border shadow rounded green">
                                <img src="assets/icons/share.svg" alt="share">
                                <div><?= $post['watching_counter'] ?></div>
                            </button>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif ?>
    <?php else: ?>
        <div class="text-center font-bold"><?= $profileUser['message'] ?></div>
    <?php endif; ?>

    <script src="js/music.js"></script>
    <script src="js/script.js"></script>
</body>

</html>