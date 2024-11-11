<?php
include 'components/avatar.php';
include 'includes/functions.php';

session_start();

// if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
//     header('Location: login.php');
// }
$result = getAllUsers();
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
    <nav class="navbar bg-cream">
        <div class="">
            <img src="assets/icons/logo.png" alt="logo" class="mb-10">
            <div class="">
                <div class="mb-6">
                    <a href="admin.php" class="font-semibold">Dashboard</a>
                </div>
                <div class="">
                    <a href="manajemenUser.php" class="flex gap-4 items-center mb-6">
                        <div class="px-4 py-2 rounded-full border shadow bg-blue">
                            <img src="assets/icons/profile.svg" alt="Manajemen User">
                        </div>
                        <span class="font-semibold">Manajemen User</span>
                    </a>
                    <a href="manajemenPost.php" class="flex gap-4 items-center">
                        <div class="px-4 py-2 rounded-full border shadow bg-green">
                            <img src="assets/icons/post.svg" alt="Manajemen Post">
                        </div>
                        <span class="font-semibold">Manajemen Post</span>
                    </a>
                </div>
            </div>
        </div>
        <div>logout</div>
    </nav>
    <section>
        <h1 class="heading-2 mb-6">Manajemen User</h1>
        <div class="mb-6">
            <input type="text" class="p-6 rounded border shadow w-full" placeholder="Search users">
        </div>
        <div class="p-6 grid grid-cols-4 gap-6 rounded border shadow w-full">
            <?php if ($result): ?>
                <?php foreach ($result as $user): ?>
                    <div class="p-6 flex flex-column gap-6 justify-center items-center border shadow rounded">
                        <a href="" class="">
                            <?php
                            echo renderAvatar($user['username'], $user['photo']);
                            ?>
                        </a>
                        <a href="" class=" heading-2"><?= $user['fullname']; ?></a>
                        <div class=" font-semibold"><?= $user['nim']; ?></div>
                        <?php if ($user['status']): ?>
                            <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=delete" class="py-4 bg-red w-full text-center shadow border rounded">Delete Account</a>
                        <?php else: ?>
                            <div class="w-full flex items-center justify-between gap-6">
                                <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=approve" class="py-4 bg-green w-full text-center shadow border rounded">Approve</a>
                                <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=reject" class="py-4 bg-red w-full text-center shadow border rounded">Reject</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div>Belum Ada User</div>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>