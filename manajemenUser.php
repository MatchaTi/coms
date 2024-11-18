<?php
include 'includes/connection.php';
include 'includes/functions.php';
include 'components/avatar.php';

session_start();

$user = $_SESSION['user'];
if (!isset($user) || $user['role'] == 'user') {
    header('Location: login.php');
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$result = getAllUsers(true, $page);

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

    <title>Admin | Coms</title>
</head>

<body>
    <?php
    include 'components/dialog.php';
    echo dialog();
    ?>
    <h2 class="heading mb-6">Manajemen User</h2>

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
        <form action="" class="mb-6" method="POST">
            <input type="text" name="name" class="p-c w-full cream rounded shadow border" placeholder="Search user...">
        </form>
        <div class="mb-10 p-6 grid grid-cols-4 gap-6 rounded border shadow w-full">
            <?php if ($result): ?>
                <?php foreach ($result as $user): ?>
                    <div class="p-6 flex flex-col gap-6 justify-between items-center border shadow rounded">
                        <a href="userDetail.php?nim=<?= $user['nim'] ?>" class="">
                            <?php
                            echo renderAvatar($user['username'], $user['photo']);
                            ?>
                        </a>
                        <a href="userDetail.php?nim=<?= $user['nim'] ?>" class="heading-2 text-center"><?= $user['fullname']; ?></a>
                        <a href="userDetail.php?nim=<?= $user['nim'] ?>" class="font-semibold"><?= $user['nim']; ?></a>
                        <?php if ($user['status']): ?>
                            <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=delete" class="py-4 red w-full text-center shadow border rounded" onclick="return confirmPrompt('Delete','Are you sure you want to delete this user?', 'adminApproveUser.php?nim=<?= $user['nim'] ?>&status=delete')">
                                <span class="font-bold">Delete</span>
                            </a>
                        <?php else: ?>
                            <div class="w-full flex items-center justify-between gap-6">
                                <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=approve" class="py-4 green w-full text-center shadow border rounded" onclick="return confirmPrompt('Approve','Are you sure you want to approve this user?', 'adminApproveUser.php?nim=<?= $user['nim'] ?>&status=approve')">
                                    <span class="font-bold">Approve</span>
                                </a>
                                <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=reject" class="py-4 red w-full text-center shadow border rounded" onclick="return confirmPrompt('Reject','Are you sure you want to reject this user?', 'adminApproveUser.php?nim=<?= $user['nim'] ?>&status=reject')">
                                    <span class="font-bold">Reject</span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="px-6 py-6">Belum Ada User</div>
            <?php endif; ?>
        </div>
        <div class="flex items-center justify-end">
            <div class="">
                <?php if ($page > 1): ?>
                    <a href="manajemenUser.php?page=<?= $page - 1; ?>" class="py-4 px-6 blue w-full text-center shadow border rounded">Previous</a>
                <?php endif; ?>
                <?php if ($result): ?>
                    <a href="manajemenUser.php?page=<?= $page + 1; ?>" class="py-4 px-6 blue w-full text-center shadow border rounded">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <script src="js/script.js"></script>
    <script src="js/dialog.js"></script>
    <script src="js/navbar.js"></script>
    <script src="js/admin.js"></script>
</body>

</html>